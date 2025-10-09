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

// [START networkservices_v1_generated_NetworkServices_UpdateGateway_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\Gateway;
use Google\Cloud\NetworkServices\V1\UpdateGatewayRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single Gateway.
 *
 * @param int $gatewayPortsElement One or more port numbers (1-65535), on which the Gateway will
 *                                 receive traffic. The proxy binds to the specified ports.
 *                                 Gateways of type 'SECURE_WEB_GATEWAY' are limited to 1 port.
 *                                 Gateways of type 'OPEN_MESH' listen on 0.0.0.0 for IPv4 and :: for IPv6 and
 *                                 support multiple ports.
 */
function update_gateway_sample(int $gatewayPortsElement): void
{
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $gatewayPorts = [$gatewayPortsElement,];
    $gateway = (new Gateway())
        ->setPorts($gatewayPorts);
    $request = (new UpdateGatewayRequest())
        ->setGateway($gateway);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->updateGateway($request);
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
    $gatewayPortsElement = 0;

    update_gateway_sample($gatewayPortsElement);
}
// [END networkservices_v1_generated_NetworkServices_UpdateGateway_sync]
