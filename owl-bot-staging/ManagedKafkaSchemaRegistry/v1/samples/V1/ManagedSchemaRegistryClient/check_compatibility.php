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

// [START managedkafka_v1_generated_ManagedSchemaRegistry_CheckCompatibility_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\CheckCompatibilityRequest;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\CheckCompatibilityResponse;
use Google\Cloud\ManagedKafka\SchemaRegistry\V1\Client\ManagedSchemaRegistryClient;

/**
 * Check compatibility of a schema with all versions or a specific version of
 * a subject.
 *
 * @param string $name   The name of the resource to check compatibility for. The format
 *                       is either of following:
 *                       * projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/compatibility/subjects/&#42;/versions: Check compatibility with one or
 *                       more versions of the specified subject.
 *                       * projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/compatibility/subjects/{subject}/versions/{version}: Check
 *                       compatibility with a specific version of the subject.
 * @param string $schema The schema payload
 */
function check_compatibility_sample(string $name, string $schema): void
{
    // Create a client.
    $managedSchemaRegistryClient = new ManagedSchemaRegistryClient();

    // Prepare the request message.
    $request = (new CheckCompatibilityRequest())
        ->setName($name)
        ->setSchema($schema);

    // Call the API and handle any network failures.
    try {
        /** @var CheckCompatibilityResponse $response */
        $response = $managedSchemaRegistryClient->checkCompatibility($request);
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
    $name = '[NAME]';
    $schema = '[SCHEMA]';

    check_compatibility_sample($name, $schema);
}
// [END managedkafka_v1_generated_ManagedSchemaRegistry_CheckCompatibility_sync]
