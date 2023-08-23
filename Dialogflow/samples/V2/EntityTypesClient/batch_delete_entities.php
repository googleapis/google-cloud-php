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

// [START dialogflow_v2_generated_EntityTypes_BatchDeleteEntities_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\EntityTypesClient;
use Google\Rpc\Status;

/**
 * Deletes entities in the specified entity type.
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
 * @param string $formattedParent     The name of the entity type to delete entries for. Format:
 *                                    `projects/<Project ID>/agent/entityTypes/<Entity Type ID>`. Please see
 *                                    {@see EntityTypesClient::entityTypeName()} for help formatting this field.
 * @param string $entityValuesElement The reference `values` of the entities to delete. Note that
 *                                    these are not fully-qualified names, i.e. they don't start with
 *                                    `projects/<Project ID>`.
 */
function batch_delete_entities_sample(string $formattedParent, string $entityValuesElement): void
{
    // Create a client.
    $entityTypesClient = new EntityTypesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $entityValues = [$entityValuesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $entityTypesClient->batchDeleteEntities($formattedParent, $entityValues);
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
    $formattedParent = EntityTypesClient::entityTypeName('[PROJECT]', '[ENTITY_TYPE]');
    $entityValuesElement = '[ENTITY_VALUES]';

    batch_delete_entities_sample($formattedParent, $entityValuesElement);
}
// [END dialogflow_v2_generated_EntityTypes_BatchDeleteEntities_sync]
