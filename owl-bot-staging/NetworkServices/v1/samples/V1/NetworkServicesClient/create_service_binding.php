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

// [START networkservices_v1_generated_NetworkServices_CreateServiceBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\CreateServiceBindingRequest;
use Google\Cloud\NetworkServices\V1\ServiceBinding;
use Google\Rpc\Status;

/**
 * Creates a new ServiceBinding in a given project and location.
 *
 * @param string $formattedParent       The parent resource of the ServiceBinding. Must be in the
 *                                      format `projects/&#42;/locations/global`. Please see
 *                                      {@see NetworkServicesClient::locationName()} for help formatting this field.
 * @param string $serviceBindingId      Short name of the ServiceBinding resource to be created.
 * @param string $serviceBindingName    Name of the ServiceBinding resource. It matches pattern
 *                                      `projects/&#42;/locations/global/serviceBindings/service_binding_name`.
 * @param string $serviceBindingService The full service directory service name of the format
 *                                      /projects/&#42;/locations/&#42;/namespaces/&#42;/services/*
 */
function create_service_binding_sample(
    string $formattedParent,
    string $serviceBindingId,
    string $serviceBindingName,
    string $serviceBindingService
): void {
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $serviceBinding = (new ServiceBinding())
        ->setName($serviceBindingName)
        ->setService($serviceBindingService);
    $request = (new CreateServiceBindingRequest())
        ->setParent($formattedParent)
        ->setServiceBindingId($serviceBindingId)
        ->setServiceBinding($serviceBinding);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->createServiceBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ServiceBinding $result */
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
    $formattedParent = NetworkServicesClient::locationName('[PROJECT]', '[LOCATION]');
    $serviceBindingId = '[SERVICE_BINDING_ID]';
    $serviceBindingName = '[NAME]';
    $serviceBindingService = '[SERVICE]';

    create_service_binding_sample(
        $formattedParent,
        $serviceBindingId,
        $serviceBindingName,
        $serviceBindingService
    );
}
// [END networkservices_v1_generated_NetworkServices_CreateServiceBinding_sync]
