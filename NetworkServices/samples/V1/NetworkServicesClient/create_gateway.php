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

// [START networkservices_v1_generated_NetworkServices_CreateGateway_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Gateway;
use Google\Cloud\NetworkServices\V1\NetworkServicesClient;
use Google\Rpc\Status;

/**
 * Creates a new Gateway in a given project and location.
 *
 * @param string $formattedParent     The parent resource of the Gateway. Must be in the
 *                                    format `projects/&#42;/locations/*`. Please see
 *                                    {@see NetworkServicesClient::locationName()} for help formatting this field.
 * @param string $gatewayId           Short name of the Gateway resource to be created.
 * @param string $gatewayName         Name of the Gateway resource. It matches pattern
 *                                    `projects/&#42;/locations/&#42;/gateways/<gateway_name>`.
 * @param int    $gatewayPortsElement One or more ports that the Gateway must receive traffic on. The
 *                                    proxy binds to the ports specified. Gateway listen on 0.0.0.0 on the ports
 *                                    specified below.
 * @param string $gatewayScope        Immutable. Scope determines how configuration across multiple
 *                                    Gateway instances are merged. The configuration for multiple Gateway
 *                                    instances with the same scope will be merged as presented as a single
 *                                    coniguration to the proxy/load balancer.
 *
 *                                    Max length 64 characters.
 *                                    Scope should start with a letter and can only have letters, numbers,
 *                                    hyphens.
 */
function create_gateway_sample(
    string $formattedParent,
    string $gatewayId,
    string $gatewayName,
    int $gatewayPortsElement,
    string $gatewayScope
): void {
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $gatewayPorts = [$gatewayPortsElement,];
    $gateway = (new Gateway())
        ->setName($gatewayName)
        ->setPorts($gatewayPorts)
        ->setScope($gatewayScope);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->createGateway($formattedParent, $gatewayId, $gateway);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Gateway $result */
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
    $gatewayId = '[GATEWAY_ID]';
    $gatewayName = '[NAME]';
    $gatewayPortsElement = 0;
    $gatewayScope = '[SCOPE]';

    create_gateway_sample(
        $formattedParent,
        $gatewayId,
        $gatewayName,
        $gatewayPortsElement,
        $gatewayScope
    );
}
// [END networkservices_v1_generated_NetworkServices_CreateGateway_sync]
