<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\ErrorReporting;

use Google\Cloud\Core\Report\SimpleMetadataProvider;
use Google\Cloud\ErrorReporting\Bootstrap;
use Google\Cloud\ErrorReporting\MockValues;
use Google\Cloud\Logging\PsrLogger;
use Prophecy\Argument;

require_once __DIR__ . '/fakeGlobalFunctions.php';

/**
 * @group error-reporting
 */
class BootstrapTest extends \PHPUnit_Framework_TestCase
{

    private $psrBatchLogger;
    private $metadataProvider;

    public function setUp()
    {
        $this->psrBatchLogger = $this->prophesize(PsrLogger::class);
    }

    /**
     * @dataProvider levelAndErrorPrefixProvider
     */
    public function testGetErrorPrefix($level, $expectedPrefix)
    {
        $prefix = Bootstrap::getErrorPrefix($level);
        $this->assertEquals($expectedPrefix, $prefix);
    }

    public function levelAndErrorPrefixProvider()
    {
        return [
            [E_PARSE, 'PHP Parse error'],
            [E_ERROR, 'PHP Fatal error'],
            [E_CORE_ERROR, 'PHP Fatal error'],
            [E_COMPILE_ERROR, 'PHP Fatal error'],
            [E_USER_ERROR, 'PHP error'],
            [E_RECOVERABLE_ERROR, 'PHP error'],
            [E_WARNING, 'PHP Warning'],
            [E_CORE_WARNING, 'PHP Warning'],
            [E_COMPILE_WARNING, 'PHP Warning'],
            [E_USER_WARNING, 'PHP Warning'],
            [E_NOTICE, 'PHP Notice'],
            [E_USER_NOTICE, 'PHP Notice'],
            [E_STRICT, 'PHP Debug'],
            [PHP_INT_MAX, 'PHP Notice'],
        ];
    }

    /**
     * @dataProvider levelAndErrorLevelString
     */
    public function testGetErrorLevelString($level, $expectedErrorLevelString)
    {
        $errorLevelString = Bootstrap::getErrorLevelString($level);
        $this->assertEquals($expectedErrorLevelString, $errorLevelString);
    }

