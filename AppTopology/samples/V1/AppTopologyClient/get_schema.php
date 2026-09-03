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

// [START apptopology_v1_generated_AppTopology_GetSchema_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AppTopology\V1\Client\AppTopologyClient;
use Google\Cloud\AppTopology\V1\GetSchemaRequest;
use Google\Cloud\AppTopology\V1\Schema;

/**
 * Retrieves the schema for the specified topology domain. The schema
 * defines the NodeTypes and EdgeTypes that are supported in
 * GenerateDiscoveredResourcesTopology requests and responses for a given
 * domain.
 *
 * @param string $formattedName The name of the singleton domain schema resource.
 *                              Format: `projects/{project}/locations/{location}/domains/{domain}/schema`
 *                              Please see {@see AppTopologyClient::schemaName()} for help formatting this field.
 */
function get_schema_sample(string $formattedName): void
{
    // Create a client.
    $appTopologyClient = new AppTopologyClient();

    // Prepare the request message.
    $request = (new GetSchemaRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Schema $response */
        $response = $appTopologyClient->getSchema($request);
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
    $formattedName = AppTopologyClient::schemaName('[PROJECT]', '[LOCATION]', '[DOMAIN]');

    get_schema_sample($formattedName);
}
// [END apptopology_v1_generated_AppTopology_GetSchema_sync]
