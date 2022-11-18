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

// [START securitycenter_v1_generated_SecurityCenter_ListBigQueryExports_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\SecurityCenter\V1\BigQueryExport;
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;

/**
 * Lists BigQuery exports. Note that when requesting BigQuery exports at a
 * given level all exports under that level are also returned e.g. if
 * requesting BigQuery exports under a folder, then all BigQuery exports
 * immediately under the folder plus the ones created under the projects
 * within the folder are returned.
 *
 * @param string $formattedParent The parent, which owns the collection of BigQuery exports. Its
 *                                format is "organizations/[organization_id]", "folders/[folder_id]",
 *                                "projects/[project_id]". Please see
 *                                {@see SecurityCenterClient::projectName()} for help formatting this field.
 */
function list_big_query_exports_sample(string $formattedParent): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $securityCenterClient->listBigQueryExports($formattedParent);

        /** @var BigQueryExport $element */
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
    $formattedParent = SecurityCenterClient::projectName('[PROJECT]');

    list_big_query_exports_sample($formattedParent);
}
// [END securitycenter_v1_generated_SecurityCenter_ListBigQueryExports_sync]
