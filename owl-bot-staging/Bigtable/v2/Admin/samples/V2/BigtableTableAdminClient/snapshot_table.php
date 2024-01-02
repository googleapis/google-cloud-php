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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_SnapshotTable_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Snapshot;
use Google\Rpc\Status;

/**
 * Creates a new snapshot in the specified cluster from the specified
 * source table. The cluster and the table must be in the same instance.
 *
 * Note: This is a private alpha release of Cloud Bigtable snapshots. This
 * feature is not currently available to most Cloud Bigtable customers. This
 * feature might be changed in backward-incompatible ways and is not
 * recommended for production use. It is not subject to any SLA or deprecation
 * policy.
 *
 * @param string $formattedName    The unique name of the table to have the snapshot taken.
 *                                 Values are of the form
 *                                 `projects/{project}/instances/{instance}/tables/{table}`. Please see
 *                                 {@see BigtableTableAdminClient::tableName()} for help formatting this field.
 * @param string $formattedCluster The name of the cluster where the snapshot will be created in.
 *                                 Values are of the form
 *                                 `projects/{project}/instances/{instance}/clusters/{cluster}`. Please see
 *                                 {@see BigtableTableAdminClient::clusterName()} for help formatting this field.
 * @param string $snapshotId       The ID by which the new snapshot should be referred to within the
 *                                 parent cluster, e.g., `mysnapshot` of the form:
 *                                 `[_a-zA-Z0-9][-_.a-zA-Z0-9]*` rather than
 *                                 `projects/{project}/instances/{instance}/clusters/{cluster}/snapshots/mysnapshot`.
 */
function snapshot_table_sample(
    string $formattedName,
    string $formattedCluster,
    string $snapshotId
): void {
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableTableAdminClient->snapshotTable(
            $formattedName,
            $formattedCluster,
            $snapshotId
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Snapshot $result */
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
    $formattedName = BigtableTableAdminClient::tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
    $formattedCluster = BigtableTableAdminClient::clusterName('[PROJECT]', '[INSTANCE]', '[CLUSTER]');
    $snapshotId = '[SNAPSHOT_ID]';

    snapshot_table_sample($formattedName, $formattedCluster, $snapshotId);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_SnapshotTable_sync]
