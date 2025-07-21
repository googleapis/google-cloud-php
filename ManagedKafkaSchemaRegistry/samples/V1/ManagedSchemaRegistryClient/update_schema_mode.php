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

// [START managedkafka_v1_generated_ManagedSchemaRegistry_UpdateSchemaMode_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\Client\ManagedSchemaRegistryClient;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\SchemaMode;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\SchemaMode\ModeType;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\UpdateSchemaModeRequest;

/**
 * Update mode at global level or for a subject.
 *
 * @param string $formattedName The resource name of the mode. The format is
 *                              * projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/mode/{subject}: mode for a schema registry, or
 *                              * projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/contexts/{context}/mode/{subject}: mode for a specific subject in a specific context
 *                              Please see {@see ManagedSchemaRegistryClient::schemaModeName()} for help formatting this field.
 * @param int    $mode          The mode type.
 */
function update_schema_mode_sample(string $formattedName, int $mode): void
{
    // Create a client.
    $managedSchemaRegistryClient = new ManagedSchemaRegistryClient();

    // Prepare the request message.
    $request = (new UpdateSchemaModeRequest())
        ->setName($formattedName)
        ->setMode($mode);

    // Call the API and handle any network failures.
    try {
        /** @var SchemaMode $response */
        $response = $managedSchemaRegistryClient->updateSchemaMode($request);
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
    $formattedName = ManagedSchemaRegistryClient::schemaModeName(
        '[PROJECT]',
        '[LOCATION]',
        '[SCHEMA_REGISTRY]'
    );
    $mode = ModeType::NONE;

    update_schema_mode_sample($formattedName, $mode);
}
// [END managedkafka_v1_generated_ManagedSchemaRegistry_UpdateSchemaMode_sync]