    public function levelAndErrorLevelString()
    {
        return [
            [E_PARSE, 'CRITICAL'],
            [E_ERROR, 'ERROR'],
            [E_CORE_ERROR, 'ERROR'],
            [E_COMPILE_ERROR, 'ERROR'],
            [E_USER_ERROR, 'ERROR'],
            [E_RECOVERABLE_ERROR, 'ERROR'],
            [E_WARNING, 'WARNING'],
            [E_CORE_WARNING, 'WARNING'],
            [E_COMPILE_WARNING, 'WARNING'],
            [E_USER_WARNING, 'WARNING'],
            [E_NOTICE, 'NOTICE'],
            [E_USER_NOTICE, 'NOTICE'],
            [E_STRICT, 'DEBUG'],
            [PHP_INT_MAX, 'NOTICE'],
        ];
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testExceptionHandler(
        $exception
    ) {
        $expectedMessage = sprintf('PHP Notice: %s', (string)$exception);
        $this->psrBatchLogger->error($expectedMessage)
            ->shouldBeCalledTimes(1);
        Bootstrap::$psrBatchLogger = $this->psrBatchLogger->reveal();
        Bootstrap::exceptionHandler($exception);
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testExceptionHandlerWithoutLogger(
        $exception
    ) {
        $expectedMessage = sprintf('PHP Notice: %s', (string)$exception);
        Bootstrap::$psrBatchLogger = null;
        Bootstrap::exceptionHandler($exception);
        $this->assertEquals($expectedMessage . PHP_EOL, MockValues::$stderr);
    }

    public function exceptionProvider()
    {
        return [
            [new \Exception('My awesome exception')]
        ];
    }

    /**
     * @dataProvider errorsAndMetadataProvider
     */
    public function testErrorHandler(
        $error,
        $resource,
        $projectId,
        $serviceId,
        $versionId
    ) {
        $metadataProvider = new SimpleMetadataProvider(
            $resource,
            $projectId,
            $serviceId,
            $versionId
        );
        $this->psrBatchLogger->getMetadataProvider()
            ->willReturn($metadataProvider)
            ->shouldBeCalledTimes(2);
        $expectedMessage = sprintf(
            '%s: %s in %s on line %d',
            Bootstrap::getErrorPrefix($error['type']),
            $error['message'],
            $error['file'],
            $error['line']
        );
        $expectedContext = [
            'context' => [
                'reportLocation' => [
                    'filePath' => $error['file'],
                    'lineNumber' => $error['line'],
                    'functionName' => 'unknown'
                ]
            ],
            'serviceContext' => [
                'service' => $serviceId,
                'version' => $versionId,
            ]
        ];
        $this->psrBatchLogger->log(
            Bootstrap::getErrorLevelString($error['type']),
            $expectedMessage,
            $expectedContext
        )->shouldBeCalledTimes(1);
        Bootstrap::$psrBatchLogger = $this->psrBatchLogger->reveal();
        MockValues::$errorReporting = $error['type']; // always match
        BootStrap::errorHandler(
            $error['type'],
            $error['message'],
            $error['file'],
            $error['line']
        );
    }

    public function testErrorHandlerWithMinorError()
    {
        Bootstrap::$psrBatchLogger = null;
        MockValues::$errorReporting = 0;
        $result = BootStrap::errorHandler(
            E_ERROR,
            'message',
            'file',
            1
        );
        $this->assertTrue($result);
    }

    public function testErrorHandlerWithoutLogger() {
        Bootstrap::$psrBatchLogger = null;
        MockValues::$errorReporting = E_ERROR;
        $result = BootStrap::errorHandler(
            E_ERROR,
            'message',
            'file',
            1
        );
        $this->assertFalse($result);
    }

    /**
     * @dataProvider errorsAndMetadataProvider
     */
    public function testShutdownHandler(
        $error,
        $resource,
        $projectId,
        $serviceId,
        $versionId
    ) {
        $metadataProvider = new SimpleMetadataProvider(
            $resource,
            $projectId,
            $serviceId,
            $versionId
        );
        MockValues::$type = $error['type'];
        MockValues::$message = $error['message'];
        MockValues::$file = $error['file'];
        MockValues::$line = $error['line'];

        $fatalErrors = [E_ERROR, E_PARSE, E_COMPILE_ERROR, E_COMPILE_WARNING,
                        E_CORE_ERROR, E_CORE_WARNING];
        if (!in_array($error['type'], $fatalErrors, true)) {
            // The shutdownHandler should not do anything, so it should pass
            // with the empty psrBatchLogger mock.
            Bootstrap::$psrBatchLogger = $this->psrBatchLogger->reveal();
            $this->assertNull(BootStrap::shutdownHandler());
            return;
        }
        $this->psrBatchLogger->getMetadataProvider()
            ->willReturn($metadataProvider)
            ->shouldBeCalledTimes(2);
        $expectedMessage = sprintf(
            '%s: %s in %s on line %d',
            Bootstrap::getErrorPrefix($error['type']),
            $error['message'],
            $error['file'],
            $error['line']
        );
        $expectedContext = [
            'context' => [
                'reportLocation' => [
                    'filePath' => $error['file'],
                    'lineNumber' => $error['line'],
                    'functionName' => 'unknown'
                ]
            ],
            'serviceContext' => [
                'service' => $serviceId,
                'version' => $versionId,
            ]
        ];
        $this->psrBatchLogger->log(
            Bootstrap::getErrorLevelString($error['type']),
            $expectedMessage,
            $expectedContext
        )->shouldBeCalledTimes(1);
        Bootstrap::$psrBatchLogger = $this->psrBatchLogger->reveal();
        BootStrap::shutdownHandler();
    }

    public function errorsAndMetadataProvider()
    {
        return [
            [
                ['type' => E_ERROR,
                 'message' => 'error message',
                 'file' => '/app/web/index.php',
                 'line' => 1],
                ['type' => 'my-type'],
                'my-project',
                'my-service',
                'my-version'
            ],
            [
                ['type' => E_WARNING,
                 'message' => 'warning message',
                 'file' => '/app/web/phpinfo.php',
                 'line' => 2],
                ['type' => 'another-type'],
                'another-project',
                'another-service',
                'another-version'
            ],
        ];
    }
}
