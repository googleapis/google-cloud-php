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

// [START logging_v2_generated_ConfigServiceV2_DeleteSink_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;

/**
 * Deletes a sink. If the sink has a unique `writer_identity`, then that
 * service account is also deleted.
 *
 * @param string $formattedSinkName The full resource name of the sink to delete, including the parent
 *                                  resource and the sink identifier:
 *
 *                                  "projects/[PROJECT_ID]/sinks/[SINK_ID]"
 *                                  "organizations/[ORGANIZATION_ID]/sinks/[SINK_ID]"
 *                                  "billingAccounts/[BILLING_ACCOUNT_ID]/sinks/[SINK_ID]"
 *                                  "folders/[FOLDER_ID]/sinks/[SINK_ID]"
 *
 *                                  For example:
 *
 *                                  `"projects/my-project/sinks/my-sink"`
 *                                  Please see {@see ConfigServiceV2Client::logSinkName()} for help formatting this field.
 */
function delete_sink_sample(string $formattedSinkName): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Call the API and handle any network failures.
    try {
        $configServiceV2Client->deleteSink($formattedSinkName);
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
    $formattedSinkName = ConfigServiceV2Client::logSinkName('[PROJECT]', '[SINK]');

    delete_sink_sample($formattedSinkName);
}
// [END logging_v2_generated_ConfigServiceV2_DeleteSink_sync]
