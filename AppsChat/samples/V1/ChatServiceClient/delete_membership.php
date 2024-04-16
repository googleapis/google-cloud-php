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

// [START chat_v1_generated_ChatService_DeleteMembership_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\DeleteMembershipRequest;
use Google\Apps\Chat\V1\Membership;

/**
 * Deletes a membership. For an example, see
 * [Remove a user or a Google Chat app from a
 * space](https://developers.google.com/workspace/chat/delete-members).
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user).
 *
 * @param string $formattedName Resource name of the membership to delete. Chat apps can delete
 *                              human users' or their own memberships. Chat apps can't delete other apps'
 *                              memberships.
 *
 *                              When deleting a human membership, requires the `chat.memberships` scope and
 *                              `spaces/{space}/members/{member}` format. You can use the email as an
 *                              alias for `{member}`. For example,
 *                              `spaces/{space}/members/example&#64;gmail.com` where `example&#64;gmail.com` is the
 *                              email of the Google Chat user.
 *
 *                              When deleting an app membership, requires the `chat.memberships.app` scope
 *                              and `spaces/{space}/members/app` format.
 *
 *                              Format: `spaces/{space}/members/{member}` or `spaces/{space}/members/app`. Please see
 *                              {@see ChatServiceClient::membershipName()} for help formatting this field.
 */
function delete_membership_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new DeleteMembershipRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Membership $response */
        $response = $chatServiceClient->deleteMembership($request);
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
    $formattedName = ChatServiceClient::membershipName('[SPACE]', '[MEMBER]');

    delete_membership_sample($formattedName);
}
// [END chat_v1_generated_ChatService_DeleteMembership_sync]
