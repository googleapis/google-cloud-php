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

// [START redis_v1beta1_generated_CloudRedis_ListInstances_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Redis\V1beta1\CloudRedisClient;
use Google\Cloud\Redis\V1beta1\Instance;

/**
 * Lists all Redis instances owned by a project in either the specified
 * location (region) or all locations.
 *
 * The location should have the following format:
 *
 * * `projects/{project_id}/locations/{location_id}`
 *
 * If `location_id` is specified as `-` (wildcard), then all regions
 * available to the project are queried, and the results are aggregated.
 *
 * @param string $formattedParent The resource name of the instance location using the form:
 *                                `projects/{project_id}/locations/{location_id}`
 *                                where `location_id` refers to a GCP region. Please see
 *                                {@see CloudRedisClient::locationName()} for help formatting this field.
 */
function list_instances_sample(string $formattedParent): void
{
    // Create a client.
    $cloudRedisClient = new CloudRedisClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudRedisClient->listInstances($formattedParent);

        /** @var Instance $element */
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
    $formattedParent = CloudRedisClient::locationName('[PROJECT]', '[LOCATION]');

    list_instances_sample($formattedParent);
}
// [END redis_v1beta1_generated_CloudRedis_ListInstances_sync]
