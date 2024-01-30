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

// [START accessapproval_v1_generated_AccessApproval_DeleteAccessApprovalSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AccessApproval\V1\Client\AccessApprovalClient;
use Google\Cloud\AccessApproval\V1\DeleteAccessApprovalSettingsMessage;

/**
 * Deletes the settings associated with a project, folder, or organization.
 * This will have the effect of disabling Access Approval for the project,
 * folder, or organization, but only if all ancestors also have Access
 * Approval disabled. If Access Approval is enabled at a higher level of the
 * hierarchy, then Access Approval will still be enabled at this level as
 * the settings are inherited.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function delete_access_approval_settings_sample(): void
{
    // Create a client.
    $accessApprovalClient = new AccessApprovalClient();

    // Prepare the request message.
    $request = new DeleteAccessApprovalSettingsMessage();

    // Call the API and handle any network failures.
    try {
        $accessApprovalClient->deleteAccessApprovalSettings($request);
        printf('Call completed successfully.' . PHP_EOL);
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END accessapproval_v1_generated_AccessApproval_DeleteAccessApprovalSettings_sync]
