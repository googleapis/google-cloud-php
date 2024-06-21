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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_CheckConsistency_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\CheckConsistencyRequest;
use Google\Cloud\Bigtable\Admin\V2\CheckConsistencyResponse;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient;

/**
 * Checks replication consistency based on a consistency token, that is, if
 * replication has caught up based on the conditions specified in the token
 * and the check request.
 *
 * @param string $formattedName    The unique name of the Table for which to check replication
 *                                 consistency. Values are of the form
 *                                 `projects/{project}/instances/{instance}/tables/{table}`. Please see
 *                                 {@see BigtableTableAdminClient::tableName()} for help formatting this field.
 * @param string $consistencyToken The token created using GenerateConsistencyToken for the Table.
 */
function check_consistency_sample(string $formattedName, string $consistencyToken): void
{
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare the request message.
    $request = (new CheckConsistencyRequest())
        ->setName($formattedName)
        ->setConsistencyToken($consistencyToken);

    // Call the API and handle any network failures.
    try {
        /** @var CheckConsistencyResponse $response */
        $response = $bigtableTableAdminClient->checkConsistency($request);
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
    $formattedName = BigtableTableAdminClient::tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
    $consistencyToken = '[CONSISTENCY_TOKEN]';

    check_consistency_sample($formattedName, $consistencyToken);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_CheckConsistency_sync]
