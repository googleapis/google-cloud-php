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

// [START servicemanagement_v1_generated_ServiceManager_GetServiceConfig_sync]
use Google\ApiCore\ApiException;
use Google\Api\Service;
use Google\Cloud\ServiceManagement\V1\ServiceManagerClient;

/**
 * Gets a service configuration (version) for a managed service.
 *
 * @param string $serviceName The name of the service.  See the
 *                            [overview](https://cloud.google.com/service-infrastructure/docs/overview) for naming requirements.  For
 *                            example: `example.googleapis.com`.
 * @param string $configId    The id of the service configuration resource.
 *
 *                            This field must be specified for the server to return all fields, including
 *                            `SourceInfo`.
 */
function get_service_config_sample(string $serviceName, string $configId): void
{
    // Create a client.
    $serviceManagerClient = new ServiceManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var Service $response */
        $response = $serviceManagerClient->getServiceConfig($serviceName, $configId);
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
    $serviceName = '[SERVICE_NAME]';
    $configId = '[CONFIG_ID]';

    get_service_config_sample($serviceName, $configId);
}
// [END servicemanagement_v1_generated_ServiceManager_GetServiceConfig_sync]
