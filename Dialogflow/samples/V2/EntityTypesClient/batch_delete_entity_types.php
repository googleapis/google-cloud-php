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

// [START dialogflow_v2_generated_EntityTypes_BatchDeleteEntityTypes_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\BatchDeleteEntityTypesRequest;
use Google\Cloud\Dialogflow\V2\Client\EntityTypesClient;
use Google\Rpc\Status;

/**
 * Deletes entity types in the specified agent.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`: An empty [Struct
 * message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#struct)
 * - `response`: An [Empty
 * message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#empty)
 *
 * Note: You should always train an agent prior to sending it queries. See the
 * [training
 * documentation](https://cloud.google.com/dialogflow/es/docs/training).
 *
 * @param string $formattedParent        The name of the agent to delete all entities types for. Format:
 *                                       `projects/<Project ID>/agent`. Please see
 *                                       {@see EntityTypesClient::agentName()} for help formatting this field.
 * @param string $entityTypeNamesElement The names entity types to delete. All names must point to the
 *                                       same agent as `parent`.
 */
function batch_delete_entity_types_sample(
    string $formattedParent,
    string $entityTypeNamesElement
): void {
    // Create a client.
    $entityTypesClient = new EntityTypesClient();

    // Prepare the request message.
    $entityTypeNames = [$entityTypeNamesElement,];
    $request = (new BatchDeleteEntityTypesRequest())
        ->setParent($formattedParent)
        ->setEntityTypeNames($entityTypeNames);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $entityTypesClient->batchDeleteEntityTypes($request);
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
    $formattedParent = EntityTypesClient::agentName('[PROJECT]');
    $entityTypeNamesElement = '[ENTITY_TYPE_NAMES]';

    batch_delete_entity_types_sample($formattedParent, $entityTypeNamesElement);
}
// [END dialogflow_v2_generated_EntityTypes_BatchDeleteEntityTypes_sync]
