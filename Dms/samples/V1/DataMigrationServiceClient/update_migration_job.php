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

// [START datamigration_v1_generated_DataMigrationService_UpdateMigrationJob_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\CloudDms\V1\DataMigrationServiceClient;
use Google\Cloud\CloudDms\V1\MigrationJob;
use Google\Cloud\CloudDms\V1\MigrationJob\Type;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single migration job.
 *
 * @param int    $migrationJobType        The migration job type.
 * @param string $migrationJobSource      The resource name (URI) of the source connection profile.
 * @param string $migrationJobDestination The resource name (URI) of the destination connection profile.
 */
function update_migration_job_sample(
    int $migrationJobType,
    string $migrationJobSource,
    string $migrationJobDestination
): void {
    // Create a client.
    $dataMigrationServiceClient = new DataMigrationServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $updateMask = new FieldMask();
    $migrationJob = (new MigrationJob())
        ->setType($migrationJobType)
        ->setSource($migrationJobSource)
        ->setDestination($migrationJobDestination);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataMigrationServiceClient->updateMigrationJob($updateMask, $migrationJob);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MigrationJob $result */
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
    $migrationJobType = Type::TYPE_UNSPECIFIED;
    $migrationJobSource = '[SOURCE]';
    $migrationJobDestination = '[DESTINATION]';

    update_migration_job_sample($migrationJobType, $migrationJobSource, $migrationJobDestination);
}
// [END datamigration_v1_generated_DataMigrationService_UpdateMigrationJob_sync]
