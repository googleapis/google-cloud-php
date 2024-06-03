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

// [START networkconnectivity_v1_generated_PolicyBasedRoutingService_DeletePolicyBasedRoute_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkConnectivity\V1\Client\PolicyBasedRoutingServiceClient;
use Google\Cloud\NetworkConnectivity\V1\DeletePolicyBasedRouteRequest;
use Google\Rpc\Status;

/**
 * Deletes a single PolicyBasedRoute.
 *
 * @param string $formattedName Name of the PolicyBasedRoute resource to delete. Please see
 *                              {@see PolicyBasedRoutingServiceClient::policyBasedRouteName()} for help formatting this field.
 */
function delete_policy_based_route_sample(string $formattedName): void
{
    // Create a client.
    $policyBasedRoutingServiceClient = new PolicyBasedRoutingServiceClient();

    // Prepare the request message.
    $request = (new DeletePolicyBasedRouteRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $policyBasedRoutingServiceClient->deletePolicyBasedRoute($request);
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
    $formattedName = PolicyBasedRoutingServiceClient::policyBasedRouteName(
        '[PROJECT]',
        '[POLICY_BASED_ROUTE]'
    );

    delete_policy_based_route_sample($formattedName);
}
// [END networkconnectivity_v1_generated_PolicyBasedRoutingService_DeletePolicyBasedRoute_sync]
