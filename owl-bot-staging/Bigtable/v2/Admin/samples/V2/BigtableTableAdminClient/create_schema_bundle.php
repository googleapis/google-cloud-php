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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_CreateSchemaBundle_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\CreateSchemaBundleRequest;
use Google\Cloud\Bigtable\Admin\V2\SchemaBundle;
use Google\Rpc\Status;

/**
 * Creates a new schema bundle in the specified table.
 *
 * @param string $formattedParent The parent resource where this schema bundle will be created.
 *                                Values are of the form
 *                                `projects/{project}/instances/{instance}/tables/{table}`. Please see
 *                                {@see BigtableTableAdminClient::tableName()} for help formatting this field.
 * @param string $schemaBundleId  The unique ID to use for the schema bundle, which will become the
 *                                final component of the schema bundle's resource name.
 */
function create_schema_bundle_sample(string $formattedParent, string $schemaBundleId): void
{
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare the request message.
    $schemaBundle = new SchemaBundle();
    $request = (new CreateSchemaBundleRequest())
        ->setParent($formattedParent)
        ->setSchemaBundleId($schemaBundleId)
        ->setSchemaBundle($schemaBundle);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableTableAdminClient->createSchemaBundle($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SchemaBundle $result */
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
    $formattedParent = BigtableTableAdminClient::tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
    $schemaBundleId = '[SCHEMA_BUNDLE_ID]';

    create_schema_bundle_sample($formattedParent, $schemaBundleId);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_CreateSchemaBundle_sync]
