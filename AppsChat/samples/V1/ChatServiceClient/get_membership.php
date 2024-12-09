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

// [START chat_v1_generated_ChatService_GetMembership_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\GetMembershipRequest;
use Google\Apps\Chat\V1\Membership;

/**
 * Returns details about a membership. For an example, see
 * [Get details about a user's or Google Chat app's
 * membership](https://developers.google.com/workspace/chat/get-members).
 *
 * Supports the following types of
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize):
 *
 * - [App
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 *
 * - [User
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * You can authenticate and authorize this method with administrator
 * privileges by setting the `use_admin_access` field in the request.
 *
 * @param string $formattedName Resource name of the membership to retrieve.
 *
 *                              To get the app's own membership [by using user
 *                              authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user),
 *                              you can optionally use `spaces/{space}/members/app`.
 *
 *                              Format: `spaces/{space}/members/{member}` or `spaces/{space}/members/app`
 *
 *                              You can use the user's email as an alias for `{member}`. For example,
 *                              `spaces/{space}/members/example&#64;gmail.com` where `example&#64;gmail.com` is the
 *                              email of the Google Chat user. Please see
 *                              {@see ChatServiceClient::membershipName()} for help formatting this field.
 */
function get_membership_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new GetMembershipRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Membership $response */
        $response = $chatServiceClient->getMembership($request);
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

    get_membership_sample($formattedName);
}
// [END chat_v1_generated_ChatService_GetMembership_sync]
