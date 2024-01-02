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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_GetSnapshot_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Snapshot;

/**
 * Gets metadata information about the specified snapshot.
 *
 * Note: This is a private alpha release of Cloud Bigtable snapshots. This
 * feature is not currently available to most Cloud Bigtable customers. This
 * feature might be changed in backward-incompatible ways and is not
 * recommended for production use. It is not subject to any SLA or deprecation
 * policy.
 *
 * @param string $formattedName The unique name of the requested snapshot.
 *                              Values are of the form
 *                              `projects/{project}/instances/{instance}/clusters/{cluster}/snapshots/{snapshot}`. Please see
 *                              {@see BigtableTableAdminClient::snapshotName()} for help formatting this field.
 */
function get_snapshot_sample(string $formattedName): void
{
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var Snapshot $response */
        $response = $bigtableTableAdminClient->getSnapshot($formattedName);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedName = BigtableTableAdminClient::snapshotName(
        '[PROJECT]',
        '[INSTANCE]',
        '[CLUSTER]',
        '[SNAPSHOT]'
    );

    get_snapshot_sample($formattedName);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_GetSnapshot_sync]
