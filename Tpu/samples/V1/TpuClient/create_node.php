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

// [START tpu_v1_generated_Tpu_CreateNode_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Tpu\V1\Node;
use Google\Cloud\Tpu\V1\TpuClient;
use Google\Rpc\Status;

/**
 * Creates a node.
 *
 * @param string $formattedParent       The parent resource name. Please see
 *                                      {@see TpuClient::locationName()} for help formatting this field.
 * @param string $nodeAcceleratorType   The type of hardware accelerators associated with this node.
 * @param string $nodeTensorflowVersion The version of Tensorflow running in the Node.
 */
function create_node_sample(
    string $formattedParent,
    string $nodeAcceleratorType,
    string $nodeTensorflowVersion
): void {
    // Create a client.
    $tpuClient = new TpuClient();

    // Prepare the request message.
    $node = (new Node())
        ->setAcceleratorType($nodeAcceleratorType)
        ->setTensorflowVersion($nodeTensorflowVersion);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $tpuClient->createNode($formattedParent, $node);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Node $result */
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
    $formattedParent = TpuClient::locationName('[PROJECT]', '[LOCATION]');
    $nodeAcceleratorType = '[ACCELERATOR_TYPE]';
    $nodeTensorflowVersion = '[TENSORFLOW_VERSION]';

    create_node_sample($formattedParent, $nodeAcceleratorType, $nodeTensorflowVersion);
}
// [END tpu_v1_generated_Tpu_CreateNode_sync]
