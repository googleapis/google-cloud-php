<?php
/*
 * Copyright 2023 Google LLC
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

// [START discoveryengine_v1_generated_SchemaService_CreateSchema_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\SchemaServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CreateSchemaRequest;
use Google\Cloud\DiscoveryEngine\V1\Schema;
use Google\Rpc\Status;

/**
 * Creates a [Schema][google.cloud.discoveryengine.v1.Schema].
 *
 * @param string $formattedParent The parent data store resource name, in the format of
 *                                `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}`. Please see
 *                                {@see SchemaServiceClient::dataStoreName()} for help formatting this field.
 * @param string $schemaId        The ID to use for the
 *                                [Schema][google.cloud.discoveryengine.v1.Schema], which will become the
 *                                final component of the
 *                                [Schema.name][google.cloud.discoveryengine.v1.Schema.name].
 *
 *                                This field should conform to
 *                                [RFC-1034](https://tools.ietf.org/html/rfc1034) standard with a length
 *                                limit of 63 characters.
 */
function create_schema_sample(string $formattedParent, string $schemaId): void
{
    // Create a client.
    $schemaServiceClient = new SchemaServiceClient();

    // Prepare the request message.
    $schema = new Schema();
    $request = (new CreateSchemaRequest())
        ->setParent($formattedParent)
        ->setSchema($schema)
        ->setSchemaId($schemaId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $schemaServiceClient->createSchema($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Schema $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
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
    $formattedParent = SchemaServiceClient::dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
    $schemaId = '[SCHEMA_ID]';

    create_schema_sample($formattedParent, $schemaId);
}
// [END discoveryengine_v1_generated_SchemaService_CreateSchema_sync]
