<?php
/**
 * Copyright 2025 Google Inc.
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

namespace Google\Cloud\Dev\Tests\Snippet;

use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;
use Monolog\Logger;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Log\LoggerInterface;

/**
 * @group docs
 */
class TroubleshootingTest extends SnippetTestCase
{
    use ProphecyTrait;

    private const DEBUG_LOGGING_FILE = __DIR__ . '/../../../../DEBUG.md';

    /**
     * @runInSeparateProcess
     * @backupGlobals disabled
     */
    public function testLoggingIsEnabledWithEnvironmentVariable()
    {
        $snippet = $this->snippetFromMarkdown(
            self::DEBUG_LOGGING_FILE,
            'Log examples',
        );

        $snippet->replace(
            '$client = new TranslationServiceClient();',
            'global $client;'
        );

        $logger = $this->prophesize(LoggerInterface::class);
        $logger->debug(Argument::type('string'))->shouldBeCalled();

        global $client;
        $client = new TranslationServiceClient(['logger' => $logger->reveal()]);

        try {
            putenv('GOOGLE_SDK_PHP_LOGGING=true');
            $snippet->invoke();
        } catch (\Exception $e) {
            // Prevent real API call from failing the test
        }
    }

    /**
     * @runInSeparateProcess
     */
    public function testPsr3LoggerIsInjected()
    {
        $snippet = $this->snippetFromMarkdown(
            self::DEBUG_LOGGING_FILE,
            'Passing a PSR-3 compliant logger',
        );
        $snippet->addUse(TranslationServiceClient::class);

        $client = $snippet->invoke('client')->returnVal();
        $cw = (new \ReflectionClass($client))->getProperty('credentialsWrapper')->getValue($client);
        $http = (new \ReflectionClass($cw))->getProperty('authHttpHandler')->getValue($cw);
        $logger = (new \ReflectionClass($http))->getParentClass()->getProperty('logger')->getValue($http);

        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertEquals('sdk client', $logger->getName());
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoggingIsDisabledForAClient()
    {
        $snippet = $this->snippetFromMarkdown(
            self::DEBUG_LOGGING_FILE,
            'Passing `false` to the configuration',
            1
        );
        $snippet->addUse(TranslationServiceClient::class);
        $snippet->addUse(BigtableClient::class);

        $client = $snippet->invoke('translation')->returnVal();
        $cw = (new \ReflectionClass($client))->getProperty('credentialsWrapper')->getValue($client);
        $http = (new \ReflectionClass($cw))->getProperty('authHttpHandler')->getValue($cw);
        $logger = (new \ReflectionClass($http))->getParentClass()->getProperty('logger')->getValue($http);

        $this->assertNull($logger);
    }
}
