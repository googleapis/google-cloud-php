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

// [START backupdr_v1_generated_BackupDR_FetchDataSourceReferencesForResourceType_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\DataSourceReference;
use Google\Cloud\BackupDR\V1\FetchDataSourceReferencesForResourceTypeRequest;

/**
 * Fetch DataSourceReferences for a given project, location and resource type.
 *
 * @param string $formattedParent The parent resource name.
 *                                Format: projects/{project}/locations/{location}
 *                                Please see {@see BackupDRClient::locationName()} for help formatting this field.
 * @param string $resourceType    The type of the GCP resource.
 *                                Ex: sql.googleapis.com/Instance
 */
function fetch_data_source_references_for_resource_type_sample(
    string $formattedParent,
    string $resourceType
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $request = (new FetchDataSourceReferencesForResourceTypeRequest())
        ->setParent($formattedParent)
        ->setResourceType($resourceType);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $backupDRClient->fetchDataSourceReferencesForResourceType($request);

        /** @var DataSourceReference $element */
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
    $formattedParent = BackupDRClient::locationName('[PROJECT]', '[LOCATION]');
    $resourceType = '[RESOURCE_TYPE]';

    fetch_data_source_references_for_resource_type_sample($formattedParent, $resourceType);
}
// [END backupdr_v1_generated_BackupDR_FetchDataSourceReferencesForResourceType_sync]
