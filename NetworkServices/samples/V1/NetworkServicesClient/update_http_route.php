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

// [START networkservices_v1_generated_NetworkServices_UpdateHttpRoute_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\HttpRoute;
use Google\Cloud\NetworkServices\V1\HttpRoute\RouteRule;
use Google\Cloud\NetworkServices\V1\UpdateHttpRouteRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single HttpRoute.
 *
 * @param string $httpRouteHostnamesElement Hostnames define a set of hosts that should match against the
 *                                          HTTP host header to select a HttpRoute to process the request. Hostname is
 *                                          the fully qualified domain name of a network host, as defined by RFC 1123
 *                                          with the exception that:
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
 *                                          The routes associated with a Mesh or Gateways  must have unique hostnames.
 *                                          If you attempt to attach multiple routes with conflicting hostnames,
 *                                          the configuration will be rejected.
 *
 *                                          For example, while it is acceptable for routes for the hostnames
 *                                          `*.foo.bar.com` and `*.bar.com` to be associated with the same Mesh (or
 *                                          Gateways under the same scope), it is not possible to associate two routes
 *                                          both with `*.bar.com` or both with `bar.com`.
 */
function update_http_route_sample(string $httpRouteHostnamesElement): void
{
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $httpRouteHostnames = [$httpRouteHostnamesElement,];
    $httpRouteRules = [new RouteRule()];
    $httpRoute = (new HttpRoute())
        ->setHostnames($httpRouteHostnames)
        ->setRules($httpRouteRules);
    $request = (new UpdateHttpRouteRequest())
        ->setHttpRoute($httpRoute);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->updateHttpRoute($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var HttpRoute $result */
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
    $httpRouteHostnamesElement = '[HOSTNAMES]';

    update_http_route_sample($httpRouteHostnamesElement);
}
// [END networkservices_v1_generated_NetworkServices_UpdateHttpRoute_sync]
