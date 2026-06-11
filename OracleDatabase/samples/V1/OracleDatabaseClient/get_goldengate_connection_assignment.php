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

// [START oracledatabase_v1_generated_OracleDatabase_GetGoldengateConnectionAssignment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\GetGoldengateConnectionAssignmentRequest;
use Google\Cloud\OracleDatabase\V1\GoldengateConnectionAssignment;

/**
 * Gets details of a single GoldengateConnectionAssignment.
 *
 * @param string $formattedName The name of the GoldengateConnectionAssignment to retrieve.
 *                              Format:
 *                              projects/{project}/locations/{location}/goldengateConnectionAssignments/{goldengate_connection_assignment}
 *                              Please see {@see OracleDatabaseClient::goldengateConnectionAssignmentName()} for help formatting this field.
 */
function get_goldengate_connection_assignment_sample(string $formattedName): void
{
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $request = (new GetGoldengateConnectionAssignmentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var GoldengateConnectionAssignment $response */
        $response = $oracleDatabaseClient->getGoldengateConnectionAssignment($request);
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
    $formattedName = OracleDatabaseClient::goldengateConnectionAssignmentName(
        '[PROJECT]',
        '[LOCATION]',
        '[GOLDENGATE_CONNECTION_ASSIGNMENT]'
    );

    get_goldengate_connection_assignment_sample($formattedName);
}
// [END oracledatabase_v1_generated_OracleDatabase_GetGoldengateConnectionAssignment_sync]
