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

// [START datamigration_v1_generated_DataMigrationService_GetMappingRule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudDms\V1\DataMigrationServiceClient;
use Google\Cloud\CloudDms\V1\MappingRule;

/**
 * Gets the details of a mapping rule.
 *
 * @param string $formattedName Name of the mapping rule resource to get.
 *                              Example: conversionWorkspaces/123/mappingRules/rule123
 *
 *                              In order to retrieve a previous revision of the mapping rule, also provide
 *                              the revision ID.
 *                              Example:
 *                              conversionWorkspace/123/mappingRules/rule123&#64;c7cfa2a8c7cfa2a8c7cfa2a8c7cfa2a8
 *                              Please see {@see DataMigrationServiceClient::mappingRuleName()} for help formatting this field.
 */
function get_mapping_rule_sample(string $formattedName): void
{
    // Create a client.
    $dataMigrationServiceClient = new DataMigrationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var MappingRule $response */
        $response = $dataMigrationServiceClient->getMappingRule($formattedName);
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
    $formattedName = DataMigrationServiceClient::mappingRuleName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONVERSION_WORKSPACE]',
        '[MAPPING_RULE]'
    );

    get_mapping_rule_sample($formattedName);
}
// [END datamigration_v1_generated_DataMigrationService_GetMappingRule_sync]
