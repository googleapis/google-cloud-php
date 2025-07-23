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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_DeleteSchemaBundle_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\DeleteSchemaBundleRequest;

/**
 * Deletes a schema bundle in the specified table.
 *
 * @param string $formattedName The unique name of the schema bundle to delete.
 *                              Values are of the form
 *                              `projects/{project}/instances/{instance}/tables/{table}/schemaBundles/{schema_bundle}`
 *                              Please see {@see BigtableTableAdminClient::schemaBundleName()} for help formatting this field.
 */
function delete_schema_bundle_sample(string $formattedName): void
{
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare the request message.
    $request = (new DeleteSchemaBundleRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $bigtableTableAdminClient->deleteSchemaBundle($request);
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
    $formattedName = BigtableTableAdminClient::schemaBundleName(
        '[PROJECT]',
        '[INSTANCE]',
        '[TABLE]',
        '[SCHEMA_BUNDLE]'
    );

    delete_schema_bundle_sample($formattedName);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_DeleteSchemaBundle_sync]
