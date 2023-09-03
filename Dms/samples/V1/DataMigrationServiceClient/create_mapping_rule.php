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

// [START datamigration_v1_generated_DataMigrationService_CreateMappingRule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudDms\V1\DataMigrationServiceClient;
use Google\Cloud\CloudDms\V1\DatabaseEntityType;
use Google\Cloud\CloudDms\V1\MappingRule;
use Google\Cloud\CloudDms\V1\MappingRuleFilter;

/**
 * Creates a new mapping rule for a given conversion workspace.
 *
 * @param string $formattedParent      The parent which owns this collection of mapping rules. Please see
 *                                     {@see DataMigrationServiceClient::conversionWorkspaceName()} for help formatting this field.
 * @param string $mappingRuleId        The ID of the rule to create.
 * @param int    $mappingRuleRuleScope The rule scope
 * @param int    $mappingRuleRuleOrder The order in which the rule is applied. Lower order rules are
 *                                     applied before higher value rules so they may end up being overridden.
 */
function create_mapping_rule_sample(
    string $formattedParent,
    string $mappingRuleId,
    int $mappingRuleRuleScope,
    int $mappingRuleRuleOrder
): void {
    // Create a client.
    $dataMigrationServiceClient = new DataMigrationServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $mappingRuleFilter = new MappingRuleFilter();
    $mappingRule = (new MappingRule())
        ->setRuleScope($mappingRuleRuleScope)
        ->setFilter($mappingRuleFilter)
        ->setRuleOrder($mappingRuleRuleOrder);

    // Call the API and handle any network failures.
    try {
        /** @var MappingRule $response */
        $response = $dataMigrationServiceClient->createMappingRule(
            $formattedParent,
            $mappingRuleId,
            $mappingRule
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
    $formattedParent = DataMigrationServiceClient::conversionWorkspaceName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONVERSION_WORKSPACE]'
    );
    $mappingRuleId = '[MAPPING_RULE_ID]';
    $mappingRuleRuleScope = DatabaseEntityType::DATABASE_ENTITY_TYPE_UNSPECIFIED;
    $mappingRuleRuleOrder = 0;

    create_mapping_rule_sample(
        $formattedParent,
        $mappingRuleId,
        $mappingRuleRuleScope,
        $mappingRuleRuleOrder
    );
}
// [END datamigration_v1_generated_DataMigrationService_CreateMappingRule_sync]
