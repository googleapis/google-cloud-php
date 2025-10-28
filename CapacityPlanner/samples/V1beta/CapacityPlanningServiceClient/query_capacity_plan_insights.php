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

// [START capacityplanner_v1beta_generated_CapacityPlanningService_QueryCapacityPlanInsights_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CapacityPlanner\V1beta\CapacityPlanFilters;
use Google\Cloud\CapacityPlanner\V1beta\CapacityPlanKey;
use Google\Cloud\CapacityPlanner\V1beta\CapacityType;
use Google\Cloud\CapacityPlanner\V1beta\Client\CapacityPlanningServiceClient;
use Google\Cloud\CapacityPlanner\V1beta\LocationIdentifier;
use Google\Cloud\CapacityPlanner\V1beta\QueryCapacityPlanInsightsRequest;
use Google\Cloud\CapacityPlanner\V1beta\QueryCapacityPlanInsightsResponse;
use Google\Cloud\CapacityPlanner\V1beta\ResourceContainer;
use Google\Cloud\CapacityPlanner\V1beta\ResourceIdKey;
use Google\Cloud\CapacityPlanner\V1beta\ResourceIdentifier;

/**
 * Query capacity plan insights that are in the parent parameter and match
 * your specified filters.
 *
 * @param string $parent                                           The parent resource container.
 *                                                                 Format: projects/{project}
 * @param string $capacityPlanFiltersKeysResourceContainerId       Identifier of the resource container. For example, project number
 *                                                                 for project type.
 * @param string $capacityPlanFiltersKeysResourceIdKeyResourceCode resource_code for the resource. eg: gce-ram, gce-vcpus,
 *                                                                 gce-gpu, gce-tpu, gce-vm, gce-persistent-disk, gce-local-ssd.
 * @param string $capacityPlanFiltersKeysLocationIdSource          Location where resource is sourced. For Cloud Storage, the
 *                                                                 alphabetically first location is the source.
 * @param int    $capacityPlanFiltersCapacityTypesElement          The capacity types to include in the response.
 */
function query_capacity_plan_insights_sample(
    string $parent,
    string $capacityPlanFiltersKeysResourceContainerId,
    string $capacityPlanFiltersKeysResourceIdKeyResourceCode,
    string $capacityPlanFiltersKeysLocationIdSource,
    int $capacityPlanFiltersCapacityTypesElement
): void {
    // Create a client.
    $capacityPlanningServiceClient = new CapacityPlanningServiceClient();

    // Prepare the request message.
    $capacityPlanFiltersKeysResourceContainer = (new ResourceContainer())
        ->setId($capacityPlanFiltersKeysResourceContainerId);
    $capacityPlanFiltersKeysResourceIdKeyResourceId = new ResourceIdentifier();
    $capacityPlanFiltersKeysResourceIdKey = (new ResourceIdKey())
        ->setResourceCode($capacityPlanFiltersKeysResourceIdKeyResourceCode)
        ->setResourceId($capacityPlanFiltersKeysResourceIdKeyResourceId);
    $capacityPlanFiltersKeysLocationId = (new LocationIdentifier())
        ->setSource($capacityPlanFiltersKeysLocationIdSource);
    $capacityPlanKey = (new CapacityPlanKey())
        ->setResourceContainer($capacityPlanFiltersKeysResourceContainer)
        ->setResourceIdKey($capacityPlanFiltersKeysResourceIdKey)
        ->setLocationId($capacityPlanFiltersKeysLocationId);
    $capacityPlanFiltersKeys = [$capacityPlanKey,];
    $capacityPlanFiltersCapacityTypes = [$capacityPlanFiltersCapacityTypesElement,];
    $capacityPlanFilters = (new CapacityPlanFilters())
        ->setKeys($capacityPlanFiltersKeys)
        ->setCapacityTypes($capacityPlanFiltersCapacityTypes);
    $request = (new QueryCapacityPlanInsightsRequest())
        ->setParent($parent)
        ->setCapacityPlanFilters($capacityPlanFilters);

    // Call the API and handle any network failures.
    try {
        /** @var QueryCapacityPlanInsightsResponse $response */
        $response = $capacityPlanningServiceClient->queryCapacityPlanInsights($request);
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
    $parent = '[PARENT]';
    $capacityPlanFiltersKeysResourceContainerId = '[ID]';
    $capacityPlanFiltersKeysResourceIdKeyResourceCode = '[RESOURCE_CODE]';
    $capacityPlanFiltersKeysLocationIdSource = '[SOURCE]';
    $capacityPlanFiltersCapacityTypesElement = CapacityType::CAPACITY_TYPE_UNKNOWN;

    query_capacity_plan_insights_sample(
        $parent,
        $capacityPlanFiltersKeysResourceContainerId,
        $capacityPlanFiltersKeysResourceIdKeyResourceCode,
        $capacityPlanFiltersKeysLocationIdSource,
        $capacityPlanFiltersCapacityTypesElement
    );
}
// [END capacityplanner_v1beta_generated_CapacityPlanningService_QueryCapacityPlanInsights_sync]
