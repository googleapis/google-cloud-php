<?php
/*
 * Copyright 2022 Google LLC
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

// [START logging_v2_generated_ConfigServiceV2_CopyLogEntries_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\CopyLogEntriesResponse;
use Google\Rpc\Status;

/**
 * Copies a set of log entries from a log bucket to a Cloud Storage bucket.
 *
 * @param string $name        Log bucket from which to copy log entries.
 *
 *                            For example:
 *
 *                            `"projects/my-project/locations/global/buckets/my-source-bucket"`
 * @param string $destination Destination to which to copy log entries.
 */
function copy_log_entries_sample(string $name, string $destination): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $configServiceV2Client->copyLogEntries($name, $destination);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CopyLogEntriesResponse $result */
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
    $name = '[NAME]';
    $destination = '[DESTINATION]';

    copy_log_entries_sample($name, $destination);
}
// [END logging_v2_generated_ConfigServiceV2_CopyLogEntries_sync]
