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

// [START ids_v1_generated_IDS_CreateEndpoint_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Ids\V1\Client\IDSClient;
use Google\Cloud\Ids\V1\CreateEndpointRequest;
use Google\Cloud\Ids\V1\Endpoint;
use Google\Cloud\Ids\V1\Endpoint\Severity;
use Google\Rpc\Status;

/**
 * Creates a new Endpoint in a given project and location.
 *
 * @param string $formattedParent  The endpoint's parent. Please see
 *                                 {@see IDSClient::locationName()} for help formatting this field.
 * @param string $endpointId       The endpoint identifier. This will be part of the endpoint's
 *                                 resource name.
 *                                 This value must start with a lowercase letter followed by up to 62
 *                                 lowercase letters, numbers, or hyphens, and cannot end with a hyphen.
 *                                 Values that do not match this pattern will trigger an INVALID_ARGUMENT
 *                                 error.
 * @param string $endpointNetwork  The fully qualified URL of the network to which the IDS Endpoint is
 *                                 attached.
 * @param int    $endpointSeverity Lowest threat severity that this endpoint will alert on.
 */
function create_endpoint_sample(
    string $formattedParent,
    string $endpointId,
    string $endpointNetwork,
    int $endpointSeverity
): void {
    // Create a client.
    $iDSClient = new IDSClient();

    // Prepare the request message.
    $endpoint = (new Endpoint())
        ->setNetwork($endpointNetwork)
        ->setSeverity($endpointSeverity);
    $request = (new CreateEndpointRequest())
        ->setParent($formattedParent)
        ->setEndpointId($endpointId)
        ->setEndpoint($endpoint);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $iDSClient->createEndpoint($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Endpoint $result */
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
    $formattedParent = IDSClient::locationName('[PROJECT]', '[LOCATION]');
    $endpointId = '[ENDPOINT_ID]';
    $endpointNetwork = '[NETWORK]';
    $endpointSeverity = Severity::SEVERITY_UNSPECIFIED;

    create_endpoint_sample($formattedParent, $endpointId, $endpointNetwork, $endpointSeverity);
}
// [END ids_v1_generated_IDS_CreateEndpoint_sync]
