<?php
/*
 * Copyright 2022 Google LLC
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

// [START metastore_v1alpha_generated_DataprocMetastore_MoveTableToDatabase_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Metastore\V1alpha\DataprocMetastoreClient;
use Google\Cloud\Metastore\V1alpha\MoveTableToDatabaseResponse;
use Google\Rpc\Status;

/**
 * Move a table to another database.
 *
 * @param string $formattedService  The relative resource name of the metastore service to mutate
 *                                  metadata, in the following format:
 *
 *                                  `projects/{project_id}/locations/{location_id}/services/{service_id}`. Please see
 *                                  {@see DataprocMetastoreClient::serviceName()} for help formatting this field.
 * @param string $tableName         The name of the table to be moved.
 * @param string $dbName            The name of the database where the table resides.
 * @param string $destinationDbName The name of the database where the table should be moved.
 */
function move_table_to_database_sample(
    string $formattedService,
    string $tableName,
    string $dbName,
    string $destinationDbName
): void {
    // Create a client.
    $dataprocMetastoreClient = new DataprocMetastoreClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataprocMetastoreClient->moveTableToDatabase(
            $formattedService,
            $tableName,
            $dbName,
            $destinationDbName
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MoveTableToDatabaseResponse $result */
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
    $formattedService = DataprocMetastoreClient::serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');
    $tableName = '[TABLE_NAME]';
    $dbName = '[DB_NAME]';
    $destinationDbName = '[DESTINATION_DB_NAME]';

    move_table_to_database_sample($formattedService, $tableName, $dbName, $destinationDbName);
}
// [END metastore_v1alpha_generated_DataprocMetastore_MoveTableToDatabase_sync]
