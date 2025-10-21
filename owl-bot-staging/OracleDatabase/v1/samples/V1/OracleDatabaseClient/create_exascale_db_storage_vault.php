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

// [START oracledatabase_v1_generated_OracleDatabase_CreateExascaleDbStorageVault_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\CreateExascaleDbStorageVaultRequest;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageDetails;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageVault;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageVaultProperties;
use Google\Rpc\Status;

/**
 * Creates a new ExascaleDB Storage Vault resource.
 *
 * @param string $formattedParent                                                      The value for parent of the ExascaleDbStorageVault in the
 *                                                                                     following format: projects/{project}/locations/{location}. Please see
 *                                                                                     {@see OracleDatabaseClient::locationName()} for help formatting this field.
 * @param string $exascaleDbStorageVaultId                                             The ID of the ExascaleDbStorageVault to create. This value is
 *                                                                                     restricted to (^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$) and must be a maximum of
 *                                                                                     63 characters in length. The value must start with a letter and end with a
 *                                                                                     letter or a number.
 * @param string $exascaleDbStorageVaultDisplayName                                    The display name for the ExascaleDbStorageVault. The name does
 *                                                                                     not have to be unique within your project. The name must be 1-255
 *                                                                                     characters long and can only contain alphanumeric characters.
 * @param int    $exascaleDbStorageVaultPropertiesExascaleDbStorageDetailsTotalSizeGbs The total storage allocation for the ExascaleDbStorageVault, in
 *                                                                                     gigabytes (GB).
 */
function create_exascale_db_storage_vault_sample(
    string $formattedParent,
    string $exascaleDbStorageVaultId,
    string $exascaleDbStorageVaultDisplayName,
    int $exascaleDbStorageVaultPropertiesExascaleDbStorageDetailsTotalSizeGbs
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $exascaleDbStorageVaultPropertiesExascaleDbStorageDetails = (new ExascaleDbStorageDetails())
        ->setTotalSizeGbs($exascaleDbStorageVaultPropertiesExascaleDbStorageDetailsTotalSizeGbs);
    $exascaleDbStorageVaultProperties = (new ExascaleDbStorageVaultProperties())
        ->setExascaleDbStorageDetails($exascaleDbStorageVaultPropertiesExascaleDbStorageDetails);
    $exascaleDbStorageVault = (new ExascaleDbStorageVault())
        ->setDisplayName($exascaleDbStorageVaultDisplayName)
        ->setProperties($exascaleDbStorageVaultProperties);
    $request = (new CreateExascaleDbStorageVaultRequest())
        ->setParent($formattedParent)
        ->setExascaleDbStorageVaultId($exascaleDbStorageVaultId)
        ->setExascaleDbStorageVault($exascaleDbStorageVault);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->createExascaleDbStorageVault($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExascaleDbStorageVault $result */
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
    $exascaleDbStorageVaultId = '[EXASCALE_DB_STORAGE_VAULT_ID]';
    $exascaleDbStorageVaultDisplayName = '[DISPLAY_NAME]';
    $exascaleDbStorageVaultPropertiesExascaleDbStorageDetailsTotalSizeGbs = 0;

    create_exascale_db_storage_vault_sample(
        $formattedParent,
        $exascaleDbStorageVaultId,
        $exascaleDbStorageVaultDisplayName,
        $exascaleDbStorageVaultPropertiesExascaleDbStorageDetailsTotalSizeGbs
    );
}
// [END oracledatabase_v1_generated_OracleDatabase_CreateExascaleDbStorageVault_sync]
