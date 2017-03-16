<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Tests\System\Logging;

use Google\Cloud\Core\ExponentialBackoff;

/**
 * @group logging
 */
class WriteAndListEntryTest extends LoggingTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testWriteTextEntry($client)
    {
        $logger = $client->logger(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue[] = $logger;
        $data = 'test';
        $entry = $logger->entry($data);

        $logger->write($entry);

        $backoff = new ExponentialBackoff(8);
        $entries = $backoff->execute(function () use ($logger) {
            $entries = iterator_to_array($logger->entries());

            if (count($entries) === 0) {
                throw new \Exception();
            }

            return $entries;
        });

        $this->assertEquals($data, $entries[0]->info()['textPayload']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWriteJsonEntry($client)
    {
        $logger = $client->logger(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue[] = $logger;
        $data = [
            'test' => true,
            'hello' => 'world',
            'some' => [
                'data'
            ]
        ];

        $entry = $logger->entry($data);

        $logger->write($entry);

        $backoff = new ExponentialBackoff(8);
        $entries = $backoff->execute(function () use ($logger) {
            $entries = iterator_to_array($logger->entries());

            if (count($entries) === 0) {
                throw new \Exception();
            }

            return $entries;
        });

        $this->assertEquals($data, $entries[0]->info()['jsonPayload']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesMultipleTextEntries($client)
    {
        $logger = $client->logger(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue[] = $logger;
        $data = 'test';
        $entriesToWrite = [
            $logger->entry($data),
            $logger->entry($data)
        ];

        $logger->writeBatch($entriesToWrite);

        $backoff = new ExponentialBackoff(8);
        $entries = $backoff->execute(function () use ($entriesToWrite, $logger) {
            $entries = iterator_to_array($logger->entries());

            if (count($entries) !== count($entriesToWrite)) {
                throw new \Exception();
            }

            return $entries;
        });

        $this->assertEquals($data, $entries[0]->info()['textPayload']);
        $this->assertEquals($data, $entries[1]->info()['textPayload']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesEntryWithMetadata($client)
    {
        $logger = $client->logger(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue[] = $logger;
        $data = 'test';
        $httpRequest = [
            'requestMethod' => 'GET',
            'requestUrl' => 'http://www.example.com',
            'status' => 200
        ];
        $labels = [
            'test' => 'label'
        ];
        $severity = 'INFO';

        $entry = $logger->entry($data, [
            'httpRequest' => $httpRequest,
            'labels' => $labels,
            'severity' => 200
        ]);

        $logger->write($entry);

        $backoff = new ExponentialBackoff(8);
        $entries = $backoff->execute(function () use ($logger) {
            $entries = iterator_to_array($logger->entries());

            if (count($entries) === 0) {
                throw new \Exception();
            }

            return $entries;
        });
        $actualEntryInfo = $entries[0]->info();

        $this->assertEquals($data, $actualEntryInfo['textPayload']);
        $this->assertEquals($httpRequest['requestMethod'], $actualEntryInfo['httpRequest']['requestMethod']);
        $this->assertEquals($httpRequest['requestUrl'], $actualEntryInfo['httpRequest']['requestUrl']);
        $this->assertEquals($httpRequest['status'], $actualEntryInfo['httpRequest']['status']);
        $this->assertEquals($labels['test'], $actualEntryInfo['labels']['test']);
        $this->assertEquals($severity, $actualEntryInfo['severity']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesEmergencyLogWithPsrLogger($client)
    {
        $this->assertPsrLoggerWrites($client, 'emergency');
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesAlertLogWithPsrLogger($client)
    {
        $this->assertPsrLoggerWrites($client, 'alert');
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesCriticalLogWithPsrLogger($client)
    {
        $this->assertPsrLoggerWrites($client, 'critical');
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesErrorLogWithPsrLogger($client)
    {
        $this->assertPsrLoggerWrites($client, 'error');
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesWarningLogWithPsrLogger($client)
    {
        $this->assertPsrLoggerWrites($client, 'warning');
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesNoticeLogWithPsrLogger($client)
    {
        $this->assertPsrLoggerWrites($client, 'notice');
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesInfoLogWithPsrLogger($client)
    {
        $this->assertPsrLoggerWrites($client, 'info');
    }

    /**
     * @dataProvider clientProvider
     */
    public function testWritesInfoDebugWithPsrLogger($client)
    {
        $this->assertPsrLoggerWrites($client, 'debug');
    }

    private function assertPsrLoggerWrites($client, $level)
    {
        $logName = uniqid(self::TESTING_PREFIX);
        $psrLogger = $client->psrLogger($logName);
        $logger = $client->logger($logName);
        self::$deletionQueue[] = $logger;
        $data = $level;
        $httpRequest = [
            'requestMethod' => 'GET'
        ];

        $psrLogger->$level($data, [
            'stackdriverOptions' => [
                'httpRequest' => $httpRequest
            ]
        ]);

        $backoff = new ExponentialBackoff(8);
        $entries = $backoff->execute(function () use ($logger) {
            $entries = iterator_to_array($logger->entries());

            if (count($entries) === 0) {
                throw new \Exception();
            }

            return $entries;
        });
        $actualEntryInfo = $entries[0]->info();

        $this->assertEquals($data, $actualEntryInfo['jsonPayload']['message']);
        $this->assertEquals($httpRequest['requestMethod'], $actualEntryInfo['httpRequest']['requestMethod']);
    }
}
