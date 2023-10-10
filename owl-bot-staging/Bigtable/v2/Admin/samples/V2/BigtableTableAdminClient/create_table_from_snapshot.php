<?php
/*
 * Copyright 2023 Google LLC
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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_CreateTableFromSnapshot_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Rpc\Status;

/**
 * Creates a new table from the specified snapshot. The target table must
 * not exist. The snapshot and the table must be in the same instance.
 *
 * Note: This is a private alpha release of Cloud Bigtable snapshots. This
 * feature is not currently available to most Cloud Bigtable customers. This
 * feature might be changed in backward-incompatible ways and is not
 * recommended for production use. It is not subject to any SLA or deprecation
 * policy.
 *
 * @param string $formattedParent         The unique name of the instance in which to create the table.
 *                                        Values are of the form `projects/{project}/instances/{instance}`. Please see
 *                                        {@see BigtableTableAdminClient::instanceName()} for help formatting this field.
 * @param string $tableId                 The name by which the new table should be referred to within the
 *                                        parent instance, e.g., `foobar` rather than `{parent}/tables/foobar`.
 * @param string $formattedSourceSnapshot The unique name of the snapshot from which to restore the table.
 *                                        The snapshot and the table must be in the same instance. Values are of the
 *                                        form
 *                                        `projects/{project}/instances/{instance}/clusters/{cluster}/snapshots/{snapshot}`. Please see
 *                                        {@see BigtableTableAdminClient::snapshotName()} for help formatting this field.
 */
function create_table_from_snapshot_sample(
    string $formattedParent,
    string $tableId,
    string $formattedSourceSnapshot
): void {
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableTableAdminClient->createTableFromSnapshot(
            $formattedParent,
            $tableId,
            $formattedSourceSnapshot
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Table $result */
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
    $formattedParent = BigtableTableAdminClient::instanceName('[PROJECT]', '[INSTANCE]');
    $tableId = '[TABLE_ID]';
    $formattedSourceSnapshot = BigtableTableAdminClient::snapshotName(
        '[PROJECT]',
        '[INSTANCE]',
        '[CLUSTER]',
        '[SNAPSHOT]'
    );

    create_table_from_snapshot_sample($formattedParent, $tableId, $formattedSourceSnapshot);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_CreateTableFromSnapshot_sync]
