<?php
/*
 * Copyright 2025 Google LLC
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

// [START oracledatabase_v1_generated_OracleDatabase_CreateDbSystem_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\CreateDbSystemRequest;
use Google\Cloud\OracleDatabase\V1\DbSystem;
use Google\Rpc\Status;

/**
 * Creates a new DbSystem in a given project and location.
 *
 * @param string $formattedParent            The value for parent of the DbSystem in the following format:
 *                                           projects/{project}/locations/{location}. Please see
 *                                           {@see OracleDatabaseClient::locationName()} for help formatting this field.
 * @param string $dbSystemId                 The ID of the DbSystem to create. This value is
 *                                           restricted to (^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$) and must be a maximum of
 *                                           63 characters in length. The value must start with a letter and end with a
 *                                           letter or a number.
 * @param string $formattedDbSystemOdbSubnet The name of the OdbSubnet associated with the DbSystem for IP
 *                                           allocation. Format:
 *                                           projects/{project}/locations/{location}/odbNetworks/{odb_network}/odbSubnets/{odb_subnet}
 *                                           Please see {@see OracleDatabaseClient::odbSubnetName()} for help formatting this field.
 * @param string $dbSystemDisplayName        The display name for the System db. The name does not have to
 *                                           be unique within your project.
 */
function create_db_system_sample(
    string $formattedParent,
    string $dbSystemId,
    string $formattedDbSystemOdbSubnet,
    string $dbSystemDisplayName
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $dbSystem = (new DbSystem())
        ->setOdbSubnet($formattedDbSystemOdbSubnet)
        ->setDisplayName($dbSystemDisplayName);
    $request = (new CreateDbSystemRequest())
        ->setParent($formattedParent)
        ->setDbSystemId($dbSystemId)
        ->setDbSystem($dbSystem);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->createDbSystem($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DbSystem $result */
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
    $dbSystemId = '[DB_SYSTEM_ID]';
    $formattedDbSystemOdbSubnet = OracleDatabaseClient::odbSubnetName(
        '[PROJECT]',
        '[LOCATION]',
        '[ODB_NETWORK]',
        '[ODB_SUBNET]'
    );
    $dbSystemDisplayName = '[DISPLAY_NAME]';

    create_db_system_sample(
        $formattedParent,
        $dbSystemId,
        $formattedDbSystemOdbSubnet,
        $dbSystemDisplayName
    );
}
// [END oracledatabase_v1_generated_OracleDatabase_CreateDbSystem_sync]
