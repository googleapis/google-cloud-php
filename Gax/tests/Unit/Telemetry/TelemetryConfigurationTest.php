<?php

/*
 * Copyright 2026 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore\Tests\Unit\Telemetry;

use Google\ApiCore\Telemetry\TelemetryConfiguration;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use PHPUnit\Framework\TestCase;

class TelemetryConfigurationTest extends TestCase
{
    private $originalEnv;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalEnv = getenv('GOOGLE_SDK_PHP_TRACING_ENABLED');
    }

    protected function tearDown(): void
    {
        if ($this->originalEnv !== false) {
            putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=' . $this->originalEnv);
        } else {
            putenv('GOOGLE_SDK_PHP_TRACING_ENABLED');
        }
        parent::tearDown();
    }

    public function testIsTracingEnabledDefault()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED');
        $this->assertFalse(TelemetryConfiguration::isTracingEnabled());
    }

    public function testIsTracingEnabledTrue()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=true');
        $this->assertTrue(TelemetryConfiguration::isTracingEnabled());
    }

    public function testIsTracingEnabledFalse()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=false');
        $this->assertFalse(TelemetryConfiguration::isTracingEnabled());
    }

    public function testIsTracingEnabledWithExplicitProviderWhenUnset()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED');
        $mockProvider = $this->createMock(TracerProviderInterface::class);
        $this->assertTrue(TelemetryConfiguration::isTracingEnabled($mockProvider));
    }

    public function testIsTracingEnabledWithExplicitProviderWhenDisabled()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=false');
        $mockProvider = $this->createMock(TracerProviderInterface::class);
        $this->assertFalse(TelemetryConfiguration::isTracingEnabled($mockProvider));
    }

    public function testResolveTracerProviderDefault()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED');
        $this->assertNull(TelemetryConfiguration::resolveTracerProvider());
    }

    public function testResolveTracerProviderExplicitWhenUnset()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED');
        $mockProvider = $this->createMock(TracerProviderInterface::class);
        $this->assertSame($mockProvider, TelemetryConfiguration::resolveTracerProvider($mockProvider));
    }

    /**
     * @dataProvider disabledValuesProvider
     */
    public function testResolveTracerProviderGlobalVeto($value)
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=' . $value);
        $mockProvider = $this->createMock(TracerProviderInterface::class);
        $this->assertNull(TelemetryConfiguration::resolveTracerProvider($mockProvider));
    }

    public function disabledValuesProvider()
    {
        return [
            ['false'],
            ['0'],
            ['no'],
            ['off'],
        ];
    }

    /**
     * @dataProvider enabledValuesProvider
     */
    public function testResolveTracerProviderAutoDiscovery($value)
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=' . $value);
        $mockProvider = $this->createMock(TracerProviderInterface::class);
        $this->assertSame($mockProvider, TelemetryConfiguration::resolveTracerProvider($mockProvider));

        $resolved = TelemetryConfiguration::resolveTracerProvider();
        if (class_exists(Globals::class)) {
            $this->assertSame(Globals::tracerProvider(), $resolved);
        } else {
            $this->assertNull($resolved);
        }
    }

    public function enabledValuesProvider()
    {
        return [
            ['true'],
            ['1'],
            ['yes'],
            ['on'],
        ];
    }

    public function testResolveTracerProviderEmptyStringDoesNotVeto()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=');
        $mockProvider = $this->createMock(TracerProviderInterface::class);
        $this->assertSame($mockProvider, TelemetryConfiguration::resolveTracerProvider($mockProvider));
        $this->assertNull(TelemetryConfiguration::resolveTracerProvider());
    }

    public function testIsTracingEnabledEmptyString()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=');
        $this->assertFalse(TelemetryConfiguration::isTracingEnabled());

        $mockProvider = $this->createMock(TracerProviderInterface::class);
        $this->assertTrue(TelemetryConfiguration::isTracingEnabled($mockProvider));
    }
}
