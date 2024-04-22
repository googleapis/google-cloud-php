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

// [START dialogflow_v2_generated_EntityTypes_DeleteEntityType_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Client\EntityTypesClient;
use Google\Cloud\Dialogflow\V2\DeleteEntityTypeRequest;

/**
 * Deletes the specified entity type.
 *
 * Note: You should always train an agent prior to sending it queries. See the
 * [training
 * documentation](https://cloud.google.com/dialogflow/es/docs/training).
 *
 * @param string $formattedName The name of the entity type to delete.
 *                              Format: `projects/<Project ID>/agent/entityTypes/<EntityType ID>`. Please see
 *                              {@see EntityTypesClient::entityTypeName()} for help formatting this field.
 */
function delete_entity_type_sample(string $formattedName): void
{
    // Create a client.
    $entityTypesClient = new EntityTypesClient();

    // Prepare the request message.
    $request = (new DeleteEntityTypeRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $entityTypesClient->deleteEntityType($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = EntityTypesClient::entityTypeName('[PROJECT]', '[ENTITY_TYPE]');

    delete_entity_type_sample($formattedName);
}
// [END dialogflow_v2_generated_EntityTypes_DeleteEntityType_sync]
