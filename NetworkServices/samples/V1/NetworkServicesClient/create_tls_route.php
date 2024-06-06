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

// [START networkservices_v1_generated_NetworkServices_CreateTlsRoute_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\TlsRoute;
use Google\Cloud\NetworkServices\V1\TlsRoute\RouteAction;
use Google\Cloud\NetworkServices\V1\TlsRoute\RouteDestination;
use Google\Cloud\NetworkServices\V1\TlsRoute\RouteMatch;
use Google\Cloud\NetworkServices\V1\TlsRoute\RouteRule;
use Google\Rpc\Status;

/**
 * Creates a new TlsRoute in a given project and location.
 *
 * @param string $formattedParent                                     The parent resource of the TlsRoute. Must be in the
 *                                                                    format `projects/&#42;/locations/global`. Please see
 *                                                                    {@see NetworkServicesClient::locationName()} for help formatting this field.
 * @param string $tlsRouteId                                          Short name of the TlsRoute resource to be created.
 * @param string $tlsRouteName                                        Name of the TlsRoute resource. It matches pattern
 *                                                                    `projects/&#42;/locations/global/tlsRoutes/tls_route_name>`.
 * @param string $formattedTlsRouteRulesActionDestinationsServiceName The URL of a BackendService to route traffic to. Please see
 *                                                                    {@see NetworkServicesClient::backendServiceName()} for help formatting this field.
 */
function create_tls_route_sample(
    string $formattedParent,
    string $tlsRouteId,
    string $tlsRouteName,
    string $formattedTlsRouteRulesActionDestinationsServiceName
): void {
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $tlsRouteRulesMatches = [new RouteMatch()];
    $routeDestination = (new RouteDestination())
        ->setServiceName($formattedTlsRouteRulesActionDestinationsServiceName);
    $tlsRouteRulesActionDestinations = [$routeDestination,];
    $tlsRouteRulesAction = (new RouteAction())
        ->setDestinations($tlsRouteRulesActionDestinations);
    $routeRule = (new RouteRule())
        ->setMatches($tlsRouteRulesMatches)
        ->setAction($tlsRouteRulesAction);
    $tlsRouteRules = [$routeRule,];
    $tlsRoute = (new TlsRoute())
        ->setName($tlsRouteName)
        ->setRules($tlsRouteRules);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->createTlsRoute($formattedParent, $tlsRouteId, $tlsRoute);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var TlsRoute $result */
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
    $tlsRouteId = '[TLS_ROUTE_ID]';
    $tlsRouteName = '[NAME]';
    $formattedTlsRouteRulesActionDestinationsServiceName = NetworkServicesClient::backendServiceName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKEND_SERVICE]'
    );

    create_tls_route_sample(
        $formattedParent,
        $tlsRouteId,
        $tlsRouteName,
        $formattedTlsRouteRulesActionDestinationsServiceName
    );
}
// [END networkservices_v1_generated_NetworkServices_CreateTlsRoute_sync]
