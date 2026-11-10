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

// [START oracledatabase_v1_generated_OracleDatabase_UpdateExascaleDbStorageVault_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageDetails;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageVault;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageVaultProperties;
use Google\Cloud\OracleDatabase\V1\UpdateExascaleDbStorageVaultRequest;
use Google\Rpc\Status;

/**
 * Updates the `labels` of a single ExascaleDbStorageVault.
 *
 * @param string $exascaleDbStorageVaultDisplayName                                    Immutable. The display name for the ExascaleDbStorageVault. The
 *                                                                                     name does not have to be unique within your project. The name must be 1-255
 *                                                                                     characters long and can only contain alphanumeric characters.
 * @param int    $exascaleDbStorageVaultPropertiesExascaleDbStorageDetailsTotalSizeGbs The total storage allocation for the ExascaleDbStorageVault, in
 *                                                                                     gigabytes (GB).
 */
function update_exascale_db_storage_vault_sample(
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
    $request = (new UpdateExascaleDbStorageVaultRequest())
        ->setExascaleDbStorageVault($exascaleDbStorageVault);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->updateExascaleDbStorageVault($request);
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
    $exascaleDbStorageVaultDisplayName = '[DISPLAY_NAME]';
    $exascaleDbStorageVaultPropertiesExascaleDbStorageDetailsTotalSizeGbs = 0;

    update_exascale_db_storage_vault_sample(
        $exascaleDbStorageVaultDisplayName,
        $exascaleDbStorageVaultPropertiesExascaleDbStorageDetailsTotalSizeGbs
    );
}
// [END oracledatabase_v1_generated_OracleDatabase_UpdateExascaleDbStorageVault_sync]
