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

// [START servicemanagement_v1_generated_ServiceManager_ListServiceRollouts_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\ServiceManagement\V1\Rollout;
use Google\Cloud\ServiceManagement\V1\ServiceManagerClient;

/**
 * Lists the history of the service configuration rollouts for a managed
 * service, from the newest to the oldest.
 *
 * @param string $serviceName The name of the service.  See the
 *                            [overview](https://cloud.google.com/service-infrastructure/docs/overview) for naming requirements.  For
 *                            example: `example.googleapis.com`.
 * @param string $filter      Use `filter` to return subset of rollouts.
 *                            The following filters are supported:
 *                            -- To limit the results to only those in
 *                            status (google.api.servicemanagement.v1.RolloutStatus) 'SUCCESS',
 *                            use filter='status=SUCCESS'
 *                            -- To limit the results to those in
 *                            status (google.api.servicemanagement.v1.RolloutStatus) 'CANCELLED'
 *                            or 'FAILED', use filter='status=CANCELLED OR status=FAILED'
 */
function list_service_rollouts_sample(string $serviceName, string $filter): void
{
    // Create a client.
    $serviceManagerClient = new ServiceManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $serviceManagerClient->listServiceRollouts($serviceName, $filter);

        /** @var Rollout $element */
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
    $serviceName = '[SERVICE_NAME]';
    $filter = '[FILTER]';

    list_service_rollouts_sample($serviceName, $filter);
}
// [END servicemanagement_v1_generated_ServiceManager_ListServiceRollouts_sync]
