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

// [START chat_v1_generated_ChatService_ListSpaceEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\ListSpaceEventsRequest;
use Google\Apps\Chat\V1\SpaceEvent;

/**
 * Lists events from a Google Chat space. For each event, the
 * [payload](https://developers.google.com/workspace/chat/api/reference/rest/v1/spaces.spaceEvents#SpaceEvent.FIELDS.oneof_payload)
 * contains the most recent version of the Chat resource. For example, if you
 * list events about new space members, the server returns `Membership`
 * resources that contain the latest membership details. If new members were
 * removed during the requested period, the event payload contains an empty
 * `Membership` resource.
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
 * To list events, the authenticated user must be a member of the space.
 *
 * For an example, see [List events from a Google Chat
 * space](https://developers.google.com/workspace/chat/list-space-events).
 *
 * @param string $formattedParent Resource name of the [Google Chat
 *                                space](https://developers.google.com/workspace/chat/api/reference/rest/v1/spaces)
 *                                where the events occurred.
 *
 *                                Format: `spaces/{space}`. Please see
 *                                {@see ChatServiceClient::spaceName()} for help formatting this field.
 * @param string $filter          A query filter.
 *
 *                                You must specify at least one event type (`event_type`)
 *                                using the has `:` operator. To filter by multiple event types, use the `OR`
 *                                operator. Omit batch event types in your filter. The request automatically
 *                                returns any related batch events. For example, if you filter by new
 *                                reactions
 *                                (`google.workspace.chat.reaction.v1.created`), the server also returns
 *                                batch new reactions events
 *                                (`google.workspace.chat.reaction.v1.batchCreated`). For a list of supported
 *                                event types, see the [`SpaceEvents` reference
 *                                documentation](https://developers.google.com/workspace/chat/api/reference/rest/v1/spaces.spaceEvents#SpaceEvent.FIELDS.event_type).
 *
 *                                Optionally, you can also filter by start time (`start_time`) and
 *                                end time (`end_time`):
 *
 *                                * `start_time`: Exclusive timestamp from which to start listing space
 *                                events.
 *                                You can list events that occurred up to 28 days ago. If unspecified, lists
 *                                space events from the past 28 days.
 *                                * `end_time`: Inclusive timestamp until which space events are listed.
 *                                If unspecified, lists events up to the time of the request.
 *
 *                                To specify a start or end time, use the equals `=` operator and format in
 *                                [RFC-3339](https://www.rfc-editor.org/rfc/rfc3339). To filter by both
 *                                `start_time` and `end_time`, use the `AND` operator.
 *
 *                                For example, the following queries are valid:
 *
 *                                ```
 *                                start_time="2023-08-23T19:20:33+00:00" AND
 *                                end_time="2023-08-23T19:21:54+00:00"
 *                                ```
 *                                ```
 *                                start_time="2023-08-23T19:20:33+00:00" AND
 *                                (event_types:"google.workspace.chat.space.v1.updated" OR
 *                                event_types:"google.workspace.chat.message.v1.created")
 *                                ```
 *
 *                                The following queries are invalid:
 *
 *                                ```
 *                                start_time="2023-08-23T19:20:33+00:00" OR
 *                                end_time="2023-08-23T19:21:54+00:00"
 *                                ```
 *                                ```
 *                                event_types:"google.workspace.chat.space.v1.updated" AND
 *                                event_types:"google.workspace.chat.message.v1.created"
 *                                ```
 *
 *                                Invalid queries are rejected by the server with an `INVALID_ARGUMENT`
 *                                error.
 */
function list_space_events_sample(string $formattedParent, string $filter): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new ListSpaceEventsRequest())
        ->setParent($formattedParent)
        ->setFilter($filter);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $chatServiceClient->listSpaceEvents($request);

        /** @var SpaceEvent $element */
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
    $filter = '[FILTER]';

    list_space_events_sample($formattedParent, $filter);
}
// [END chat_v1_generated_ChatService_ListSpaceEvents_sync]
