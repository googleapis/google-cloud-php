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

// [START oracledatabase_v1_generated_OracleDatabase_UpdateGoldengateConnection_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\GoldengateConnection;
use Google\Cloud\OracleDatabase\V1\GoldengateConnectionProperties;
use Google\Cloud\OracleDatabase\V1\GoldengateConnectionProperties\GoldengateConnectionType;
use Google\Cloud\OracleDatabase\V1\UpdateGoldengateConnectionRequest;
use Google\Rpc\Status;

/**
 * Updates the `labels` of a single GoldengateConnection.
 *
 * @param int    $goldengateConnectionPropertiesConnectionType The connection type.
 * @param string $goldengateConnectionPropertiesDisplayName    An object's Display Name.
 */
function update_goldengate_connection_sample(
    int $goldengateConnectionPropertiesConnectionType,
    string $goldengateConnectionPropertiesDisplayName
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $goldengateConnectionProperties = (new GoldengateConnectionProperties())
        ->setConnectionType($goldengateConnectionPropertiesConnectionType)
        ->setDisplayName($goldengateConnectionPropertiesDisplayName);
    $goldengateConnection = (new GoldengateConnection())
        ->setProperties($goldengateConnectionProperties);
    $request = (new UpdateGoldengateConnectionRequest())
        ->setGoldengateConnection($goldengateConnection);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->updateGoldengateConnection($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GoldengateConnection $result */
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
    $goldengateConnectionPropertiesConnectionType = GoldengateConnectionType::GOLDENGATE_CONNECTION_TYPE_UNSPECIFIED;
    $goldengateConnectionPropertiesDisplayName = '[DISPLAY_NAME]';

    update_goldengate_connection_sample(
        $goldengateConnectionPropertiesConnectionType,
        $goldengateConnectionPropertiesDisplayName
    );
}
// [END oracledatabase_v1_generated_OracleDatabase_UpdateGoldengateConnection_sync]
