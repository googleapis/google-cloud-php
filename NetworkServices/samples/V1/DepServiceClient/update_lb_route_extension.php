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

// [START networkservices_v1_generated_DepService_UpdateLbRouteExtension_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\DepServiceClient;
use Google\Cloud\NetworkServices\V1\ExtensionChain;
use Google\Cloud\NetworkServices\V1\ExtensionChain\Extension;
use Google\Cloud\NetworkServices\V1\ExtensionChain\MatchCondition;
use Google\Cloud\NetworkServices\V1\LbRouteExtension;
use Google\Cloud\NetworkServices\V1\LoadBalancingScheme;
use Google\Cloud\NetworkServices\V1\UpdateLbRouteExtensionRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of the specified `LbRouteExtension` resource.
 *
 * @param string $lbRouteExtensionName                                       Identifier. Name of the `LbRouteExtension` resource in the
 *                                                                           following format:
 *                                                                           `projects/{project}/locations/{location}/lbRouteExtensions/{lb_route_extension}`.
 * @param string $lbRouteExtensionForwardingRulesElement                     A list of references to the forwarding rules to which this
 *                                                                           service extension is attached. At least one forwarding rule is required.
 *                                                                           Only one `LbRouteExtension` resource can be associated with a forwarding
 *                                                                           rule.
 * @param string $lbRouteExtensionExtensionChainsName                        The name for this extension chain.
 *                                                                           The name is logged as part of the HTTP request logs.
 *                                                                           The name must conform with RFC-1034, is restricted to lower-cased letters,
 *                                                                           numbers and hyphens, and can have a maximum length of 63 characters.
 *                                                                           Additionally, the first character must be a letter and the last a letter or
 *                                                                           a number.
 * @param string $lbRouteExtensionExtensionChainsMatchConditionCelExpression A Common Expression Language (CEL) expression that is used to
 *                                                                           match requests for which the extension chain is executed.
 *
 *                                                                           For more information, see [CEL matcher language
 *                                                                           reference](https://cloud.google.com/service-extensions/docs/cel-matcher-language-reference).
 * @param string $lbRouteExtensionExtensionChainsExtensionsName              The name for this extension.
 *                                                                           The name is logged as part of the HTTP request logs.
 *                                                                           The name must conform with RFC-1034, is restricted to lower-cased
 *                                                                           letters, numbers and hyphens, and can have a maximum length of 63
 *                                                                           characters. Additionally, the first character must be a letter and the
 *                                                                           last a letter or a number.
 * @param string $lbRouteExtensionExtensionChainsExtensionsService           The reference to the service that runs the extension.
 *
 *                                                                           To configure a callout extension, `service` must be a fully-qualified
 *                                                                           reference
 *                                                                           to a [backend
 *                                                                           service](https://cloud.google.com/compute/docs/reference/rest/v1/backendServices)
 *                                                                           in the format:
 *                                                                           `https://www.googleapis.com/compute/v1/projects/{project}/regions/{region}/backendServices/{backendService}`
 *                                                                           or
 *                                                                           `https://www.googleapis.com/compute/v1/projects/{project}/global/backendServices/{backendService}`.
 *
 *                                                                           To configure a plugin extension, `service` must be a reference
 *                                                                           to a [`WasmPlugin`
 *                                                                           resource](https://cloud.google.com/service-extensions/docs/reference/rest/v1beta1/projects.locations.wasmPlugins)
 *                                                                           in the format:
 *                                                                           `projects/{project}/locations/{location}/wasmPlugins/{plugin}`
 *                                                                           or
 *                                                                           `//networkservices.googleapis.com/projects/{project}/locations/{location}/wasmPlugins/{wasmPlugin}`.
 *
 *                                                                           Plugin extensions are currently supported for the
 *                                                                           `LbTrafficExtension`, the `LbRouteExtension`, and the `LbEdgeExtension`
 *                                                                           resources.
 * @param int    $lbRouteExtensionLoadBalancingScheme                        All backend services and forwarding rules referenced by this
 *                                                                           extension must share the same load balancing scheme. Supported values:
 *                                                                           `INTERNAL_MANAGED`, `EXTERNAL_MANAGED`. For more information, refer to
 *                                                                           [Backend services
 *                                                                           overview](https://cloud.google.com/load-balancing/docs/backend-service).
 */
function update_lb_route_extension_sample(
    string $lbRouteExtensionName,
    string $lbRouteExtensionForwardingRulesElement,
    string $lbRouteExtensionExtensionChainsName,
    string $lbRouteExtensionExtensionChainsMatchConditionCelExpression,
    string $lbRouteExtensionExtensionChainsExtensionsName,
    string $lbRouteExtensionExtensionChainsExtensionsService,
    int $lbRouteExtensionLoadBalancingScheme
): void {
    // Create a client.
    $depServiceClient = new DepServiceClient();

    // Prepare the request message.
    $lbRouteExtensionForwardingRules = [$lbRouteExtensionForwardingRulesElement,];
    $lbRouteExtensionExtensionChainsMatchCondition = (new MatchCondition())
        ->setCelExpression($lbRouteExtensionExtensionChainsMatchConditionCelExpression);
    $extension = (new Extension())
        ->setName($lbRouteExtensionExtensionChainsExtensionsName)
        ->setService($lbRouteExtensionExtensionChainsExtensionsService);
    $lbRouteExtensionExtensionChainsExtensions = [$extension,];
    $extensionChain = (new ExtensionChain())
        ->setName($lbRouteExtensionExtensionChainsName)
        ->setMatchCondition($lbRouteExtensionExtensionChainsMatchCondition)
        ->setExtensions($lbRouteExtensionExtensionChainsExtensions);
    $lbRouteExtensionExtensionChains = [$extensionChain,];
    $lbRouteExtension = (new LbRouteExtension())
        ->setName($lbRouteExtensionName)
        ->setForwardingRules($lbRouteExtensionForwardingRules)
        ->setExtensionChains($lbRouteExtensionExtensionChains)
        ->setLoadBalancingScheme($lbRouteExtensionLoadBalancingScheme);
    $request = (new UpdateLbRouteExtensionRequest())
        ->setLbRouteExtension($lbRouteExtension);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $depServiceClient->updateLbRouteExtension($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var LbRouteExtension $result */
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
    $lbRouteExtensionName = '[NAME]';
    $lbRouteExtensionForwardingRulesElement = '[FORWARDING_RULES]';
    $lbRouteExtensionExtensionChainsName = '[NAME]';
    $lbRouteExtensionExtensionChainsMatchConditionCelExpression = '[CEL_EXPRESSION]';
    $lbRouteExtensionExtensionChainsExtensionsName = '[NAME]';
    $lbRouteExtensionExtensionChainsExtensionsService = '[SERVICE]';
    $lbRouteExtensionLoadBalancingScheme = LoadBalancingScheme::LOAD_BALANCING_SCHEME_UNSPECIFIED;

    update_lb_route_extension_sample(
        $lbRouteExtensionName,
        $lbRouteExtensionForwardingRulesElement,
        $lbRouteExtensionExtensionChainsName,
        $lbRouteExtensionExtensionChainsMatchConditionCelExpression,
        $lbRouteExtensionExtensionChainsExtensionsName,
        $lbRouteExtensionExtensionChainsExtensionsService,
        $lbRouteExtensionLoadBalancingScheme
    );
}
// [END networkservices_v1_generated_DepService_UpdateLbRouteExtension_sync]
