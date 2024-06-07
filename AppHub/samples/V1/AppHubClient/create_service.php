<?php
/*
 * Copyright 2024 Google LLC
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

// [START apphub_v1_generated_AppHub_CreateService_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AppHub\V1\Client\AppHubClient;
use Google\Cloud\AppHub\V1\CreateServiceRequest;
use Google\Cloud\AppHub\V1\Service;
use Google\Rpc\Status;

/**
 * Creates a Service in an Application.
 *
 * @param string $formattedParent                   Fully qualified name of the parent Application to create the
 *                                                  Service in. Expected format:
 *                                                  `projects/{project}/locations/{location}/applications/{application}`. Please see
 *                                                  {@see AppHubClient::applicationName()} for help formatting this field.
 * @param string $serviceId                         The Service identifier.
 *                                                  Must contain only lowercase letters, numbers
 *                                                  or hyphens, with the first character a letter, the last a letter or a
 *                                                  number, and a 63 character maximum.
 * @param string $formattedServiceDiscoveredService Immutable. The resource name of the original discovered service. Please see
 *                                                  {@see AppHubClient::locationName()} for help formatting this field.
 */
function create_service_sample(
    string $formattedParent,
    string $serviceId,
    string $formattedServiceDiscoveredService
): void {
    // Create a client.
    $appHubClient = new AppHubClient();

    // Prepare the request message.
    $service = (new Service())
        ->setDiscoveredService($formattedServiceDiscoveredService);
    $request = (new CreateServiceRequest())
        ->setParent($formattedParent)
        ->setServiceId($serviceId)
        ->setService($service);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $appHubClient->createService($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Service $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = AppHubClient::applicationName('[PROJECT]', '[LOCATION]', '[APPLICATION]');
    $serviceId = '[SERVICE_ID]';
    $formattedServiceDiscoveredService = AppHubClient::locationName('[PROJECT]', '[LOCATION]');

    create_service_sample($formattedParent, $serviceId, $formattedServiceDiscoveredService);
}
// [END apphub_v1_generated_AppHub_CreateService_sync]
