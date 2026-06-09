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

// [START oracledatabase_v1_generated_OracleDatabase_CreateGoldengateConnectionAssignment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\CreateGoldengateConnectionAssignmentRequest;
use Google\Cloud\OracleDatabase\V1\GoldengateConnectionAssignment;
use Google\Cloud\OracleDatabase\V1\GoldengateConnectionAssignmentProperties;
use Google\Rpc\Status;

/**
 * Creates a new GoldengateConnectionAssignment in a given project and
 * location.
 *
 * @param string $formattedParent                                                       The parent resource where this GoldengateConnectionAssignment
 *                                                                                      will be created. Format: projects/{project}/locations/{location}
 *                                                                                      Please see {@see OracleDatabaseClient::locationName()} for help formatting this field.
 * @param string $goldengateConnectionAssignmentId                                      The ID of the GoldengateConnectionAssignment to create.
 * @param string $formattedGoldengateConnectionAssignmentPropertiesGoldengateConnection The GoldengateConnection resource to be assigned.
 *                                                                                      Format:
 *                                                                                      projects/{project}/locations/{location}/goldengateConnections/{goldengate_connection}
 *                                                                                      Please see {@see OracleDatabaseClient::goldengateConnectionName()} for help formatting this field.
 * @param string $formattedGoldengateConnectionAssignmentPropertiesGoldengateDeployment The GoldenGateDeployment to assign the connection to.
 *                                                                                      Format:
 *                                                                                      projects/{project}/locations/{location}/goldengateDeployments/{goldengate_deployment}
 *                                                                                      Please see {@see OracleDatabaseClient::goldengateDeploymentName()} for help formatting this field.
 */
function create_goldengate_connection_assignment_sample(
    string $formattedParent,
    string $goldengateConnectionAssignmentId,
    string $formattedGoldengateConnectionAssignmentPropertiesGoldengateConnection,
    string $formattedGoldengateConnectionAssignmentPropertiesGoldengateDeployment
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $goldengateConnectionAssignmentProperties = (new GoldengateConnectionAssignmentProperties())
        ->setGoldengateConnection($formattedGoldengateConnectionAssignmentPropertiesGoldengateConnection)
        ->setGoldengateDeployment($formattedGoldengateConnectionAssignmentPropertiesGoldengateDeployment);
    $goldengateConnectionAssignment = (new GoldengateConnectionAssignment())
        ->setProperties($goldengateConnectionAssignmentProperties);
    $request = (new CreateGoldengateConnectionAssignmentRequest())
        ->setParent($formattedParent)
        ->setGoldengateConnectionAssignmentId($goldengateConnectionAssignmentId)
        ->setGoldengateConnectionAssignment($goldengateConnectionAssignment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->createGoldengateConnectionAssignment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GoldengateConnectionAssignment $result */
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
    $goldengateConnectionAssignmentId = '[GOLDENGATE_CONNECTION_ASSIGNMENT_ID]';
    $formattedGoldengateConnectionAssignmentPropertiesGoldengateConnection = OracleDatabaseClient::goldengateConnectionName(
        '[PROJECT]',
        '[LOCATION]',
        '[GOLDENGATE_CONNECTION]'
    );
    $formattedGoldengateConnectionAssignmentPropertiesGoldengateDeployment = OracleDatabaseClient::goldengateDeploymentName(
        '[PROJECT]',
        '[LOCATION]',
        '[GOLDENGATE_DEPLOYMENT]'
    );

    create_goldengate_connection_assignment_sample(
        $formattedParent,
        $goldengateConnectionAssignmentId,
        $formattedGoldengateConnectionAssignmentPropertiesGoldengateConnection,
        $formattedGoldengateConnectionAssignmentPropertiesGoldengateDeployment
    );
}
// [END oracledatabase_v1_generated_OracleDatabase_CreateGoldengateConnectionAssignment_sync]
