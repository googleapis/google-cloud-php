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

// [START chat_v1_generated_ChatService_GetSpaceEvent_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\GetSpaceEventRequest;
use Google\Apps\Chat\V1\SpaceEvent;

/**
 * Returns an event from a Google Chat space. The [event
 * payload](https://developers.google.com/workspace/chat/api/reference/rest/v1/spaces.spaceEvents#SpaceEvent.FIELDS.oneof_payload)
 * contains the most recent version of the resource that changed. For example,
 * if you request an event about a new message but the message was later
 * updated, the server returns the updated `Message` resource in the event
 * payload.
 *
 * Note: The `permissionSettings` field is not returned in the Space
 * object of the Space event data for this request.
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with an [authorization
 * scope](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes)
 * appropriate for reading the requested data:
 *
 * - `https://www.googleapis.com/auth/chat.spaces.readonly`
 * - `https://www.googleapis.com/auth/chat.spaces`
 * - `https://www.googleapis.com/auth/chat.messages.readonly`
 * - `https://www.googleapis.com/auth/chat.messages`
 * - `https://www.googleapis.com/auth/chat.messages.reactions.readonly`
 * - `https://www.googleapis.com/auth/chat.messages.reactions`
 * - `https://www.googleapis.com/auth/chat.memberships.readonly`
 * - `https://www.googleapis.com/auth/chat.memberships`
 *
 * To get an event, the authenticated user must be a member of the space.
 *
 * For an example, see [Get details about an
 * event from a Google Chat
 * space](https://developers.google.com/workspace/chat/get-space-event).
 *
 * @param string $formattedName The resource name of the space event.
 *
 *                              Format: `spaces/{space}/spaceEvents/{spaceEvent}`
 *                              Please see {@see ChatServiceClient::spaceEventName()} for help formatting this field.
 */
function get_space_event_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new GetSpaceEventRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SpaceEvent $response */
        $response = $chatServiceClient->getSpaceEvent($request);
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
    $formattedName = ChatServiceClient::spaceEventName('[SPACE]', '[SPACE_EVENT]');

    get_space_event_sample($formattedName);
}
// [END chat_v1_generated_ChatService_GetSpaceEvent_sync]
