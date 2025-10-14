<?php
/*
 * Copyright 2025 Google LLC
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

// [START capacityplanner_v1beta_generated_UsageService_ExportReservationsUsage_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\CapacityPlanner\V1beta\Client\UsageServiceClient;
use Google\Cloud\CapacityPlanner\V1beta\ExportReservationsUsageRequest;
use Google\Cloud\CapacityPlanner\V1beta\ExportReservationsUsageResponse;
use Google\Cloud\CapacityPlanner\V1beta\OutputConfig;
use Google\Cloud\CapacityPlanner\V1beta\UsageHistory\AggregationMethod;
use Google\Rpc\Status;

/**
 * Exports reservations usage data requested by user into either an existing
 * Cloud Storage bucket or a new/existing BigQuery table.
 *
 * @param string $formattedParent        The compute engine resource and location of the
 *                                       reservationsusage. The format is:
 *                                       projects/{project}/locations/{location} or
 *                                       organizations/{organization}/locations/{location} or
 *                                       folders/{folder}/locations/{location}
 *                                       Please see {@see UsageServiceClient::locationName()} for help formatting this field.
 * @param string $cloudResourceType      The resource for the `ReservationsUsage` values to return.
 *                                       Possible values include "gce-vcpus", "gce-ram", "gce-local-ssd", and
 *                                       "gce-gpu".
 * @param int    $usageAggregationMethod The method that should be used to convert sampled reservations
 *                                       data to daily usage values.
 */
function export_reservations_usage_sample(
    string $formattedParent,
    string $cloudResourceType,
    int $usageAggregationMethod
): void {
    // Create a client.
    $usageServiceClient = new UsageServiceClient();

    // Prepare the request message.
    $outputConfig = new OutputConfig();
    $request = (new ExportReservationsUsageRequest())
        ->setParent($formattedParent)
        ->setCloudResourceType($cloudResourceType)
        ->setUsageAggregationMethod($usageAggregationMethod)
        ->setOutputConfig($outputConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $usageServiceClient->exportReservationsUsage($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportReservationsUsageResponse $result */
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
    $formattedParent = UsageServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $cloudResourceType = '[CLOUD_RESOURCE_TYPE]';
    $usageAggregationMethod = AggregationMethod::AGGREGATION_METHOD_UNSPECIFIED;

    export_reservations_usage_sample($formattedParent, $cloudResourceType, $usageAggregationMethod);
}
// [END capacityplanner_v1beta_generated_UsageService_ExportReservationsUsage_sync]
