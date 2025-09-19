<?php
/*
 * Copyright 2025 Google LLC
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

// [START vmmigration_v1_generated_VmMigration_UpdateDiskMigrationJob_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VMMigration\V1\Client\VmMigrationClient;
use Google\Cloud\VMMigration\V1\ComputeEngineDisk;
use Google\Cloud\VMMigration\V1\ComputeEngineDiskType;
use Google\Cloud\VMMigration\V1\DiskMigrationJob;
use Google\Cloud\VMMigration\V1\DiskMigrationJobTargetDetails;
use Google\Cloud\VMMigration\V1\UpdateDiskMigrationJobRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single DiskMigrationJob.
 *
 * @param string $formattedDiskMigrationJobTargetDetailsTargetDiskZone The Compute Engine zone in which to create the disk. Should be of
 *                                                                     the form: projects/{target-project}/locations/{zone}
 *                                                                     Please see {@see VmMigrationClient::locationName()} for help formatting this field.
 * @param int    $diskMigrationJobTargetDetailsTargetDiskDiskType      The disk type to use.
 * @param string $formattedDiskMigrationJobTargetDetailsTargetProject  The name of the resource of type TargetProject which represents
 *                                                                     the Compute Engine project in which to create the disk. Should be of the
 *                                                                     form: projects/{project}/locations/global/targetProjects/{target-project}
 *                                                                     Please see {@see VmMigrationClient::targetProjectName()} for help formatting this field.
 */
function update_disk_migration_job_sample(
    string $formattedDiskMigrationJobTargetDetailsTargetDiskZone,
    int $diskMigrationJobTargetDetailsTargetDiskDiskType,
    string $formattedDiskMigrationJobTargetDetailsTargetProject
): void {
    // Create a client.
    $vmMigrationClient = new VmMigrationClient();

    // Prepare the request message.
    $diskMigrationJobTargetDetailsTargetDisk = (new ComputeEngineDisk())
        ->setZone($formattedDiskMigrationJobTargetDetailsTargetDiskZone)
        ->setDiskType($diskMigrationJobTargetDetailsTargetDiskDiskType);
    $diskMigrationJobTargetDetails = (new DiskMigrationJobTargetDetails())
        ->setTargetDisk($diskMigrationJobTargetDetailsTargetDisk)
        ->setTargetProject($formattedDiskMigrationJobTargetDetailsTargetProject);
    $diskMigrationJob = (new DiskMigrationJob())
        ->setTargetDetails($diskMigrationJobTargetDetails);
    $request = (new UpdateDiskMigrationJobRequest())
        ->setDiskMigrationJob($diskMigrationJob);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmMigrationClient->updateDiskMigrationJob($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DiskMigrationJob $result */
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
    $formattedDiskMigrationJobTargetDetailsTargetDiskZone = VmMigrationClient::locationName(
        '[PROJECT]',
        '[LOCATION]'
    );
    $diskMigrationJobTargetDetailsTargetDiskDiskType = ComputeEngineDiskType::COMPUTE_ENGINE_DISK_TYPE_UNSPECIFIED;
    $formattedDiskMigrationJobTargetDetailsTargetProject = VmMigrationClient::targetProjectName(
        '[PROJECT]',
        '[LOCATION]',
        '[TARGET_PROJECT]'
    );

    update_disk_migration_job_sample(
        $formattedDiskMigrationJobTargetDetailsTargetDiskZone,
        $diskMigrationJobTargetDetailsTargetDiskDiskType,
        $formattedDiskMigrationJobTargetDetailsTargetProject
    );
}
// [END vmmigration_v1_generated_VmMigration_UpdateDiskMigrationJob_sync]
