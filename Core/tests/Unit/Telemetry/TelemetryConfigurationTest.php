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

namespace Google\Cloud\Core\Tests\Unit\Telemetry;

use Google\Cloud\Core\Telemetry\TelemetryConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group telemetry
 */
class TelemetryConfigurationTest extends TestCase
{
    private $originalTracingEnabled;
    private $originalLoggingEnabled;
    private $originalMetricsEnabled;
    private $originalLegacyTelemetry;

    public function setUp(): void
    {
        $this->originalTracingEnabled = getenv('GOOGLE_SDK_PHP_TRACING_ENABLED');
        $this->originalLoggingEnabled = getenv('GOOGLE_SDK_PHP_LOGGING_ENABLED');
        $this->originalMetricsEnabled = getenv('GOOGLE_SDK_PHP_METRICS_ENABLED');
        $this->originalLegacyTelemetry = getenv('GOOGLE_API_ENABLE_TELEMETRY');
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED');
        putenv('GOOGLE_SDK_PHP_LOGGING_ENABLED');
        putenv('GOOGLE_SDK_PHP_METRICS_ENABLED');
        putenv('GOOGLE_API_ENABLE_TELEMETRY');
    }

    public function tearDown(): void
    {
        if ($this->originalTracingEnabled !== false) {
            putenv("GOOGLE_SDK_PHP_TRACING_ENABLED={$this->originalTracingEnabled}");
        }
        if ($this->originalLoggingEnabled !== false) {
            putenv("GOOGLE_SDK_PHP_LOGGING_ENABLED={$this->originalLoggingEnabled}");
        }
        if ($this->originalMetricsEnabled !== false) {
            putenv("GOOGLE_SDK_PHP_METRICS_ENABLED={$this->originalMetricsEnabled}");
        }
        if ($this->originalLegacyTelemetry !== false) {
            putenv("GOOGLE_API_ENABLE_TELEMETRY={$this->originalLegacyTelemetry}");
        }
    }

    public function testIsTracingEnabledDefaultFalse()
    {
        $this->assertFalse(TelemetryConfiguration::isTracingEnabled());
    }

    public function testIsTracingEnabledWithSpecificEnv()
    {
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=true');
        $this->assertTrue(TelemetryConfiguration::isTracingEnabled());

        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=false');
        $this->assertFalse(TelemetryConfiguration::isTracingEnabled());
    }

    public function testIsTracingEnabledWithLegacyEnv()
    {
        putenv('GOOGLE_API_ENABLE_TELEMETRY=true');
        $this->assertTrue(TelemetryConfiguration::isTracingEnabled());

        putenv('GOOGLE_API_ENABLE_TELEMETRY=false');
        $this->assertFalse(TelemetryConfiguration::isTracingEnabled());
    }

    public function testIsTracingEnabledPrecedence()
    {
        // Specific flag takes precedence over legacy flag
        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=false');
        putenv('GOOGLE_API_ENABLE_TELEMETRY=true');
        $this->assertFalse(TelemetryConfiguration::isTracingEnabled());

        putenv('GOOGLE_SDK_PHP_TRACING_ENABLED=true');
        putenv('GOOGLE_API_ENABLE_TELEMETRY=false');
        $this->assertTrue(TelemetryConfiguration::isTracingEnabled());
    }

    public function testIsLoggingEnabledPrecedence()
    {
        putenv('GOOGLE_SDK_PHP_LOGGING_ENABLED=false');
        putenv('GOOGLE_API_ENABLE_TELEMETRY=true');
        $this->assertFalse(TelemetryConfiguration::isLoggingEnabled());

        putenv('GOOGLE_SDK_PHP_LOGGING_ENABLED=true');
        putenv('GOOGLE_API_ENABLE_TELEMETRY=false');
        $this->assertTrue(TelemetryConfiguration::isLoggingEnabled());
    }

    public function testIsMetricsEnabledPrecedence()
    {
        putenv('GOOGLE_SDK_PHP_METRICS_ENABLED=false');
        putenv('GOOGLE_API_ENABLE_TELEMETRY=true');
        $this->assertFalse(TelemetryConfiguration::isMetricsEnabled());

        putenv('GOOGLE_SDK_PHP_METRICS_ENABLED=true');
        putenv('GOOGLE_API_ENABLE_TELEMETRY=false');
        $this->assertTrue(TelemetryConfiguration::isMetricsEnabled());
    }
}
