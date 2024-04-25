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

// [START monitoring_v3_generated_ServiceMonitoringService_ListServiceLevelObjectives_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Monitoring\V3\Client\ServiceMonitoringServiceClient;
use Google\Cloud\Monitoring\V3\ListServiceLevelObjectivesRequest;
use Google\Cloud\Monitoring\V3\ServiceLevelObjective;

/**
 * List the `ServiceLevelObjective`s for the given `Service`.
 *
 * @param string $formattedParent Resource name of the parent containing the listed SLOs, either a
 *                                project or a Monitoring Metrics Scope. The formats are:
 *
 *                                projects/[PROJECT_ID_OR_NUMBER]/services/[SERVICE_ID]
 *                                workspaces/[HOST_PROJECT_ID_OR_NUMBER]/services/-
 *                                Please see {@see ServiceMonitoringServiceClient::serviceName()} for help formatting this field.
 */
function list_service_level_objectives_sample(string $formattedParent): void
{
    // Create a client.
    $serviceMonitoringServiceClient = new ServiceMonitoringServiceClient();

    // Prepare the request message.
    $request = (new ListServiceLevelObjectivesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $serviceMonitoringServiceClient->listServiceLevelObjectives($request);

        /** @var ServiceLevelObjective $element */
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
    $formattedParent = ServiceMonitoringServiceClient::serviceName('[PROJECT]', '[SERVICE]');

    list_service_level_objectives_sample($formattedParent);
}
// [END monitoring_v3_generated_ServiceMonitoringService_ListServiceLevelObjectives_sync]
