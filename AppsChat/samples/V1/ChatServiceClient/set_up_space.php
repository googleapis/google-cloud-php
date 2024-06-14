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

// [START chat_v1_generated_ChatService_SetUpSpace_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\SetUpSpaceRequest;
use Google\Apps\Chat\V1\Space;

/**
 * Creates a space and adds specified users to it. The calling user is
 * automatically added to the space, and shouldn't be specified as a
 * membership in the request. For an example, see
 * [Set up a space with initial
 * members](https://developers.google.com/workspace/chat/set-up-spaces).
 *
 * To specify the human members to add, add memberships with the appropriate
 * `membership.member.name`. To add a human user, use `users/{user}`, where
 * `{user}` can be the email address for the user. For users in the same
 * Workspace organization `{user}` can also be the `id` for the person from
 * the People API, or the `id` for the user in the Directory API. For example,
 * if the People API Person profile ID for `user&#64;example.com` is `123456789`,
 * you can add the user to the space by setting the `membership.member.name`
 * to `users/user&#64;example.com` or `users/123456789`.
 *
 * For a named space or group chat, if the caller blocks, or is blocked
 * by some members, or doesn't have permission to add some members, then
 * those members aren't added to the created space.
 *
 * To create a direct message (DM) between the calling user and another human
 * user, specify exactly one membership to represent the human user. If
 * one user blocks the other, the request fails and the DM isn't created.
 *
 * To create a DM between the calling user and the calling app, set
 * `Space.singleUserBotDm` to `true` and don't specify any memberships. You
 * can only use this method to set up a DM with the calling app. To add the
 * calling app as a member of a space or an existing DM between two human
 * users, see
 * [Invite or add a user or app to a
 * space](https://developers.google.com/workspace/chat/create-members).
 *
 * If a DM already exists between two users, even when one user blocks the
 * other at the time a request is made, then the existing DM is returned.
 *
 * Spaces with threaded replies aren't supported. If you receive the error
 * message `ALREADY_EXISTS` when setting up a space, try a different
 * `displayName`. An existing space within the Google Workspace organization
 * might already use this display name.
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function set_up_space_sample(): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $space = new Space();
    $request = (new SetUpSpaceRequest())
        ->setSpace($space);

    // Call the API and handle any network failures.
    try {
        /** @var Space $response */
        $response = $chatServiceClient->setUpSpace($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END chat_v1_generated_ChatService_SetUpSpace_sync]
