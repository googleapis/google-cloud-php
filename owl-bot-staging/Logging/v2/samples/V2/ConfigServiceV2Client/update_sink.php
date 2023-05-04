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

// [START logging_v2_generated_ConfigServiceV2_UpdateSink_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\LogSink;

/**
 * Updates a sink. This method replaces the following fields in the existing
 * sink with values from the new sink: `destination`, and `filter`.
 *
 * The updated sink might also have a new `writer_identity`; see the
 * `unique_writer_identity` field.
 *
 * @param string $formattedSinkName The full resource name of the sink to update, including the parent
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
 * @param string $sinkName          The client-assigned sink identifier, unique within the project.
 *
 *                                  For example: `"my-syslog-errors-to-pubsub"`. Sink identifiers are limited
 *                                  to 100 characters and can include only the following characters: upper and
 *                                  lower-case alphanumeric characters, underscores, hyphens, and periods.
 *                                  First character has to be alphanumeric.
 * @param string $sinkDestination   The export destination:
 *
 *                                  "storage.googleapis.com/[GCS_BUCKET]"
 *                                  "bigquery.googleapis.com/projects/[PROJECT_ID]/datasets/[DATASET]"
 *                                  "pubsub.googleapis.com/projects/[PROJECT_ID]/topics/[TOPIC_ID]"
 *
 *                                  The sink's `writer_identity`, set when the sink is created, must have
 *                                  permission to write to the destination or else the log entries are not
 *                                  exported. For more information, see
 *                                  [Exporting Logs with
 *                                  Sinks](https://cloud.google.com/logging/docs/api/tasks/exporting-logs).
 */
function update_sink_sample(
    string $formattedSinkName,
    string $sinkName,
    string $sinkDestination
): void {
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $sink = (new LogSink())
        ->setName($sinkName)
        ->setDestination($sinkDestination);

    // Call the API and handle any network failures.
    try {
        /** @var LogSink $response */
        $response = $configServiceV2Client->updateSink($formattedSinkName, $sink);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $sinkName = '[NAME]';
    $sinkDestination = '[DESTINATION]';

    update_sink_sample($formattedSinkName, $sinkName, $sinkDestination);
}
// [END logging_v2_generated_ConfigServiceV2_UpdateSink_sync]
