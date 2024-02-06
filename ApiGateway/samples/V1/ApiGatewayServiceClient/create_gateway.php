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

// [START apigateway_v1_generated_ApiGatewayService_CreateGateway_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ApiGateway\V1\Client\ApiGatewayServiceClient;
use Google\Cloud\ApiGateway\V1\CreateGatewayRequest;
use Google\Cloud\ApiGateway\V1\Gateway;
use Google\Rpc\Status;

/**
 * Creates a new Gateway in a given project and location.
 *
 * @param string $formattedParent           Parent resource of the Gateway, of the form:
 *                                          `projects/&#42;/locations/*`
 *                                          Please see {@see ApiGatewayServiceClient::locationName()} for help formatting this field.
 * @param string $gatewayId                 Identifier to assign to the Gateway. Must be unique within scope of
 *                                          the parent resource.
 * @param string $formattedGatewayApiConfig Resource name of the API Config for this Gateway.
 *                                          Format: projects/{project}/locations/global/apis/{api}/configs/{apiConfig}
 *                                          Please see {@see ApiGatewayServiceClient::apiConfigName()} for help formatting this field.
 */
function create_gateway_sample(
    string $formattedParent,
    string $gatewayId,
    string $formattedGatewayApiConfig
): void {
    // Create a client.
    $apiGatewayServiceClient = new ApiGatewayServiceClient();

    // Prepare the request message.
    $gateway = (new Gateway())
        ->setApiConfig($formattedGatewayApiConfig);
    $request = (new CreateGatewayRequest())
        ->setParent($formattedParent)
        ->setGatewayId($gatewayId)
        ->setGateway($gateway);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $apiGatewayServiceClient->createGateway($request);
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
    $formattedParent = ApiGatewayServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $gatewayId = '[GATEWAY_ID]';
    $formattedGatewayApiConfig = ApiGatewayServiceClient::apiConfigName(
        '[PROJECT]',
        '[API]',
        '[API_CONFIG]'
    );

    create_gateway_sample($formattedParent, $gatewayId, $formattedGatewayApiConfig);
}
// [END apigateway_v1_generated_ApiGatewayService_CreateGateway_sync]
