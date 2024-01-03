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

// [START networkconnectivity_v1_generated_PolicyBasedRoutingService_CreatePolicyBasedRoute_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkConnectivity\V1\Client\PolicyBasedRoutingServiceClient;
use Google\Cloud\NetworkConnectivity\V1\CreatePolicyBasedRouteRequest;
use Google\Cloud\NetworkConnectivity\V1\PolicyBasedRoute;
use Google\Cloud\NetworkConnectivity\V1\PolicyBasedRoute\Filter;
use Google\Cloud\NetworkConnectivity\V1\PolicyBasedRoute\Filter\ProtocolVersion;
use Google\Rpc\Status;

/**
 * Creates a new PolicyBasedRoute in a given project and location.
 *
 * @param string $formattedParent                       The parent resource's name of the PolicyBasedRoute. Please see
 *                                                      {@see PolicyBasedRoutingServiceClient::locationName()} for help formatting this field.
 * @param string $policyBasedRouteId                    Unique id for the Policy Based Route to create.
 * @param string $formattedPolicyBasedRouteNetwork      Fully-qualified URL of the network that this route applies to.
 *                                                      e.g. projects/my-project/global/networks/my-network. Please see
 *                                                      {@see PolicyBasedRoutingServiceClient::networkName()} for help formatting this field.
 * @param int    $policyBasedRouteFilterProtocolVersion Internet protocol versions this policy based route applies to.
 *                                                      For this version, only IPV4 is supported.
 */
function create_policy_based_route_sample(
    string $formattedParent,
    string $policyBasedRouteId,
    string $formattedPolicyBasedRouteNetwork,
    int $policyBasedRouteFilterProtocolVersion
): void {
    // Create a client.
    $policyBasedRoutingServiceClient = new PolicyBasedRoutingServiceClient();

    // Prepare the request message.
    $policyBasedRouteFilter = (new Filter())
        ->setProtocolVersion($policyBasedRouteFilterProtocolVersion);
    $policyBasedRoute = (new PolicyBasedRoute())
        ->setNetwork($formattedPolicyBasedRouteNetwork)
        ->setFilter($policyBasedRouteFilter);
    $request = (new CreatePolicyBasedRouteRequest())
        ->setParent($formattedParent)
        ->setPolicyBasedRouteId($policyBasedRouteId)
        ->setPolicyBasedRoute($policyBasedRoute);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $policyBasedRoutingServiceClient->createPolicyBasedRoute($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PolicyBasedRoute $result */
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
    $formattedParent = PolicyBasedRoutingServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $policyBasedRouteId = '[POLICY_BASED_ROUTE_ID]';
    $formattedPolicyBasedRouteNetwork = PolicyBasedRoutingServiceClient::networkName(
        '[PROJECT]',
        '[RESOURCE_ID]'
    );
    $policyBasedRouteFilterProtocolVersion = ProtocolVersion::PROTOCOL_VERSION_UNSPECIFIED;

    create_policy_based_route_sample(
        $formattedParent,
        $policyBasedRouteId,
        $formattedPolicyBasedRouteNetwork,
        $policyBasedRouteFilterProtocolVersion
    );
}
// [END networkconnectivity_v1_generated_PolicyBasedRoutingService_CreatePolicyBasedRoute_sync]
