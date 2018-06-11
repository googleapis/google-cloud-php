<?php
/*
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\Cloud\ErrorReporting\Tests\System\V1beta1;

use Google\Cloud\ErrorReporting\V1beta1\ReportErrorsServiceClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\Cloud\ErrorReporting\V1beta1\ErrorContext;
use Google\Cloud\ErrorReporting\V1beta1\ReportedErrorEvent;
use Google\Cloud\ErrorReporting\V1beta1\ServiceContext;
use Google\Cloud\ErrorReporting\V1beta1\SourceLocation;

/**
 * @group error-reporting
 * @group grpc
 */
class ReportErrorsServiceSmokeTest extends GeneratedTest
{
    /**
     * @test
     */
    public function reportErrorEventTest()
    {
        $projectId = getenv('PROJECT_ID');
        if ($projectId === false) {
            $this->fail('Environment variable PROJECT_ID must be set for smoke test');
        }

        $reportErrorsServiceClient = new ReportErrorsServiceClient();
        $formattedProjectName = $reportErrorsServiceClient->projectName($projectId);
        $message = '[MESSAGE]';
        $service = '[SERVICE]';
        $serviceContext = new ServiceContext();
        $serviceContext->setService($service);
        $filePath = 'path/to/file.lang';
        $lineNumber = 42;
        $functionName = 'meaningOfLife';
        $reportLocation = new SourceLocation();
        $reportLocation->setFilePath($filePath);
        $reportLocation->setLineNumber($lineNumber);
        $reportLocation->setFunctionName($functionName);
        $context = new ErrorContext();
        $context->setReportLocation($reportLocation);
        $event = new ReportedErrorEvent();
        $event->setMessage($message);
        $event->setServiceContext($serviceContext);
        $event->setContext($context);
        $reportErrorsServiceClient->reportErrorEvent($formattedProjectName, $event);
    }
}
