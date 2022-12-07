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

// [START compute_v1_generated_TargetTcpProxies_SetProxyHeader_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\TargetTcpProxiesClient;
use Google\Cloud\Compute\V1\TargetTcpProxiesSetProxyHeaderRequest;
use Google\Rpc\Status;

/**
 * Changes the ProxyHeaderType for TargetTcpProxy.
 *
 * @param string $project        Project ID for this request.
 * @param string $targetTcpProxy Name of the TargetTcpProxy resource whose ProxyHeader is to be set.
 */
function set_proxy_header_sample(string $project, string $targetTcpProxy): void
{
    // Create a client.
    $targetTcpProxiesClient = new TargetTcpProxiesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $targetTcpProxiesSetProxyHeaderRequestResource = new TargetTcpProxiesSetProxyHeaderRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $targetTcpProxiesClient->setProxyHeader(
            $project,
            $targetTcpProxiesSetProxyHeaderRequestResource,
            $targetTcpProxy
        );
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
    $project = '[PROJECT]';
    $targetTcpProxy = '[TARGET_TCP_PROXY]';

    set_proxy_header_sample($project, $targetTcpProxy);
}
// [END compute_v1_generated_TargetTcpProxies_SetProxyHeader_sync]
