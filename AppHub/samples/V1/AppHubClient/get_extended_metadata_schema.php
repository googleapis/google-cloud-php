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

// [START apphub_v1_generated_AppHub_GetExtendedMetadataSchema_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AppHub\V1\Client\AppHubClient;
use Google\Cloud\AppHub\V1\ExtendedMetadataSchema;
use Google\Cloud\AppHub\V1\GetExtendedMetadataSchemaRequest;

/**
 * Gets an Extended Metadata Schema.
 *
 * @param string $formattedName Schema resource name.
 *                              Format:
 *                              `projects/{project}/locations/{location}/extendedMetadataSchemas/{extended_metadata_schema}`.
 *
 *                              `{extended_metadata_schema}` has the format
 *                              `"apphub.googleapis.com/{SchemaName}"`. Please see
 *                              {@see AppHubClient::extendedMetadataSchemaName()} for help formatting this field.
 */
function get_extended_metadata_schema_sample(string $formattedName): void
{
    // Create a client.
    $appHubClient = new AppHubClient();

    // Prepare the request message.
    $request = (new GetExtendedMetadataSchemaRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ExtendedMetadataSchema $response */
        $response = $appHubClient->getExtendedMetadataSchema($request);
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
    $formattedName = AppHubClient::extendedMetadataSchemaName(
        '[PROJECT]',
        '[LOCATION]',
        '[EXTENDED_METADATA_SCHEMA]'
    );

    get_extended_metadata_schema_sample($formattedName);
}
// [END apphub_v1_generated_AppHub_GetExtendedMetadataSchema_sync]
