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

// [START datamigration_v1_generated_DataMigrationService_DescribeConversionWorkspaceRevisions_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudDms\V1\DataMigrationServiceClient;
use Google\Cloud\CloudDms\V1\DescribeConversionWorkspaceRevisionsResponse;

/**
 * Retrieves a list of committed revisions of a specific conversion
 * workspace.
 *
 * @param string $formattedConversionWorkspace Name of the conversion workspace resource whose revisions are
 *                                             listed. Must be in the form of:
 *                                             projects/{project}/locations/{location}/conversionWorkspaces/{conversion_workspace}. Please see
 *                                             {@see DataMigrationServiceClient::conversionWorkspaceName()} for help formatting this field.
 */
function describe_conversion_workspace_revisions_sample(
    string $formattedConversionWorkspace
): void {
    // Create a client.
    $dataMigrationServiceClient = new DataMigrationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var DescribeConversionWorkspaceRevisionsResponse $response */
        $response = $dataMigrationServiceClient->describeConversionWorkspaceRevisions(
            $formattedConversionWorkspace
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
    $formattedConversionWorkspace = DataMigrationServiceClient::conversionWorkspaceName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONVERSION_WORKSPACE]'
    );

    describe_conversion_workspace_revisions_sample($formattedConversionWorkspace);
}
// [END datamigration_v1_generated_DataMigrationService_DescribeConversionWorkspaceRevisions_sync]
