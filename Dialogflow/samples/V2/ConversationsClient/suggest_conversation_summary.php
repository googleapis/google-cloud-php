<?php
/*
 * Copyright 2023 Google LLC
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

// [START dialogflow_v2_generated_Conversations_SuggestConversationSummary_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Client\ConversationsClient;
use Google\Cloud\Dialogflow\V2\SuggestConversationSummaryRequest;
use Google\Cloud\Dialogflow\V2\SuggestConversationSummaryResponse;

/**
 * Suggests summary for a conversation based on specific historical messages.
 * The range of the messages to be used for summary can be specified in the
 * request.
 *
 * @param string $formattedConversation The conversation to fetch suggestion for.
 *                                      Format: `projects/<Project ID>/locations/<Location
 *                                      ID>/conversations/<Conversation ID>`. Please see
 *                                      {@see ConversationsClient::conversationName()} for help formatting this field.
 */
function suggest_conversation_summary_sample(string $formattedConversation): void
{
    // Create a client.
    $conversationsClient = new ConversationsClient();

    // Prepare the request message.
    $request = (new SuggestConversationSummaryRequest())
        ->setConversation($formattedConversation);

    // Call the API and handle any network failures.
    try {
        /** @var SuggestConversationSummaryResponse $response */
        $response = $conversationsClient->suggestConversationSummary($request);
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
    $formattedConversation = ConversationsClient::conversationName('[PROJECT]', '[CONVERSATION]');

    suggest_conversation_summary_sample($formattedConversation);
}
// [END dialogflow_v2_generated_Conversations_SuggestConversationSummary_sync]
