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

// [START beyondcorp_v1_generated_AppGatewaysService_CreateAppGateway_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BeyondCorp\AppGateways\V1\AppGateway;
use Google\Cloud\BeyondCorp\AppGateways\V1\AppGateway\HostType;
use Google\Cloud\BeyondCorp\AppGateways\V1\AppGateway\Type;
use Google\Cloud\BeyondCorp\AppGateways\V1\AppGatewaysServiceClient;
use Google\Rpc\Status;

/**
 * Creates a new AppGateway in a given project and location.
 *
 * @param string $formattedParent    The resource project name of the AppGateway location using the
 *                                   form: `projects/{project_id}/locations/{location_id}`
 *                                   Please see {@see AppGatewaysServiceClient::locationName()} for help formatting this field.
 * @param string $appGatewayName     Unique resource name of the AppGateway.
 *                                   The name is ignored when creating an AppGateway.
 * @param int    $appGatewayType     The type of network connectivity used by the AppGateway.
 * @param int    $appGatewayHostType The type of hosting used by the AppGateway.
 */
function create_app_gateway_sample(
    string $formattedParent,
    string $appGatewayName,
    int $appGatewayType,
    int $appGatewayHostType
): void {
    // Create a client.
    $appGatewaysServiceClient = new AppGatewaysServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $appGateway = (new AppGateway())
        ->setName($appGatewayName)
        ->setType($appGatewayType)
        ->setHostType($appGatewayHostType);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $appGatewaysServiceClient->createAppGateway($formattedParent, $appGateway);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AppGateway $result */
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
    $formattedParent = AppGatewaysServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $appGatewayName = '[NAME]';
    $appGatewayType = Type::TYPE_UNSPECIFIED;
    $appGatewayHostType = HostType::HOST_TYPE_UNSPECIFIED;

    create_app_gateway_sample($formattedParent, $appGatewayName, $appGatewayType, $appGatewayHostType);
}
// [END beyondcorp_v1_generated_AppGatewaysService_CreateAppGateway_sync]
