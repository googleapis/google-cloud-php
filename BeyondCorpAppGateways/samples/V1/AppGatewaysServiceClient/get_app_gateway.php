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

// [START beyondcorp_v1_generated_AppGatewaysService_GetAppGateway_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BeyondCorp\AppGateways\V1\AppGateway;
use Google\Cloud\BeyondCorp\AppGateways\V1\AppGatewaysServiceClient;

/**
 * Gets details of a single AppGateway.
 *
 * @param string $formattedName BeyondCorp AppGateway name using the form:
 *                              `projects/{project_id}/locations/{location_id}/appGateways/{app_gateway_id}`
 *                              Please see {@see AppGatewaysServiceClient::appGatewayName()} for help formatting this field.
 */
function get_app_gateway_sample(string $formattedName): void
{
    // Create a client.
    $appGatewaysServiceClient = new AppGatewaysServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var AppGateway $response */
        $response = $appGatewaysServiceClient->getAppGateway($formattedName);
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
    $formattedName = AppGatewaysServiceClient::appGatewayName(
        '[PROJECT]',
        '[LOCATION]',
        '[APP_GATEWAY]'
    );

    get_app_gateway_sample($formattedName);
}
// [END beyondcorp_v1_generated_AppGatewaysService_GetAppGateway_sync]
