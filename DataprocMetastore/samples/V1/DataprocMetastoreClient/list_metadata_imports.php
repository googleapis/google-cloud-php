<?php
/*
 * Copyright 2022 Google LLC
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

// [START metastore_v1_generated_DataprocMetastore_ListMetadataImports_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Metastore\V1\Client\DataprocMetastoreClient;
use Google\Cloud\Metastore\V1\ListMetadataImportsRequest;
use Google\Cloud\Metastore\V1\MetadataImport;

/**
 * Lists imports in a service.
 *
 * @param string $formattedParent The relative resource name of the service whose metadata imports
 *                                to list, in the following form:
 *
 *                                `projects/{project_number}/locations/{location_id}/services/{service_id}/metadataImports`. Please see
 *                                {@see DataprocMetastoreClient::serviceName()} for help formatting this field.
 */
function list_metadata_imports_sample(string $formattedParent): void
{
    // Create a client.
    $dataprocMetastoreClient = new DataprocMetastoreClient();

    // Prepare the request message.
    $request = (new ListMetadataImportsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $dataprocMetastoreClient->listMetadataImports($request);

        /** @var MetadataImport $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = DataprocMetastoreClient::serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');

    list_metadata_imports_sample($formattedParent);
}
// [END metastore_v1_generated_DataprocMetastore_ListMetadataImports_sync]
