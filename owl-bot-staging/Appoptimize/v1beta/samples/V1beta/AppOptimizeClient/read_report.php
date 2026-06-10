<?php
/*
 * Copyright 2026 Google LLC
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

// [START appoptimize_v1beta_generated_AppOptimize_ReadReport_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\AppOptimize\V1beta\Client\AppOptimizeClient;
use Google\Cloud\AppOptimize\V1beta\ReadReportRequest;
use Google\Protobuf\ListValue;

/**
 * Reads data within a specified report.
 *
 * @param string $formattedName The resource name of the report to query.
 *
 *                              Format: `projects/{project}/locations/{location}/reports/{report_id}`. Please see
 *                              {@see AppOptimizeClient::reportName()} for help formatting this field.
 */
function read_report_sample(string $formattedName): void
{
    // Create a client.
    $appOptimizeClient = new AppOptimizeClient();

    // Prepare the request message.
    $request = (new ReadReportRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $appOptimizeClient->readReport($request);

        /** @var ListValue $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedName = AppOptimizeClient::reportName('[PROJECT]', '[LOCATION]', '[REPORT]');

    read_report_sample($formattedName);
}
// [END appoptimize_v1beta_generated_AppOptimize_ReadReport_sync]
