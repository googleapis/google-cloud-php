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

// [START managedkafka_v1_generated_ManagedSchemaRegistry_CreateVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\Client\ManagedSchemaRegistryClient;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\CreateVersionRequest;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\CreateVersionResponse;

/**
 * Register a new version under a given subject with the given schema.
 *
 * @param string $formattedParent The subject to create the version for. Structured like:
 *                                `projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/subjects/{subject}`
 *                                or
 *                                `projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/contexts/{context}/subjects/{subject}`
 *                                Please see {@see ManagedSchemaRegistryClient::schemaSubjectName()} for help formatting this field.
 * @param string $schema          The schema payload
 */
function create_version_sample(string $formattedParent, string $schema): void
{
    // Create a client.
    $managedSchemaRegistryClient = new ManagedSchemaRegistryClient();

    // Prepare the request message.
    $request = (new CreateVersionRequest())
        ->setParent($formattedParent)
        ->setSchema($schema);

    // Call the API and handle any network failures.
    try {
        /** @var CreateVersionResponse $response */
        $response = $managedSchemaRegistryClient->createVersion($request);
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
    $formattedParent = ManagedSchemaRegistryClient::schemaSubjectName(
        '[PROJECT]',
        '[LOCATION]',
        '[SCHEMA_REGISTRY]',
        '[SUBJECT]'
    );
    $schema = '[SCHEMA]';

    create_version_sample($formattedParent, $schema);
}
// [END managedkafka_v1_generated_ManagedSchemaRegistry_CreateVersion_sync]
