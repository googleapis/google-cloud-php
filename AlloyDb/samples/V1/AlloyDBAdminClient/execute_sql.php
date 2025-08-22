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

// [START alloydb_v1_generated_AlloyDBAdmin_ExecuteSql_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AlloyDb\V1\Client\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1\ExecuteSqlRequest;
use Google\Cloud\AlloyDb\V1\ExecuteSqlResponse;

/**
 * Executes a SQL statement in a database inside an AlloyDB instance.
 *
 * @param string $formattedInstance The instance where the SQL will be executed. For the required
 *                                  format, see the comment on the Instance.name field. Please see
 *                                  {@see AlloyDBAdminClient::instanceName()} for help formatting this field.
 * @param string $database          Name of the database where the query will be executed.
 *                                  Note - Value provided should be the same as expected from `SELECT
 *                                  current_database();` and NOT as a resource reference.
 * @param string $sqlStatement      SQL statement to execute on database. Any valid statement is
 *                                  permitted, including DDL, DML, DQL statements.
 */
function execute_sql_sample(
    string $formattedInstance,
    string $database,
    string $sqlStatement
): void {
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Prepare the request message.
    $request = (new ExecuteSqlRequest())
        ->setInstance($formattedInstance)
        ->setDatabase($database)
        ->setSqlStatement($sqlStatement);

    // Call the API and handle any network failures.
    try {
        /** @var ExecuteSqlResponse $response */
        $response = $alloyDBAdminClient->executeSql($request);
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
    $formattedInstance = AlloyDBAdminClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]',
        '[INSTANCE]'
    );
    $database = '[DATABASE]';
    $sqlStatement = '[SQL_STATEMENT]';

    execute_sql_sample($formattedInstance, $database, $sqlStatement);
}
// [END alloydb_v1_generated_AlloyDBAdmin_ExecuteSql_sync]
