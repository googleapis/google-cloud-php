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

// [START datamigration_v1_generated_DataMigrationService_DescribeDatabaseEntities_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\CloudDms\V1\DataMigrationServiceClient;
use Google\Cloud\CloudDms\V1\DatabaseEntity;

/**
 * Describes the database entities tree for a specific conversion workspace
 * and a specific tree type.
 *
 * Database entities are not resources like conversion workspaces or mapping
 * rules, and they can't be created, updated or deleted. Instead, they are
 * simple data objects describing the structure of the client database.
 *
 * @param string $formattedConversionWorkspace Name of the conversion workspace resource whose database entities
 *                                             are described. Must be in the form of:
 *                                             projects/{project}/locations/{location}/conversionWorkspaces/{conversion_workspace}. Please see
 *                                             {@see DataMigrationServiceClient::conversionWorkspaceName()} for help formatting this field.
 */
function describe_database_entities_sample(string $formattedConversionWorkspace): void
{
    // Create a client.
    $dataMigrationServiceClient = new DataMigrationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $dataMigrationServiceClient->describeDatabaseEntities($formattedConversionWorkspace);

        /** @var DatabaseEntity $element */
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
    $formattedConversionWorkspace = DataMigrationServiceClient::conversionWorkspaceName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONVERSION_WORKSPACE]'
    );

    describe_database_entities_sample($formattedConversionWorkspace);
}
// [END datamigration_v1_generated_DataMigrationService_DescribeDatabaseEntities_sync]
