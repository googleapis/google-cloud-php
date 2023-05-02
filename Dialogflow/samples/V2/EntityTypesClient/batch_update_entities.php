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

// [START dialogflow_v2_generated_EntityTypes_BatchUpdateEntities_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\EntityType\Entity;
use Google\Cloud\Dialogflow\V2\EntityTypesClient;
use Google\Rpc\Status;

/**
 * Updates or creates multiple entities in the specified entity type. This
 * method does not affect entities in the entity type that aren't explicitly
 * specified in the request.
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
 *
 * @param string $formattedParent         The name of the entity type to update or create entities in.
 *                                        Format: `projects/<Project ID>/agent/entityTypes/<Entity Type ID>`. Please see
 *                                        {@see EntityTypesClient::entityTypeName()} for help formatting this field.
 * @param string $entitiesValue           The primary value associated with this entity entry.
 *                                        For example, if the entity type is *vegetable*, the value could be
 *                                        *scallions*.
 *
 *                                        For `KIND_MAP` entity types:
 *
 *                                        *   A reference value to be used in place of synonyms.
 *
 *                                        For `KIND_LIST` entity types:
 *
 *                                        *   A string that can contain references to other entity types (with or
 *                                        without aliases).
 * @param string $entitiesSynonymsElement A collection of value synonyms. For example, if the entity type
 *                                        is *vegetable*, and `value` is *scallions*, a synonym could be *green
 *                                        onions*.
 *
 *                                        For `KIND_LIST` entity types:
 *
 *                                        *   This collection must contain exactly one synonym equal to `value`.
 */
function batch_update_entities_sample(
    string $formattedParent,
    string $entitiesValue,
    string $entitiesSynonymsElement
): void {
    // Create a client.
    $entityTypesClient = new EntityTypesClient();

    // Prepare the request message.
    $entitiesSynonyms = [$entitiesSynonymsElement,];
    $entity = (new Entity())
        ->setValue($entitiesValue)
        ->setSynonyms($entitiesSynonyms);
    $entities = [$entity,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $entityTypesClient->batchUpdateEntities($formattedParent, $entities);
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
    $entitiesValue = '[VALUE]';
    $entitiesSynonymsElement = '[SYNONYMS]';

    batch_update_entities_sample($formattedParent, $entitiesValue, $entitiesSynonymsElement);
}
// [END dialogflow_v2_generated_EntityTypes_BatchUpdateEntities_sync]
