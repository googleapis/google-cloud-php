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

// [START chat_v1_generated_ChatService_SearchMessages_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\SearchMessageResult;
use Google\Apps\Chat\V1\SearchMessagesRequest;

/**
 * Searches for messages in Google Chat that the calling user has access to.
 * Returns a list of messages matching the search criteria.
 *
 * To search across all spaces the user has access to, set `parent` to
 * `spaces/-`. Using any other value for `parent` results in an
 * `INVALID_ARGUMENT` error. The returned messages have their `name` field
 * populated with the full resource name, which includes the specific `space`
 * in which the message resides.
 *
 * This API doesn't return all message types. The types of messages listed
 * below aren't included in the response. Use
 * [ListMessages][google.chat.v1.ChatService.ListMessages] to list all
 * messages.
 *
 * - Private Messages that are visible to the authenticated user.
 * - Messages posted by Chat apps in spaces or group chats.
 * - Messages in a Chat app DM.
 * - Messages from blocked users.
 * - Messages in spaces that the caller has muted.
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following [authorization
 * scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.messages.readonly`
 * - `https://www.googleapis.com/auth/chat.messages`
 *
 * @param string $formattedParent The resource name of the space to search within.
 *
 *                                To search across all spaces the user has access to, set this field to
 *                                `spaces/-`. Using any other value for `parent` results in an
 *                                `INVALID_ARGUMENT` error.
 *
 *                                To limit the search to one or more spaces, use `space.name` or
 *                                `space.display_name` in the `filter`. Please see
 *                                {@see ChatServiceClient::spaceName()} for help formatting this field.
 * @param string $filter          A search query.
 *
 *                                The query can specify one or more search keywords, which are used to filter
 *                                the results,
 *
 *                                You can also filter the results using the following message fields:
 *
 *                                - `create_time`: Accepts a timestamp in
 *                                [RFC-3339](https://www.rfc-editor.org/rfc/rfc3339) format and the
 *                                supported comparison operators are: `<` and `>=`.
 *                                - `sender.name`: The resource name of the sender (`users/{user}`). Only
 *                                supports `=`. You can use the e-mail as an alias for `{user}`. For
 *                                example, `users/example&#64;gmail.com`, where `example&#64;gmail.com` is the
 *                                e-mail of the Google Chat user.
 *                                - `space.name`: The resource name of the space where the message is posted.
 *                                (`spaces/{space}`). Only supports `=`. If this filter is not set, the
 *                                search is performed across all direct messages and spaces the user has
 *                                access to as a space member.
 *                                - `space.display_name`: Supports the operator `:` (has) and filters spaces
 *                                based on a partial match of their display name. Results are limited to
 *                                the top five space matches. For example, `space.display_name:Project`
 *                                searches for messages in the top five spaces that contain the word
 *                                "Project" in their display names.
 *                                - `attachment`: Supports the operator `:*` (has any) to check for the
 *                                presence of attachments. If `attachment:*` is specified, only messages
 *                                that have at least one attachment are returned.
 *                                - `annotations.user_mentions.user.name`: The resource name of the mentioned
 *                                user (`users/{user}`). Only supports `:` (has). For example:
 *                                `annotations.user_mentions.user.name:"users/1234567890"` returns only
 *                                messages that contain a mention to the specified user. Alternatively, the
 *                                alias `me` can be used to filter for messages that mention the caller
 *                                user, for example: `annotations.user_mentions.user.name:users/me`. You
 *                                can also use the e-mail as an alias for `{user}`, for example,
 *                                `users/example&#64;gmail.com`.
 *
 *                                For advanced filtering, the following functions are also available:
 *
 *                                - `has_link()`: Returns only messages that have at least one hyperlink in
 *                                the message text.
 *                                - `is_unread()`: Filters out messages that have been read by the calling
 *                                user.
 *
 *                                Using the `space.display_name` filter requires that the calling credentials
 *                                include one of the following [authorization
 *                                scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 *                                - `https://www.googleapis.com/auth/chat.spaces.readonly`
 *                                - `https://www.googleapis.com/auth/chat.spaces`
 *
 *                                Using the `is_unread()` filter requires that the calling credentials
 *                                include one of the following [authorization
 *                                scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 *                                - `https://www.googleapis.com/auth/chat.users.readstate.readonly`
 *                                - `https://www.googleapis.com/auth/chat.users.readstate`
 *
 *
 *                                Across different fields, only `AND` operators are supported. A valid
 *                                example is `sender.name = "users/1234567890" AND is_unread()`. The word
 *                                `AND` is optional and is implied if omitted. For example, `sender.name =
 *                                "users/1234567890" is_unread()` is valid and is equivalent to the previous
 *                                example. An invalid example is `sender.name = "users/1234567890" OR
 *                                is_unread()` because `OR` is not supported between different fields.
 *
 *                                Among the same field:
 *
 *                                - `create_time` supports only `AND`, and can only be used to represent
 *                                an interval, such as `create_time >= "2022-01-01T00:00:00+00:00" AND
 *                                create_time < "2023-01-01T00:00:00+00:00"`.
 *                                - `sender.name` supports only the `OR` operator, for example:
 *                                `sender.name = "users/1234567890" OR sender.name = "users/0987654321"`.
 *                                - `space.name` supports only the `OR` operator, for example:
 *                                `space.name = "spaces/ABCDEFGH" OR space.name = "spaces/QWERTYUI"`.
 *                                - `space.display_name` supports the operators `AND` and `OR`, but not a
 *                                mix of both. For example:
 *                                `space.display_name:Project AND space.display_name:Tasks` returns
 *                                messages that are in spaces with display names containing both `Project`
 *                                and `Tasks`, whereas
 *                                `space.display_name:Project OR space.display_name:Tasks` returns messages
 *                                that are in spaces with display names containing either `Project` or
 *                                `Tasks` or both.
 *                                - `annotations.user_mentions.user.name` supports the operators `AND` and
 *                                `OR`, but not a mix of both. For example:
 *                                `annotations.user_mentions.user.name:"users/1234567890" AND
 *                                annotations.user_mentions.user.name:"users/0987654321"` returns only
 *                                messages that mentions both users, whereas
 *                                `annotations.user_mentions.user.name:"users/1234567890" OR
 *                                annotations.user_mentions.user.name:"users/0987654321"` returns messages
 *                                that mention either user or both.
 *
 *                                Parentheses are required to disambiguate operator precedence when combining
 *                                `AND` and `OR` operators in the same query. For example:
 *                                `(sender.name="users/me" OR sender.name="users/123456") AND is_unread()`.
 *                                Otherwise, parentheses are optional.
 *
 *                                The following example queries are valid:
 *
 *                                ```
 *                                "Pending reports" AND create_time >= "2023-01-01T00:00:00Z"
 *
 *                                sender.name = "users/example&#64;gmail.com"
 *
 *                                annotations.user_mentions.user.name:"users/0987654321"
 *
 *                                attachment:* AND space.name = "spaces/ABCDEFGH"
 *
 *                                tasks AND is_unread() AND sender.name = "users/1234567890"
 *
 *                                "things to do" "urgent"
 *
 *                                (sender.name = "users/1234567890")
 *                                AND (create_time < "2023-05-01T00:00:00Z")
 *
 *                                tasks AND space.name = "spaces/ABCDEFGH" AND has_link()
 *
 *                                "project one" is_unread()
 *
 *                                space.display_name:Project tasks
 *                                ```
 *
 *                                The maximum query length is 1,000 characters.
 *
 *                                Invalid queries are rejected by the server with an `INVALID_ARGUMENT`
 *                                error.
 */
function search_messages_sample(string $formattedParent, string $filter): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new SearchMessagesRequest())
        ->setParent($formattedParent)
        ->setFilter($filter);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $chatServiceClient->searchMessages($request);

        /** @var SearchMessageResult $element */
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

    search_messages_sample($formattedParent, $filter);
}
// [END chat_v1_generated_ChatService_SearchMessages_sync]
