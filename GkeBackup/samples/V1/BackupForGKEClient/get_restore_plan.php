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

// [START gkebackup_v1_generated_BackupForGKE_GetRestorePlan_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeBackup\V1\Client\BackupForGKEClient;
use Google\Cloud\GkeBackup\V1\GetRestorePlanRequest;
use Google\Cloud\GkeBackup\V1\RestorePlan;

/**
 * Retrieve the details of a single RestorePlan.
 *
 * @param string $formattedName Fully qualified RestorePlan name.
 *                              Format: projects/&#42;/locations/&#42;/restorePlans/*
 *                              Please see {@see BackupForGKEClient::restorePlanName()} for help formatting this field.
 */
function get_restore_plan_sample(string $formattedName): void
{
    // Create a client.
    $backupForGKEClient = new BackupForGKEClient();

    // Prepare the request message.
    $request = (new GetRestorePlanRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var RestorePlan $response */
        $response = $backupForGKEClient->getRestorePlan($request);
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
    $formattedName = BackupForGKEClient::restorePlanName('[PROJECT]', '[LOCATION]', '[RESTORE_PLAN]');

    get_restore_plan_sample($formattedName);
}
// [END gkebackup_v1_generated_BackupForGKE_GetRestorePlan_sync]
