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

// [START sqladmin_v1_generated_SqlInstancesService_ReleaseSsrsLease_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1\Client\SqlInstancesServiceClient;
use Google\Cloud\Sql\V1\SqlInstancesReleaseSsrsLeaseRequest;
use Google\Cloud\Sql\V1\SqlInstancesReleaseSsrsLeaseResponse;

/**
 * Release a lease for the setup of SQL Server Reporting Services (SSRS).
 *
 * @param string $instance The Cloud SQL instance ID. This doesn't include the project ID.
 *                         The instance ID contains lowercase letters, numbers, and hyphens, and it
 *                         must start with a letter. This ID can have a maximum length of 98
 *                         characters.
 * @param string $project  The project ID that contains the instance.
 */
function release_ssrs_lease_sample(string $instance, string $project): void
{
    // Create a client.
    $sqlInstancesServiceClient = new SqlInstancesServiceClient();

    // Prepare the request message.
    $request = (new SqlInstancesReleaseSsrsLeaseRequest())
        ->setInstance($instance)
        ->setProject($project);

    // Call the API and handle any network failures.
    try {
        /** @var SqlInstancesReleaseSsrsLeaseResponse $response */
        $response = $sqlInstancesServiceClient->releaseSsrsLease($request);
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
// [END sqladmin_v1_generated_SqlInstancesService_ReleaseSsrsLease_sync]
