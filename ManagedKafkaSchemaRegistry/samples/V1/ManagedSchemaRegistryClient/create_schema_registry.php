<?php
/*
 * Copyright 2026 Google LLC
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

// [START managedkafka_v1_generated_ManagedSchemaRegistry_CreateSchemaRegistry_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\Client\ManagedSchemaRegistryClient;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\CreateSchemaRegistryRequest;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\SchemaRegistry;

/**
 * Create a schema registry instance.
 *
 * @param string $parent           The parent whose schema registry instance is to be created.
 *                                 Structured like: `projects/{project}/locations/{location}`
 * @param string $schemaRegistryId The schema registry instance ID to use for this schema registry.
 *                                 The ID must contain only letters (a-z, A-Z), numbers (0-9), and underscores
 *                                 (-). The maximum length is 63 characters.
 *                                 The ID must not start with a number.
 */
function create_schema_registry_sample(string $parent, string $schemaRegistryId): void
{
    // Create a client.
    $managedSchemaRegistryClient = new ManagedSchemaRegistryClient();

    // Prepare the request message.
    $schemaRegistry = new SchemaRegistry();
    $request = (new CreateSchemaRegistryRequest())
        ->setParent($parent)
        ->setSchemaRegistryId($schemaRegistryId)
        ->setSchemaRegistry($schemaRegistry);

    // Call the API and handle any network failures.
    try {
        /** @var SchemaRegistry $response */
        $response = $managedSchemaRegistryClient->createSchemaRegistry($request);
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
    $parent = '[PARENT]';
    $schemaRegistryId = '[SCHEMA_REGISTRY_ID]';

    create_schema_registry_sample($parent, $schemaRegistryId);
}
// [END managedkafka_v1_generated_ManagedSchemaRegistry_CreateSchemaRegistry_sync]
