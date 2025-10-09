<?php
/*
 * Copyright 2024 Google LLC
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

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_CreateReportTask_sync]
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\CreateReportTaskRequest;
use Google\Analytics\Data\V1alpha\ReportTask;
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Rpc\Status;

/**
 * Initiates the creation of a report task. This method quickly
 * returns a report task and initiates a long running
 * asynchronous request to form a customized report of your Google Analytics
 * event data.
 *
 * A report task will be retained and available for querying for 72 hours
 * after it has been created.
 *
 * A report task created by one user can be listed and queried by all users
 * who have access to the property.
 *
 * @param string $formattedParent The parent resource where this report task will be created.
 *                                Format: `properties/{propertyId}`
 *                                Please see {@see AlphaAnalyticsDataClient::propertyName()} for help formatting this field.
 */
function create_report_task_sample(string $formattedParent): void
{
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare the request message.
    $reportTask = new ReportTask();
    $request = (new CreateReportTaskRequest())
        ->setParent($formattedParent)
        ->setReportTask($reportTask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $alphaAnalyticsDataClient->createReportTask($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ReportTask $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedParent = AlphaAnalyticsDataClient::propertyName('[PROPERTY]');

    create_report_task_sample($formattedParent);
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_CreateReportTask_sync]
