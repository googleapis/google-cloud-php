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

// [START marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_DeleteUserGroup_sync]
use Google\Ads\MarketingPlatform\Admin\V1alpha\Client\MarketingplatformAdminServiceClient;
use Google\Ads\MarketingPlatform\Admin\V1alpha\DeleteUserGroupRequest;
use Google\ApiCore\ApiException;

/**
 * Deletes a user group in the specified GMP organization.
 *
 * @param string $formattedName The name of the user group to delete.
 *                              Format: organizations/{org_id}/userGroups/{user_group_id}
 *                              Please see {@see MarketingplatformAdminServiceClient::userGroupName()} for help formatting this field.
 */
function delete_user_group_sample(string $formattedName): void
{
    // Create a client.
    $marketingplatformAdminServiceClient = new MarketingplatformAdminServiceClient();

    // Prepare the request message.
    $request = (new DeleteUserGroupRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $marketingplatformAdminServiceClient->deleteUserGroup($request);
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
    $formattedName = MarketingplatformAdminServiceClient::userGroupName(
        '[ORGANIZATION]',
        '[USER_GROUP]'
    );

    delete_user_group_sample($formattedName);
}
// [END marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_DeleteUserGroup_sync]
