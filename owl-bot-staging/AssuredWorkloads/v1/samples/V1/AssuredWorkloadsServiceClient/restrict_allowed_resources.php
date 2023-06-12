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

// [START assuredworkloads_v1_generated_AssuredWorkloadsService_RestrictAllowedResources_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AssuredWorkloads\V1\Client\AssuredWorkloadsServiceClient;
use Google\Cloud\AssuredWorkloads\V1\RestrictAllowedResourcesRequest;
use Google\Cloud\AssuredWorkloads\V1\RestrictAllowedResourcesRequest\RestrictionType;
use Google\Cloud\AssuredWorkloads\V1\RestrictAllowedResourcesResponse;

/**
 * Restrict the list of resources allowed in the Workload environment.
 * The current list of allowed products can be found at
 * https://cloud.google.com/assured-workloads/docs/supported-products
 * In addition to assuredworkloads.workload.update permission, the user should
 * also have orgpolicy.policy.set permission on the folder resource
 * to use this functionality.
 *
 * @param string $name            The resource name of the Workload. This is the workloads's
 *                                relative path in the API, formatted as
 *                                "organizations/{organization_id}/locations/{location_id}/workloads/{workload_id}".
 *                                For example,
 *                                "organizations/123/locations/us-east1/workloads/assured-workload-1".
 * @param int    $restrictionType The type of restriction for using gcp products in the Workload environment.
 */
function restrict_allowed_resources_sample(string $name, int $restrictionType): void
{
    // Create a client.
    $assuredWorkloadsServiceClient = new AssuredWorkloadsServiceClient();

    // Prepare the request message.
    $request = (new RestrictAllowedResourcesRequest())
        ->setName($name)
        ->setRestrictionType($restrictionType);

    // Call the API and handle any network failures.
    try {
        /** @var RestrictAllowedResourcesResponse $response */
        $response = $assuredWorkloadsServiceClient->restrictAllowedResources($request);
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
    $name = '[NAME]';
    $restrictionType = RestrictionType::RESTRICTION_TYPE_UNSPECIFIED;

    restrict_allowed_resources_sample($name, $restrictionType);
}
// [END assuredworkloads_v1_generated_AssuredWorkloadsService_RestrictAllowedResources_sync]
