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

// [START managedkafka_v1_generated_ManagedSchemaRegistry_GetSchemaRegistry_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\Client\ManagedSchemaRegistryClient;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\GetSchemaRegistryRequest;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\SchemaRegistry;

/**
 * Get the schema registry instance.
 *
 * @param string $formattedName The name of the schema registry instance to return. Structured
 *                              like:
 *                              `projects/{project}/locations/{location}/schemaRegistries/{schema_registry}`
 *                              Please see {@see ManagedSchemaRegistryClient::schemaRegistryName()} for help formatting this field.
 */
function get_schema_registry_sample(string $formattedName): void
{
    // Create a client.
    $managedSchemaRegistryClient = new ManagedSchemaRegistryClient();

    // Prepare the request message.
    $request = (new GetSchemaRegistryRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SchemaRegistry $response */
        $response = $managedSchemaRegistryClient->getSchemaRegistry($request);
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
    $formattedName = ManagedSchemaRegistryClient::schemaRegistryName(
        '[PROJECT]',
        '[LOCATION]',
        '[SCHEMA_REGISTRY]'
    );

    get_schema_registry_sample($formattedName);
}
// [END managedkafka_v1_generated_ManagedSchemaRegistry_GetSchemaRegistry_sync]
