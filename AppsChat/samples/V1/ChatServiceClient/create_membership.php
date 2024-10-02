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

// [START chat_v1_generated_ChatService_CreateMembership_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\CreateMembershipRequest;
use Google\Apps\Chat\V1\Membership;

/**
 * Creates a membership for the calling Chat app, a user, or a Google Group.
 * Creating memberships for other Chat apps isn't supported.
 * When creating a membership, if the specified member has their auto-accept
 * policy turned off, then they're invited, and must accept the space
 * invitation before joining. Otherwise, creating a membership adds the member
 * directly to the specified space.
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user).
 *
 * For example usage, see:
 *
 * - [Invite or add a user to a
 * space](https://developers.google.com/workspace/chat/create-members#create-user-membership).
 *
 * - [Invite or add a Google Group to a
 * space](https://developers.google.com/workspace/chat/create-members#create-group-membership).
 *
 * - [Add the Chat app to a
 * space](https://developers.google.com/workspace/chat/create-members#create-membership-calling-api).
 *
 * @param string $formattedParent The resource name of the space for which to create the
 *                                membership.
 *
 *                                Format: spaces/{space}
 *                                Please see {@see ChatServiceClient::spaceName()} for help formatting this field.
 */
function create_membership_sample(string $formattedParent): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $membership = new Membership();
    $request = (new CreateMembershipRequest())
        ->setParent($formattedParent)
        ->setMembership($membership);

    // Call the API and handle any network failures.
    try {
        /** @var Membership $response */
        $response = $chatServiceClient->createMembership($request);
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
    $formattedParent = ChatServiceClient::spaceName('[SPACE]');

    create_membership_sample($formattedParent);
}
// [END chat_v1_generated_ChatService_CreateMembership_sync]
