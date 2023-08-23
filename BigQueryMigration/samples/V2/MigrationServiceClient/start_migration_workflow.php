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

// [START bigquerymigration_v2_generated_MigrationService_StartMigrationWorkflow_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Migration\V2\Client\MigrationServiceClient;
use Google\Cloud\BigQuery\Migration\V2\StartMigrationWorkflowRequest;

/**
 * Starts a previously created migration workflow. I.e., the state transitions
 * from DRAFT to RUNNING. This is a no-op if the state is already RUNNING.
 * An error will be signaled if the state is anything other than DRAFT or
 * RUNNING.
 *
 * @param string $formattedName The unique identifier for the migration workflow.
 *                              Example: `projects/123/locations/us/workflows/1234`
 *                              Please see {@see MigrationServiceClient::migrationWorkflowName()} for help formatting this field.
 */
function start_migration_workflow_sample(string $formattedName): void
{
    // Create a client.
    $migrationServiceClient = new MigrationServiceClient();

    // Prepare the request message.
    $request = (new StartMigrationWorkflowRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $migrationServiceClient->startMigrationWorkflow($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = MigrationServiceClient::migrationWorkflowName(
        '[PROJECT]',
        '[LOCATION]',
        '[WORKFLOW]'
    );

    start_migration_workflow_sample($formattedName);
}
// [END bigquerymigration_v2_generated_MigrationService_StartMigrationWorkflow_sync]
