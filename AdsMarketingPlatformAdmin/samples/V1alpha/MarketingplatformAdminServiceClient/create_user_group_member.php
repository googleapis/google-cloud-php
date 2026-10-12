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

// [START marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_CreateUserGroupMember_sync]
use Google\Ads\MarketingPlatform\Admin\V1alpha\Client\MarketingplatformAdminServiceClient;
use Google\Ads\MarketingPlatform\Admin\V1alpha\CreateUserGroupMemberRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\UserGroupMember;
use Google\ApiCore\ApiException;

/**
 * Adds a member to the specified GMP user group.
 *
 * @param string $formattedParent The parent resource where this UserGroupMember will be created.
 *                                Format: organizations/{org_id}/userGroups/{user_group_id}
 *                                Please see {@see MarketingplatformAdminServiceClient::userGroupName()} for help formatting this field.
 */
function create_user_group_member_sample(string $formattedParent): void
{
    // Create a client.
    $marketingplatformAdminServiceClient = new MarketingplatformAdminServiceClient();

    // Prepare the request message.
    $userGroupMember = new UserGroupMember();
    $request = (new CreateUserGroupMemberRequest())
        ->setParent($formattedParent)
        ->setUserGroupMember($userGroupMember);

    // Call the API and handle any network failures.
    try {
        /** @var UserGroupMember $response */
        $response = $marketingplatformAdminServiceClient->createUserGroupMember($request);
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
    $formattedParent = MarketingplatformAdminServiceClient::userGroupName(
        '[ORGANIZATION]',
        '[USER_GROUP]'
    );

    create_user_group_member_sample($formattedParent);
}
// [END marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_CreateUserGroupMember_sync]
