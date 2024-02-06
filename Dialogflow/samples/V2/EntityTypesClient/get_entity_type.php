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

// [START dialogflow_v2_generated_EntityTypes_GetEntityType_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Client\EntityTypesClient;
use Google\Cloud\Dialogflow\V2\EntityType;
use Google\Cloud\Dialogflow\V2\GetEntityTypeRequest;

/**
 * Retrieves the specified entity type.
 *
 * @param string $formattedName The name of the entity type.
 *                              Format: `projects/<Project ID>/agent/entityTypes/<EntityType ID>`. Please see
 *                              {@see EntityTypesClient::entityTypeName()} for help formatting this field.
 */
function get_entity_type_sample(string $formattedName): void
{
    // Create a client.
    $entityTypesClient = new EntityTypesClient();

    // Prepare the request message.
    $request = (new GetEntityTypeRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var EntityType $response */
        $response = $entityTypesClient->getEntityType($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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

    get_entity_type_sample($formattedName);
}
// [END dialogflow_v2_generated_EntityTypes_GetEntityType_sync]
