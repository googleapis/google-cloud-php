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

// [START capacityplanner_v1beta_generated_UsageService_QueryUsageHistories_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CapacityPlanner\V1beta\Client\UsageServiceClient;
use Google\Cloud\CapacityPlanner\V1beta\QueryUsageHistoriesRequest;
use Google\Cloud\CapacityPlanner\V1beta\QueryUsageHistoriesResponse;

/**
 * Returns a list of the usage histories that are in the parent parameter
 * and match your specified filters.
 *
 * @param string $formattedParent   The compute engine resource and location for the time series
 *                                  values to return. The format is:
 *
 *                                  projects/{project}/locations/{location} or
 *                                  organizations/{organization}/locations/{location} or
 *                                  folders/{folder}/locations/{location}
 *                                  Please see {@see UsageServiceClient::locationName()} for help formatting this field.
 * @param string $cloudResourceType The resource for the `UsageHistory` values to return. Possible
 *                                  values include "gce-vcpus", "gce-ram", "gce-local-ssd",
 *                                  "gce-persistent-disk", "gce-gpu" and "gce-tpu". Empty cloud_resource_type
 *                                  will return results matching all resources.
 */
function query_usage_histories_sample(string $formattedParent, string $cloudResourceType): void
{
    // Create a client.
    $usageServiceClient = new UsageServiceClient();

    // Prepare the request message.
    $request = (new QueryUsageHistoriesRequest())
        ->setParent($formattedParent)
        ->setCloudResourceType($cloudResourceType);

    // Call the API and handle any network failures.
    try {
        /** @var QueryUsageHistoriesResponse $response */
        $response = $usageServiceClient->queryUsageHistories($request);
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
    $formattedParent = UsageServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $cloudResourceType = '[CLOUD_RESOURCE_TYPE]';

    query_usage_histories_sample($formattedParent, $cloudResourceType);
}
// [END capacityplanner_v1beta_generated_UsageService_QueryUsageHistories_sync]
