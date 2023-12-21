<?php
/*
 * Copyright 2023 Google LLC
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

// [START netapp_v1_generated_NetApp_GetBackupPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetApp\V1\BackupPolicy;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\GetBackupPolicyRequest;

/**
 * Returns the description of the specified backup policy by backup_policy_id.
 *
 * @param string $formattedName The backupPolicy resource name, in the format
 *                              `projects/{project_id}/locations/{location}/backupPolicies/{backup_policy_id}`
 *                              Please see {@see NetAppClient::backupPolicyName()} for help formatting this field.
 */
function get_backup_policy_sample(string $formattedName): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $request = (new GetBackupPolicyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var BackupPolicy $response */
        $response = $netAppClient->getBackupPolicy($request);
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
    $formattedName = NetAppClient::backupPolicyName('[PROJECT]', '[LOCATION]', '[BACKUP_POLICY]');

    get_backup_policy_sample($formattedName);
}
// [END netapp_v1_generated_NetApp_GetBackupPolicy_sync]
