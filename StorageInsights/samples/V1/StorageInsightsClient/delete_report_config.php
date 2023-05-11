<?php
/*
 * Copyright 2023 Google LLC
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

// [START storageinsights_v1_generated_StorageInsights_DeleteReportConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\StorageInsights\V1\Client\StorageInsightsClient;
use Google\Cloud\StorageInsights\V1\DeleteReportConfigRequest;

/**
 * Deletes a single ReportConfig.
 *
 * @param string $formattedName Name of the resource
 *                              Please see {@see StorageInsightsClient::reportConfigName()} for help formatting this field.
 */
function delete_report_config_sample(string $formattedName): void
{
    // Create a client.
    $storageInsightsClient = new StorageInsightsClient();

    // Prepare the request message.
    $request = (new DeleteReportConfigRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $storageInsightsClient->deleteReportConfig($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = StorageInsightsClient::reportConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPORT_CONFIG]'
    );

    delete_report_config_sample($formattedName);
}
// [END storageinsights_v1_generated_StorageInsights_DeleteReportConfig_sync]
