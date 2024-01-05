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

// [START monitoring_v3_generated_ServiceMonitoringService_CreateServiceLevelObjective_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\Client\ServiceMonitoringServiceClient;
use Google\Cloud\Monitoring\V3\CreateServiceLevelObjectiveRequest;
use Google\Cloud\Monitoring\V3\ServiceLevelObjective;

/**
 * Create a `ServiceLevelObjective` for the given `Service`.
 *
 * @param string $formattedParent Resource name of the parent `Service`. The format is:
 *
 *                                projects/[PROJECT_ID_OR_NUMBER]/services/[SERVICE_ID]
 *                                Please see {@see ServiceMonitoringServiceClient::serviceName()} for help formatting this field.
 */
function create_service_level_objective_sample(string $formattedParent): void
{
    // Create a client.
    $serviceMonitoringServiceClient = new ServiceMonitoringServiceClient();

    // Prepare the request message.
    $serviceLevelObjective = new ServiceLevelObjective();
    $request = (new CreateServiceLevelObjectiveRequest())
        ->setParent($formattedParent)
        ->setServiceLevelObjective($serviceLevelObjective);

    // Call the API and handle any network failures.
    try {
        /** @var ServiceLevelObjective $response */
        $response = $serviceMonitoringServiceClient->createServiceLevelObjective($request);
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
    $formattedParent = ServiceMonitoringServiceClient::serviceName('[PROJECT]', '[SERVICE]');

    create_service_level_objective_sample($formattedParent);
}
// [END monitoring_v3_generated_ServiceMonitoringService_CreateServiceLevelObjective_sync]
