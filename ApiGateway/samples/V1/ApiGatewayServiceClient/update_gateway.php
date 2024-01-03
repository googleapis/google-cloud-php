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

// [START apigateway_v1_generated_ApiGatewayService_UpdateGateway_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ApiGateway\V1\Client\ApiGatewayServiceClient;
use Google\Cloud\ApiGateway\V1\Gateway;
use Google\Cloud\ApiGateway\V1\UpdateGatewayRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single Gateway.
 *
 * @param string $formattedGatewayApiConfig Resource name of the API Config for this Gateway.
 *                                          Format: projects/{project}/locations/global/apis/{api}/configs/{apiConfig}
 *                                          Please see {@see ApiGatewayServiceClient::apiConfigName()} for help formatting this field.
 */
function update_gateway_sample(string $formattedGatewayApiConfig): void
{
    // Create a client.
    $apiGatewayServiceClient = new ApiGatewayServiceClient();

    // Prepare the request message.
    $gateway = (new Gateway())
        ->setApiConfig($formattedGatewayApiConfig);
    $request = (new UpdateGatewayRequest())
        ->setGateway($gateway);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $apiGatewayServiceClient->updateGateway($request);
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
    $formattedGatewayApiConfig = ApiGatewayServiceClient::apiConfigName(
        '[PROJECT]',
        '[API]',
        '[API_CONFIG]'
    );

    update_gateway_sample($formattedGatewayApiConfig);
}
// [END apigateway_v1_generated_ApiGatewayService_UpdateGateway_sync]
