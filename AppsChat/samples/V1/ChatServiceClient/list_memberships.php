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

// [START chat_v1_generated_ChatService_ListMemberships_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\ListMembershipsRequest;
use Google\Apps\Chat\V1\Membership;

/**
 * Lists memberships in a space. For an example, see [List users and Google
 * Chat apps in a
 * space](https://developers.google.com/workspace/chat/list-members). Listing
 * memberships with [app
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 * lists memberships in spaces that the Chat app has
 * access to, but excludes Chat app memberships,
 * including its own. Listing memberships with
 * [User
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * lists memberships in spaces that the authenticated user has access to.
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
 * @param string $formattedParent The resource name of the space for which to fetch a membership
 *                                list.
 *
 *                                Format: spaces/{space}
 *                                Please see {@see ChatServiceClient::spaceName()} for help formatting this field.
 */
function list_memberships_sample(string $formattedParent): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new ListMembershipsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $chatServiceClient->listMemberships($request);

        /** @var Membership $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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

    list_memberships_sample($formattedParent);
}
// [END chat_v1_generated_ChatService_ListMemberships_sync]
