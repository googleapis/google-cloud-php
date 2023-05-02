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

// [START securitycenter_v1_generated_SecurityCenter_CreateBigQueryExport_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\BigQueryExport;
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;

/**
 * Creates a BigQuery export.
 *
 * @param string $formattedParent  The name of the parent resource of the new BigQuery export. Its
 *                                 format is "organizations/[organization_id]", "folders/[folder_id]", or
 *                                 "projects/[project_id]". Please see
 *                                 {@see SecurityCenterClient::projectName()} for help formatting this field.
 * @param string $bigQueryExportId Unique identifier provided by the client within the parent scope.
 *                                 It must consist of lower case letters, numbers, and hyphen, with the first
 *                                 character a letter, the last a letter or a number, and a 63 character
 *                                 maximum.
 */
function create_big_query_export_sample(string $formattedParent, string $bigQueryExportId): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $bigQueryExport = new BigQueryExport();

    // Call the API and handle any network failures.
    try {
        /** @var BigQueryExport $response */
        $response = $securityCenterClient->createBigQueryExport(
            $formattedParent,
            $bigQueryExport,
            $bigQueryExportId
        );
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
    $formattedParent = SecurityCenterClient::projectName('[PROJECT]');
    $bigQueryExportId = '[BIG_QUERY_EXPORT_ID]';

    create_big_query_export_sample($formattedParent, $bigQueryExportId);
}
// [END securitycenter_v1_generated_SecurityCenter_CreateBigQueryExport_sync]
