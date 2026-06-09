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

// [START oracledatabase_v1_generated_OracleDatabase_GetGoldengateDeploymentType_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\GetGoldengateDeploymentTypeRequest;
use Google\Cloud\OracleDatabase\V1\GoldengateDeploymentType;

/**
 * Gets details of a single GoldenGateDeploymentType.
 *
 * @param string $formattedName The name of the GoldengateDeploymentType to retrieve.
 *                              Format:
 *                              projects/{project}/locations/{location}/goldengateDeploymentTypes/{goldengate_deployment_type}
 *                              Please see {@see OracleDatabaseClient::goldengateDeploymentTypeName()} for help formatting this field.
 */
function get_goldengate_deployment_type_sample(string $formattedName): void
{
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $request = (new GetGoldengateDeploymentTypeRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var GoldengateDeploymentType $response */
        $response = $oracleDatabaseClient->getGoldengateDeploymentType($request);
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
    $formattedName = OracleDatabaseClient::goldengateDeploymentTypeName(
        '[PROJECT]',
        '[LOCATION]',
        '[GOLDENGATE_DEPLOYMENT_TYPE]'
    );

    get_goldengate_deployment_type_sample($formattedName);
}
// [END oracledatabase_v1_generated_OracleDatabase_GetGoldengateDeploymentType_sync]
