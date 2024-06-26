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

// [START sqladmin_v1beta4_generated_SqlInstancesService_ReleaseSsrsLease_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1beta4\SqlInstancesReleaseSsrsLeaseResponse;
use Google\Cloud\Sql\V1beta4\SqlInstancesServiceClient;

/**
 * Release a lease for the setup of SQL Server Reporting Services (SSRS).
 *
 * @param string $instance The Cloud SQL instance ID. This doesn't include the project ID.
 *                         It's composed of lowercase letters, numbers, and hyphens, and it must start
 *                         with a letter. The total length must be 98 characters or less (Example:
 *                         instance-id).
 * @param string $project  The ID of the project that contains the instance (Example:
 *                         project-id).
 */
function release_ssrs_lease_sample(string $instance, string $project): void
{
    // Create a client.
    $sqlInstancesServiceClient = new SqlInstancesServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var SqlInstancesReleaseSsrsLeaseResponse $response */
        $response = $sqlInstancesServiceClient->releaseSsrsLease($instance, $project);
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

    release_ssrs_lease_sample($instance, $project);
}
// [END sqladmin_v1beta4_generated_SqlInstancesService_ReleaseSsrsLease_sync]
