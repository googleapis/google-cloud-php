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

// [START networkservices_v1_generated_DepService_CreateLbTrafficExtension_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\DepServiceClient;
use Google\Cloud\NetworkServices\V1\CreateLbTrafficExtensionRequest;
use Google\Cloud\NetworkServices\V1\ExtensionChain;
use Google\Cloud\NetworkServices\V1\ExtensionChain\Extension;
use Google\Cloud\NetworkServices\V1\ExtensionChain\MatchCondition;
use Google\Cloud\NetworkServices\V1\LbTrafficExtension;
use Google\Cloud\NetworkServices\V1\LoadBalancingScheme;
use Google\Rpc\Status;

/**
 * Creates a new `LbTrafficExtension` resource in a given project and
 * location.
 *
 * @param string $formattedParent                                              The parent resource of the `LbTrafficExtension` resource. Must be
 *                                                                             in the format `projects/{project}/locations/{location}`. Please see
 *                                                                             {@see DepServiceClient::locationName()} for help formatting this field.
 * @param string $lbTrafficExtensionId                                         User-provided ID of the `LbTrafficExtension` resource to be
 *                                                                             created.
 * @param string $lbTrafficExtensionName                                       Identifier. Name of the `LbTrafficExtension` resource in the
 *                                                                             following format:
 *                                                                             `projects/{project}/locations/{location}/lbTrafficExtensions/{lb_traffic_extension}`.
 * @param string $lbTrafficExtensionForwardingRulesElement                     A list of references to the forwarding rules to which this
 *                                                                             service extension is attached to. At least one forwarding rule is required.
 *                                                                             There can be only one `LBTrafficExtension` resource per forwarding rule.
 * @param string $lbTrafficExtensionExtensionChainsName                        The name for this extension chain.
 *                                                                             The name is logged as part of the HTTP request logs.
 *                                                                             The name must conform with RFC-1034, is restricted to lower-cased letters,
 *                                                                             numbers and hyphens, and can have a maximum length of 63 characters.
 *                                                                             Additionally, the first character must be a letter and the last a letter or
 *                                                                             a number.
 * @param string $lbTrafficExtensionExtensionChainsMatchConditionCelExpression A Common Expression Language (CEL) expression that is used to
 *                                                                             match requests for which the extension chain is executed.
 *
 *                                                                             For more information, see [CEL matcher language
 *                                                                             reference](https://cloud.google.com/service-extensions/docs/cel-matcher-language-reference).
 * @param string $lbTrafficExtensionExtensionChainsExtensionsName              The name for this extension.
 *                                                                             The name is logged as part of the HTTP request logs.
 *                                                                             The name must conform with RFC-1034, is restricted to lower-cased
 *                                                                             letters, numbers and hyphens, and can have a maximum length of 63
 *                                                                             characters. Additionally, the first character must be a letter and the
 *                                                                             last a letter or a number.
 * @param string $lbTrafficExtensionExtensionChainsExtensionsService           The reference to the service that runs the extension.
 *
 *                                                                             Currently only callout extensions are supported here.
 *
 *                                                                             To configure a callout extension, `service` must be a fully-qualified
 *                                                                             reference
 *                                                                             to a [backend
 *                                                                             service](https://cloud.google.com/compute/docs/reference/rest/v1/backendServices)
 *                                                                             in the format:
 *                                                                             `https://www.googleapis.com/compute/v1/projects/{project}/regions/{region}/backendServices/{backendService}`
 *                                                                             or
 *                                                                             `https://www.googleapis.com/compute/v1/projects/{project}/global/backendServices/{backendService}`.
 * @param int    $lbTrafficExtensionLoadBalancingScheme                        All backend services and forwarding rules referenced by this
 *                                                                             extension must share the same load balancing scheme. Supported values:
 *                                                                             `INTERNAL_MANAGED`, `EXTERNAL_MANAGED`. For more information, refer to
 *                                                                             [Choosing a load
 *                                                                             balancer](https://cloud.google.com/load-balancing/docs/backend-service).
 */
function create_lb_traffic_extension_sample(
    string $formattedParent,
    string $lbTrafficExtensionId,
    string $lbTrafficExtensionName,
    string $lbTrafficExtensionForwardingRulesElement,
    string $lbTrafficExtensionExtensionChainsName,
    string $lbTrafficExtensionExtensionChainsMatchConditionCelExpression,
    string $lbTrafficExtensionExtensionChainsExtensionsName,
    string $lbTrafficExtensionExtensionChainsExtensionsService,
    int $lbTrafficExtensionLoadBalancingScheme
): void {
    // Create a client.
    $depServiceClient = new DepServiceClient();

    // Prepare the request message.
    $lbTrafficExtensionForwardingRules = [$lbTrafficExtensionForwardingRulesElement,];
    $lbTrafficExtensionExtensionChainsMatchCondition = (new MatchCondition())
        ->setCelExpression($lbTrafficExtensionExtensionChainsMatchConditionCelExpression);
    $extension = (new Extension())
        ->setName($lbTrafficExtensionExtensionChainsExtensionsName)
        ->setService($lbTrafficExtensionExtensionChainsExtensionsService);
    $lbTrafficExtensionExtensionChainsExtensions = [$extension,];
    $extensionChain = (new ExtensionChain())
        ->setName($lbTrafficExtensionExtensionChainsName)
        ->setMatchCondition($lbTrafficExtensionExtensionChainsMatchCondition)
        ->setExtensions($lbTrafficExtensionExtensionChainsExtensions);
    $lbTrafficExtensionExtensionChains = [$extensionChain,];
    $lbTrafficExtension = (new LbTrafficExtension())
        ->setName($lbTrafficExtensionName)
        ->setForwardingRules($lbTrafficExtensionForwardingRules)
        ->setExtensionChains($lbTrafficExtensionExtensionChains)
        ->setLoadBalancingScheme($lbTrafficExtensionLoadBalancingScheme);
    $request = (new CreateLbTrafficExtensionRequest())
        ->setParent($formattedParent)
        ->setLbTrafficExtensionId($lbTrafficExtensionId)
        ->setLbTrafficExtension($lbTrafficExtension);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $depServiceClient->createLbTrafficExtension($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var LbTrafficExtension $result */
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
    $formattedParent = DepServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $lbTrafficExtensionId = '[LB_TRAFFIC_EXTENSION_ID]';
    $lbTrafficExtensionName = '[NAME]';
    $lbTrafficExtensionForwardingRulesElement = '[FORWARDING_RULES]';
    $lbTrafficExtensionExtensionChainsName = '[NAME]';
    $lbTrafficExtensionExtensionChainsMatchConditionCelExpression = '[CEL_EXPRESSION]';
    $lbTrafficExtensionExtensionChainsExtensionsName = '[NAME]';
    $lbTrafficExtensionExtensionChainsExtensionsService = '[SERVICE]';
    $lbTrafficExtensionLoadBalancingScheme = LoadBalancingScheme::LOAD_BALANCING_SCHEME_UNSPECIFIED;

    create_lb_traffic_extension_sample(
        $formattedParent,
        $lbTrafficExtensionId,
        $lbTrafficExtensionName,
        $lbTrafficExtensionForwardingRulesElement,
        $lbTrafficExtensionExtensionChainsName,
        $lbTrafficExtensionExtensionChainsMatchConditionCelExpression,
        $lbTrafficExtensionExtensionChainsExtensionsName,
        $lbTrafficExtensionExtensionChainsExtensionsService,
        $lbTrafficExtensionLoadBalancingScheme
    );
}
// [END networkservices_v1_generated_DepService_CreateLbTrafficExtension_sync]
