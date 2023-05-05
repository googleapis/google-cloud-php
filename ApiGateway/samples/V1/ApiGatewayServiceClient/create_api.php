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

// [START apigateway_v1_generated_ApiGatewayService_CreateApi_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ApiGateway\V1\Api;
use Google\Cloud\ApiGateway\V1\ApiGatewayServiceClient;
use Google\Rpc\Status;

/**
 * Creates a new Api in a given project and location.
 *
 * @param string $formattedParent Parent resource of the API, of the form:
 *                                `projects/&#42;/locations/global`
 *                                Please see {@see ApiGatewayServiceClient::locationName()} for help formatting this field.
 * @param string $apiId           Identifier to assign to the API. Must be unique within scope of
 *                                the parent resource.
 */
function create_api_sample(string $formattedParent, string $apiId): void
{
    // Create a client.
    $apiGatewayServiceClient = new ApiGatewayServiceClient();

    // Prepare the request message.
    $api = new Api();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $apiGatewayServiceClient->createApi($formattedParent, $apiId, $api);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Api $result */
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
    $apiId = '[API_ID]';

    create_api_sample($formattedParent, $apiId);
}
// [END apigateway_v1_generated_ApiGatewayService_CreateApi_sync]
