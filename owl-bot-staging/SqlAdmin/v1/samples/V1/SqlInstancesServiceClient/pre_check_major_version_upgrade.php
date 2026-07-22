<?php
/*
 * Copyright 2026 Google LLC
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

// [START sqladmin_v1_generated_SqlInstancesService_PreCheckMajorVersionUpgrade_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1\Client\SqlInstancesServiceClient;
use Google\Cloud\Sql\V1\InstancesPreCheckMajorVersionUpgradeRequest;
use Google\Cloud\Sql\V1\Operation;
use Google\Cloud\Sql\V1\PreCheckMajorVersionUpgradeContext;
use Google\Cloud\Sql\V1\SqlDatabaseVersion;
use Google\Cloud\Sql\V1\SqlInstancesPreCheckMajorVersionUpgradeRequest;

/**
 * Execute MVU Pre-checks
 *
 * @param string $instance                                                    Cloud SQL instance ID. This does not include the project ID.
 * @param string $project                                                     Project ID of the project that contains the instance.
 * @param int    $bodyPreCheckMajorVersionUpgradeContextTargetDatabaseVersion The target database version to upgrade to.
 */
function pre_check_major_version_upgrade_sample(
    string $instance,
    string $project,
    int $bodyPreCheckMajorVersionUpgradeContextTargetDatabaseVersion
): void {
    // Create a client.
    $sqlInstancesServiceClient = new SqlInstancesServiceClient();

    // Prepare the request message.
    $bodyPreCheckMajorVersionUpgradeContext = (new PreCheckMajorVersionUpgradeContext())
        ->setTargetDatabaseVersion($bodyPreCheckMajorVersionUpgradeContextTargetDatabaseVersion);
    $body = (new InstancesPreCheckMajorVersionUpgradeRequest())
        ->setPreCheckMajorVersionUpgradeContext($bodyPreCheckMajorVersionUpgradeContext);
    $request = (new SqlInstancesPreCheckMajorVersionUpgradeRequest())
        ->setInstance($instance)
        ->setProject($project)
        ->setBody($body);

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $sqlInstancesServiceClient->preCheckMajorVersionUpgrade($request);
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
    $instance = '[INSTANCE]';
    $project = '[PROJECT]';
    $bodyPreCheckMajorVersionUpgradeContextTargetDatabaseVersion = SqlDatabaseVersion::SQL_DATABASE_VERSION_UNSPECIFIED;

    pre_check_major_version_upgrade_sample(
        $instance,
        $project,
        $bodyPreCheckMajorVersionUpgradeContextTargetDatabaseVersion
    );
}
// [END sqladmin_v1_generated_SqlInstancesService_PreCheckMajorVersionUpgrade_sync]
