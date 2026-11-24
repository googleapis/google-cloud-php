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

// [START oracledatabase_v1_generated_OracleDatabase_UpdateDbSystem_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\DbSystem;
use Google\Cloud\OracleDatabase\V1\UpdateDbSystemRequest;
use Google\Rpc\Status;

/**
 * Updates the `labels` of a single DbSystem.
 *
 * @param string $formattedDbSystemOdbSubnet Immutable. The name of the OdbSubnet associated with the DbSystem
 *                                           for IP allocation. Format:
 *                                           projects/{project}/locations/{location}/odbNetworks/{odb_network}/odbSubnets/{odb_subnet}
 *                                           Please see {@see OracleDatabaseClient::odbSubnetName()} for help formatting this field.
 * @param string $dbSystemDisplayName        Immutable. The display name for the System db. The name does not
 *                                           have to be unique within your project.
 */
function update_db_system_sample(
    string $formattedDbSystemOdbSubnet,
    string $dbSystemDisplayName
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $dbSystem = (new DbSystem())
        ->setOdbSubnet($formattedDbSystemOdbSubnet)
        ->setDisplayName($dbSystemDisplayName);
    $request = (new UpdateDbSystemRequest())
        ->setDbSystem($dbSystem);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->updateDbSystem($request);
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
    $formattedDbSystemOdbSubnet = OracleDatabaseClient::odbSubnetName(
        '[PROJECT]',
        '[LOCATION]',
        '[ODB_NETWORK]',
        '[ODB_SUBNET]'
    );
    $dbSystemDisplayName = '[DISPLAY_NAME]';

    update_db_system_sample($formattedDbSystemOdbSubnet, $dbSystemDisplayName);
}
// [END oracledatabase_v1_generated_OracleDatabase_UpdateDbSystem_sync]
