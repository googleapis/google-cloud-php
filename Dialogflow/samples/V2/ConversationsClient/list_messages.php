<?php
/*
 * Copyright 2022 Google LLC
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

// [START dialogflow_v2_generated_Conversations_ListMessages_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dialogflow\V2\ConversationsClient;
use Google\Cloud\Dialogflow\V2\Message;

/**
 * Lists messages that belong to a given conversation.
 * `messages` are ordered by `create_time` in descending order. To fetch
 * updates without duplication, send request with filter
 * `create_time_epoch_microseconds >
 * [first item's create_time of previous request]` and empty page_token.
 *
 * @param string $formattedParent The name of the conversation to list messages for.
 *                                Format: `projects/<Project ID>/locations/<Location
 *                                ID>/conversations/<Conversation ID>`
 *                                Please see {@see ConversationsClient::conversationName()} for help formatting this field.
 */
function list_messages_sample(string $formattedParent): void
{
    // Create a client.
    $conversationsClient = new ConversationsClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $conversationsClient->listMessages($formattedParent);

        /** @var Message $element */
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
    $formattedParent = ConversationsClient::conversationName('[PROJECT]', '[CONVERSATION]');

    list_messages_sample($formattedParent);
}
// [END dialogflow_v2_generated_Conversations_ListMessages_sync]
