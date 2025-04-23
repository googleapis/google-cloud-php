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

// [START gkebackup_v1_generated_BackupForGKE_GetRestorePlanBinding_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeBackup\V1\Client\BackupForGKEClient;
use Google\Cloud\GkeBackup\V1\GetRestorePlanBindingRequest;
use Google\Cloud\GkeBackup\V1\RestorePlanBinding;

/**
 * Retrieve the details of a single RestorePlanBinding.
 *
 * @param string $formattedName Fully qualified RestorePlanBinding name.
 *                              Format:
 *                              `projects/&#42;/locations/&#42;/restoreChannels/&#42;/restorePlanBindings/*`
 *                              Please see {@see BackupForGKEClient::restorePlanBindingName()} for help formatting this field.
 */
function get_restore_plan_binding_sample(string $formattedName): void
{
    // Create a client.
    $backupForGKEClient = new BackupForGKEClient();

    // Prepare the request message.
    $request = (new GetRestorePlanBindingRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var RestorePlanBinding $response */
        $response = $backupForGKEClient->getRestorePlanBinding($request);
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
    $formattedName = BackupForGKEClient::restorePlanBindingName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESTORE_CHANNEL]',
        '[RESTORE_PLAN_BINDING]'
    );

    get_restore_plan_binding_sample($formattedName);
}
// [END gkebackup_v1_generated_BackupForGKE_GetRestorePlanBinding_sync]
