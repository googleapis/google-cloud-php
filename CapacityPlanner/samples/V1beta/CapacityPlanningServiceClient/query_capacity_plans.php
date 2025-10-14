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

// [START capacityplanner_v1beta_generated_CapacityPlanningService_QueryCapacityPlans_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\CapacityPlanner\V1beta\CapacityPlan;
use Google\Cloud\CapacityPlanner\V1beta\Client\CapacityPlanningServiceClient;
use Google\Cloud\CapacityPlanner\V1beta\QueryCapacityPlansRequest;

/**
 * Returns a list of the capacity plans that are in the parent parameter and
 * match your specified filters.
 * (The maximum list length is limited by the pageSize parameter.)
 *
 * @param string $formattedParent The parent resource container.
 *                                Format:
 *                                projects/{project} or
 *                                folders/{folder} or
 *                                organizations/{organization}
 *                                Please see {@see CapacityPlanningServiceClient::projectName()} for help formatting this field.
 */
function query_capacity_plans_sample(string $formattedParent): void
{
    // Create a client.
    $capacityPlanningServiceClient = new CapacityPlanningServiceClient();

    // Prepare the request message.
    $request = (new QueryCapacityPlansRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $capacityPlanningServiceClient->queryCapacityPlans($request);

        /** @var CapacityPlan $element */
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
    $formattedParent = CapacityPlanningServiceClient::projectName('[PROJECT]');

    query_capacity_plans_sample($formattedParent);
}
// [END capacityplanner_v1beta_generated_CapacityPlanningService_QueryCapacityPlans_sync]
