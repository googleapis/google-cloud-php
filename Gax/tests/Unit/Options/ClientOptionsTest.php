<?php
/**
 * Copyright 2026 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\ApiCore\Tests\Unit\Options;

use Google\ApiCore\Options\ClientOptions;
use PHPUnit\Framework\TestCase;
use OpenTelemetry\API\Logs\LoggerProviderInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;

class ClientOptionsTest extends TestCase
{
    public function testSetAndGetTracerProvider()
    {
        $openTelemetryTracerProvider = $this->createMock(TracerProviderInterface::class);
        $options = new ClientOptions([]);
        $options->setOpenTelemetryTracerProvider($openTelemetryTracerProvider);
        $this->assertSame($openTelemetryTracerProvider, $options->getOpenTelemetryTracerProvider());
    }

    public function testSetAndGetLoggerProvider()
    {
        $openTelemetryLoggerProvider = $this->createMock(LoggerProviderInterface::class);
        $options = new ClientOptions([]);
        $options->setOpenTelemetryLoggerProvider($openTelemetryLoggerProvider);
        $this->assertSame($openTelemetryLoggerProvider, $options->getOpenTelemetryLoggerProvider());
    }
    
    public function testConstructorInjection()
    {
        $openTelemetryTracerProvider = $this->createMock(TracerProviderInterface::class);
        $openTelemetryLoggerProvider = $this->createMock(LoggerProviderInterface::class);
        
        $options = new ClientOptions([
            'openTelemetryTracerProvider' => $openTelemetryTracerProvider,
            'openTelemetryLoggerProvider' => $openTelemetryLoggerProvider,
        ]);
        
        $this->assertSame($openTelemetryTracerProvider, $options->getOpenTelemetryTracerProvider());
        $this->assertSame($openTelemetryLoggerProvider, $options->getOpenTelemetryLoggerProvider());
    }
}
