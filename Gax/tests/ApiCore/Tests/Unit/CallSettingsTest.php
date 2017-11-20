<?php
/*
 * Copyright 2016, Google Inc.
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
namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\CallSettings;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\ValidationException;
use PHPUnit\Framework\TestCase;

class CallSettingsTest extends TestCase
{
    const SERVICE_NAME = 'test.interface.v1.api';

    private static function buildInputConfig()
    {
        $contents = file_get_contents(__DIR__ . '/testdata/test_service_client_config.json');
        return json_decode($contents, true);
    }

    private static function buildInvalidInputConfig()
    {
        $contents = file_get_contents(__DIR__ . '/testdata/test_service_invalid_client_config.json');
        return json_decode($contents, true);
    }


    public function testConstructSettings()
    {
        $inputConfig = CallSettingsTest::buildInputConfig();

        $defaultCallSettings =
                CallSettings::load(
                    CallSettingsTest::SERVICE_NAME,
                    $inputConfig,
                    []
                );
        $simpleMethod = $defaultCallSettings['simpleMethod'];
        $this->assertTrue($simpleMethod->getRetrySettings()->retriesEnabled());
        $this->assertEquals(40000, $simpleMethod->getRetrySettings()->getNoRetriesRpcTimeoutMillis());
        $simpleMethodRetry = $simpleMethod->getRetrySettings();
        $this->assertEquals(['DEADLINE_EXCEEDED', 'UNAVAILABLE'], $simpleMethodRetry->getRetryableCodes());
        $this->assertEquals(100, $simpleMethodRetry->getInitialRetryDelayMillis());
        $pageStreamingMethod = $defaultCallSettings['pageStreamingMethod'];
        $pageStreamingMethodRetry = $pageStreamingMethod->getRetrySettings();
        $this->assertEquals(['INTERNAL'], $pageStreamingMethodRetry->getRetryableCodes());
        $timeoutOnlyMethod = $defaultCallSettings['timeoutOnlyMethod'];
        $timeoutOnlyMethodRetry = $timeoutOnlyMethod->getRetrySettings();
        $this->assertFalse($timeoutOnlyMethodRetry->retriesEnabled());
        $this->assertEquals(40000, $timeoutOnlyMethodRetry->getNoRetriesRpcTimeoutMillis());
    }

    /**
     * @expectedException \Google\ApiCore\ValidationException
     */
    public function testLoadInvalid()
    {
        $inputConfig = CallSettingsTest::buildInvalidInputConfig();
        CallSettings::load(
            CallSettingsTest::SERVICE_NAME,
            $inputConfig,
            []
        );
    }

    public function testConstructSettingsOverride()
    {
        $inputConfig = CallSettingsTest::buildInputConfig();

        // Turn off retries for simpleMethod
        $retryingOverride = [
            'simpleMethod' => [
                'retriesEnabled' => false,
            ],
            'timeoutOnlyMethod' => [
                'noRetriesRpcTimeoutMillis' => 20000
            ]
        ];
        $defaultCallSettings =
                CallSettings::load(
                    CallSettingsTest::SERVICE_NAME,
                    $inputConfig,
                    $retryingOverride
                );
        $simpleMethod = $defaultCallSettings['simpleMethod'];
        $this->assertFalse($simpleMethod->getRetrySettings()->retriesEnabled());
        $this->assertEquals(40000, $simpleMethod->getRetrySettings()->getNoRetriesRpcTimeoutMillis());
        $pageStreamingMethod = $defaultCallSettings['pageStreamingMethod'];
        $pageStreamingMethodRetry = $pageStreamingMethod->getRetrySettings();
        $this->assertEquals(['INTERNAL'], $pageStreamingMethodRetry->getRetryableCodes());
        $timeoutOnlyMethod = $defaultCallSettings['timeoutOnlyMethod'];
        $timeoutOnlyMethodRetry = $timeoutOnlyMethod->getRetrySettings();
        $this->assertFalse($timeoutOnlyMethodRetry->retriesEnabled());
        $this->assertEquals(20000, $timeoutOnlyMethodRetry->getNoRetriesRpcTimeoutMillis());
    }

    public function testMergeEmpty()
    {
        $settings = [
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 500,
            'totalTimeoutMillis' => 2000,
            'noRetriesRpcTimeoutMillis' => 10,
            'retryableCodes' => ['DEADLINE_EXCEEDED', 'UNAVAILABLE']
        ];

        $retrySettings = new RetrySettings($settings);
        $callSettings = new CallSettings(['retrySettings' => $retrySettings]);
        $emptySettings = new CallSettings([]);
        $mergedSettings = $callSettings->merge($emptySettings);
        $this->assertEquals(10, $mergedSettings->getRetrySettings()->getNoRetriesRpcTimeoutMillis());
        $this->assertEquals(
            ['DEADLINE_EXCEEDED', 'UNAVAILABLE'],
            $mergedSettings->getRetrySettings()->getRetryableCodes()
        );
    }

    public function testMerge()
    {
        $settings = [
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 500,
            'totalTimeoutMillis' => 2000,
            'noRetriesRpcTimeoutMillis' => 10,
            'retryableCodes' => ['DEADLINE_EXCEEDED', 'UNAVAILABLE']
        ];

        $otherSettings = [
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 500,
            'totalTimeoutMillis' => 2000,
            'noRetriesRpcTimeoutMillis' => 20,
            'retryableCodes' => ['INTERNAL']
        ];

        $retrySettings = new RetrySettings($settings);
        $settings = new CallSettings(['retrySettings' => $retrySettings]);
        $otherRetrySettings = new RetrySettings($otherSettings);
        $otherSettings = new CallSettings(['retrySettings' => $otherRetrySettings]);
        $mergedSettings = $settings->merge($otherSettings);
        $this->assertEquals(20, $mergedSettings->getRetrySettings()->getNoRetriesRpcTimeoutMillis());
        $this->assertEquals(['INTERNAL'], $mergedSettings->getRetrySettings()->getRetryableCodes());
    }
}
