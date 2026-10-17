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

namespace Google\ApiCore\Telemetry;

use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\TracerProviderInterface;

/**
 * Parses and provides telemetry configuration from environment variables.
 *
 * @internal
 */
class TelemetryConfiguration
{
    private const ENV_TRACING_ENABLED = 'GOOGLE_SDK_PHP_TRACING_ENABLED';

    /**
     * Determine if tracing is enabled based on the environment variables and explicit options.
     *
     * @param TracerProviderInterface|null $explicitProvider
     * @return bool
     */
    public static function isTracingEnabled(?TracerProviderInterface $explicitProvider = null): bool
    {
        return self::resolveTracerProvider($explicitProvider) !== null;
    }

    /**
     * Resolves the TracerProvider based on environment variables and explicit options.
     *
     * Precedence:
     * 1. Global Veto: If GOOGLE_SDK_PHP_TRACING_ENABLED is explicitly false, return null.
     * 2. Auto-Discovery: If GOOGLE_SDK_PHP_TRACING_ENABLED is explicitly true, return
     *    $explicitProvider ?? (Globals::tracerProvider() if available).
     * 3. Explicit Provider: If unset, return $explicitProvider.
     * 4. Default: Return null.
     *
     * @param TracerProviderInterface|null $explicitProvider
     * @return TracerProviderInterface|null
     */
    public static function resolveTracerProvider(
        ?TracerProviderInterface $explicitProvider = null
    ): ?TracerProviderInterface {
        $env = getenv(self::ENV_TRACING_ENABLED);
        if ($env !== false && $env !== '') {
            $isExplicitlyDisabled = filter_var($env, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === false;
            if ($isExplicitlyDisabled) {
                return null;
            }

            $isExplicitlyEnabled = filter_var($env, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === true;
            if ($isExplicitlyEnabled) {
                if ($explicitProvider !== null) {
                    return $explicitProvider;
                }
                if (class_exists(Globals::class)) {
                    return Globals::tracerProvider();
                }
                return null;
            }
        }

        return $explicitProvider;
    }
}
