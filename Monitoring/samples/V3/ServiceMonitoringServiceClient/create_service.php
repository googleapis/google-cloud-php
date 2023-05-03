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

// [START monitoring_v3_generated_ServiceMonitoringService_CreateService_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\Service;
use Google\Cloud\Monitoring\V3\ServiceMonitoringServiceClient;

/**
 * Create a `Service`.
 *
 * @param string $parent Resource [name](https://cloud.google.com/monitoring/api/v3#project_name) of
 *                       the parent workspace. The format is:
 *
 *                       projects/[PROJECT_ID_OR_NUMBER]
 */
function create_service_sample(string $parent): void
{
    // Create a client.
    $serviceMonitoringServiceClient = new ServiceMonitoringServiceClient();

    // Prepare the request message.
    $service = new Service();

    // Call the API and handle any network failures.
    try {
        /** @var Service $response */
        $response = $serviceMonitoringServiceClient->createService($parent, $service);
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

    create_service_sample($parent);
}
// [END monitoring_v3_generated_ServiceMonitoringService_CreateService_sync]
