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

// [START spanner_v1_generated_DatabaseAdmin_DropDatabase_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\DropDatabaseRequest;

/**
 * Drops (aka deletes) a Cloud Spanner database.
 * Completed backups for the database will be retained according to their
 * `expire_time`.
 * Note: Cloud Spanner might continue to accept requests for a few seconds
 * after the database has been deleted.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function drop_database_sample(): void
{
    // Create a client.
    $databaseAdminClient = new DatabaseAdminClient();

    // Prepare the request message.
    $request = new DropDatabaseRequest();

    // Call the API and handle any network failures.
    try {
        $databaseAdminClient->dropDatabase($request);
        printf('Call completed successfully.' . PHP_EOL);
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END spanner_v1_generated_DatabaseAdmin_DropDatabase_sync]
