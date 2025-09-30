<?php
/*
 * Copyright 2025 Google LLC
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

// [START networkconnectivity_v1_generated_DataTransferService_CreateDestination_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkConnectivity\V1\Client\DataTransferServiceClient;
use Google\Cloud\NetworkConnectivity\V1\CreateDestinationRequest;
use Google\Cloud\NetworkConnectivity\V1\Destination;
use Google\Cloud\NetworkConnectivity\V1\Destination\DestinationEndpoint;
use Google\Rpc\Status;

/**
 * Creates a `Destination` resource in a specified project and location.
 *
 * @param string $formattedParent         The name of the parent resource. Please see
 *                                        {@see DataTransferServiceClient::multicloudDataTransferConfigName()} for help formatting this field.
 * @param string $destinationId           The ID to use for the `Destination` resource, which becomes the
 *                                        final component of the `Destination` resource name.
 * @param string $destinationIpPrefix     Immutable. The IP prefix that represents your workload on another
 *                                        CSP.
 * @param int    $destinationEndpointsAsn The ASN of the remote IP prefix.
 * @param string $destinationEndpointsCsp The CSP of the remote IP prefix.
 */
function create_destination_sample(
    string $formattedParent,
    string $destinationId,
    string $destinationIpPrefix,
    int $destinationEndpointsAsn,
    string $destinationEndpointsCsp
): void {
    // Create a client.
    $dataTransferServiceClient = new DataTransferServiceClient();

    // Prepare the request message.
    $destinationEndpoint = (new DestinationEndpoint())
        ->setAsn($destinationEndpointsAsn)
        ->setCsp($destinationEndpointsCsp);
    $destinationEndpoints = [$destinationEndpoint,];
    $destination = (new Destination())
        ->setIpPrefix($destinationIpPrefix)
        ->setEndpoints($destinationEndpoints);
    $request = (new CreateDestinationRequest())
        ->setParent($formattedParent)
        ->setDestinationId($destinationId)
        ->setDestination($destination);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataTransferServiceClient->createDestination($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Destination $result */
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
    $formattedParent = DataTransferServiceClient::multicloudDataTransferConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[MULTICLOUD_DATA_TRANSFER_CONFIG]'
    );
    $destinationId = '[DESTINATION_ID]';
    $destinationIpPrefix = '[IP_PREFIX]';
    $destinationEndpointsAsn = 0;
    $destinationEndpointsCsp = '[CSP]';

    create_destination_sample(
        $formattedParent,
        $destinationId,
        $destinationIpPrefix,
        $destinationEndpointsAsn,
        $destinationEndpointsCsp
    );
}
// [END networkconnectivity_v1_generated_DataTransferService_CreateDestination_sync]
