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

// [START networkservices_v1_generated_DepService_DeleteLbRouteExtension_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\DepServiceClient;
use Google\Cloud\NetworkServices\V1\DeleteLbRouteExtensionRequest;
use Google\Rpc\Status;

/**
 * Deletes the specified `LbRouteExtension` resource.
 *
 * @param string $formattedName The name of the `LbRouteExtension` resource to delete. Must be in
 *                              the format
 *                              `projects/{project}/locations/{location}/lbRouteExtensions/{lb_route_extension}`. Please see
 *                              {@see DepServiceClient::lbRouteExtensionName()} for help formatting this field.
 */
function delete_lb_route_extension_sample(string $formattedName): void
{
    // Create a client.
    $depServiceClient = new DepServiceClient();

    // Prepare the request message.
    $request = (new DeleteLbRouteExtensionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $depServiceClient->deleteLbRouteExtension($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = DepServiceClient::lbRouteExtensionName(
        '[PROJECT]',
        '[LOCATION]',
        '[LB_ROUTE_EXTENSION]'
    );

    delete_lb_route_extension_sample($formattedName);
}
// [END networkservices_v1_generated_DepService_DeleteLbRouteExtension_sync]
