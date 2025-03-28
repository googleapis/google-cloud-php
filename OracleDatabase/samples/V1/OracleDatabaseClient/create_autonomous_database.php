<?php
/*
 * Copyright 2024 Google LLC
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

// [START oracledatabase_v1_generated_OracleDatabase_CreateAutonomousDatabase_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\AutonomousDatabase;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\CreateAutonomousDatabaseRequest;
use Google\Rpc\Status;

/**
 * Creates a new Autonomous Database in a given project and location.
 *
 * @param string $formattedParent      The name of the parent in the following format:
 *                                     projects/{project}/locations/{location}. Please see
 *                                     {@see OracleDatabaseClient::locationName()} for help formatting this field.
 * @param string $autonomousDatabaseId The ID of the Autonomous Database to create. This value is
 *                                     restricted to (^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$) and must be a maximum of
 *                                     63 characters in length. The value must start with a letter and end with a
 *                                     letter or a number.
 */
function create_autonomous_database_sample(
    string $formattedParent,
    string $autonomousDatabaseId
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $autonomousDatabase = new AutonomousDatabase();
    $request = (new CreateAutonomousDatabaseRequest())
        ->setParent($formattedParent)
        ->setAutonomousDatabaseId($autonomousDatabaseId)
        ->setAutonomousDatabase($autonomousDatabase);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->createAutonomousDatabase($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AutonomousDatabase $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = OracleDatabaseClient::locationName('[PROJECT]', '[LOCATION]');
    $autonomousDatabaseId = '[AUTONOMOUS_DATABASE_ID]';

    create_autonomous_database_sample($formattedParent, $autonomousDatabaseId);
}
// [END oracledatabase_v1_generated_OracleDatabase_CreateAutonomousDatabase_sync]
