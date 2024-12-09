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

// [START networkservices_v1_generated_NetworkServices_CreateGrpcRoute_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\CreateGrpcRouteRequest;
use Google\Cloud\NetworkServices\V1\GrpcRoute;
use Google\Cloud\NetworkServices\V1\GrpcRoute\RouteAction;
use Google\Cloud\NetworkServices\V1\GrpcRoute\RouteRule;
use Google\Rpc\Status;

/**
 * Creates a new GrpcRoute in a given project and location.
 *
 * @param string $formattedParent           The parent resource of the GrpcRoute. Must be in the
 *                                          format `projects/&#42;/locations/global`. Please see
 *                                          {@see NetworkServicesClient::locationName()} for help formatting this field.
 * @param string $grpcRouteId               Short name of the GrpcRoute resource to be created.
 * @param string $grpcRouteName             Name of the GrpcRoute resource. It matches pattern
 *                                          `projects/&#42;/locations/global/grpcRoutes/<grpc_route_name>`
 * @param string $grpcRouteHostnamesElement Service hostnames with an optional port for which this route
 *                                          describes traffic.
 *
 *                                          Format: <hostname>[:<port>]
 *
 *                                          Hostname is the fully qualified domain name of a network host. This matches
 *                                          the RFC 1123 definition of a hostname with 2 notable exceptions:
 *                                          - IPs are not allowed.
 *                                          - A hostname may be prefixed with a wildcard label (`*.`). The wildcard
 *                                          label must appear by itself as the first label.
 *
 *                                          Hostname can be "precise" which is a domain name without the terminating
 *                                          dot of a network host (e.g. `foo.example.com`) or "wildcard", which is a
 *                                          domain name prefixed with a single wildcard label (e.g. `*.example.com`).
 *
 *                                          Note that as per RFC1035 and RFC1123, a label must consist of lower case
 *                                          alphanumeric characters or '-', and must start and end with an alphanumeric
 *                                          character. No other punctuation is allowed.
 *
 *                                          The routes associated with a Mesh or Gateway must have unique hostnames. If
 *                                          you attempt to attach multiple routes with conflicting hostnames, the
 *                                          configuration will be rejected.
 *
 *                                          For example, while it is acceptable for routes for the hostnames
 *                                          `*.foo.bar.com` and `*.bar.com` to be associated with the same route, it is
 *                                          not possible to associate two routes both with `*.bar.com` or both with
 *                                          `bar.com`.
 *
 *                                          If a port is specified, then gRPC clients must use the channel URI with the
 *                                          port to match this rule (i.e. "xds:///service:123"), otherwise they must
 *                                          supply the URI without a port (i.e. "xds:///service").
 */
function create_grpc_route_sample(
    string $formattedParent,
    string $grpcRouteId,
    string $grpcRouteName,
    string $grpcRouteHostnamesElement
): void {
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $grpcRouteHostnames = [$grpcRouteHostnamesElement,];
    $grpcRouteRulesAction = new RouteAction();
    $routeRule = (new RouteRule())
        ->setAction($grpcRouteRulesAction);
    $grpcRouteRules = [$routeRule,];
    $grpcRoute = (new GrpcRoute())
        ->setName($grpcRouteName)
        ->setHostnames($grpcRouteHostnames)
        ->setRules($grpcRouteRules);
    $request = (new CreateGrpcRouteRequest())
        ->setParent($formattedParent)
        ->setGrpcRouteId($grpcRouteId)
        ->setGrpcRoute($grpcRoute);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->createGrpcRoute($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GrpcRoute $result */
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
    $grpcRouteId = '[GRPC_ROUTE_ID]';
    $grpcRouteName = '[NAME]';
    $grpcRouteHostnamesElement = '[HOSTNAMES]';

    create_grpc_route_sample(
        $formattedParent,
        $grpcRouteId,
        $grpcRouteName,
        $grpcRouteHostnamesElement
    );
}
// [END networkservices_v1_generated_NetworkServices_CreateGrpcRoute_sync]
