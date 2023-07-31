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

// [START bigquerydatatransfer_v1_generated_DataTransferService_ScheduleTransferRuns_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\DataTransfer\V1\DataTransferServiceClient;
use Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsResponse;
use Google\Protobuf\Timestamp;

/**
 * Creates transfer runs for a time range [start_time, end_time].
 * For each date - or whatever granularity the data source supports - in the
 * range, one transfer run is created.
 * Note that runs are created per UTC time in the time range.
 * DEPRECATED: use StartManualTransferRuns instead.
 *
 * @param string $formattedParent Transfer configuration name in the form:
 *                                `projects/{project_id}/transferConfigs/{config_id}` or
 *                                `projects/{project_id}/locations/{location_id}/transferConfigs/{config_id}`. Please see
 *                                {@see DataTransferServiceClient::transferConfigName()} for help formatting this field.
 */
function schedule_transfer_runs_sample(string $formattedParent): void
{
    // Create a client.
    $dataTransferServiceClient = new DataTransferServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $startTime = new Timestamp();
    $endTime = new Timestamp();

    // Call the API and handle any network failures.
    try {
        /** @var ScheduleTransferRunsResponse $response */
        $response = $dataTransferServiceClient->scheduleTransferRuns(
            $formattedParent,
            $startTime,
            $endTime
        );
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
    $formattedParent = DataTransferServiceClient::transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');

    schedule_transfer_runs_sample($formattedParent);
}
// [END bigquerydatatransfer_v1_generated_DataTransferService_ScheduleTransferRuns_sync]
