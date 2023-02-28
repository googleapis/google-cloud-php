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

// [START dialogflow_v2_generated_Conversations_CreateConversation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Conversation;
use Google\Cloud\Dialogflow\V2\ConversationsClient;

/**
 * Creates a new conversation. Conversations are auto-completed after 24
 * hours.
 *
 * Conversation Lifecycle:
 * There are two stages during a conversation: Automated Agent Stage and
 * Assist Stage.
 *
 * For Automated Agent Stage, there will be a dialogflow agent responding to
 * user queries.
 *
 * For Assist Stage, there's no dialogflow agent responding to user queries.
 * But we will provide suggestions which are generated from conversation.
 *
 * If [Conversation.conversation_profile][google.cloud.dialogflow.v2.Conversation.conversation_profile] is configured for a dialogflow
 * agent, conversation will start from `Automated Agent Stage`, otherwise, it
 * will start from `Assist Stage`. And during `Automated Agent Stage`, once an
 * [Intent][google.cloud.dialogflow.v2.Intent] with [Intent.live_agent_handoff][google.cloud.dialogflow.v2.Intent.live_agent_handoff] is triggered, conversation
 * will transfer to Assist Stage.
 *
 * @param string $formattedParent                          Resource identifier of the project creating the conversation.
 *                                                         Format: `projects/<Project ID>/locations/<Location ID>`. Please see
 *                                                         {@see ConversationsClient::projectName()} for help formatting this field.
 * @param string $formattedConversationConversationProfile The Conversation Profile to be used to configure this
 *                                                         Conversation. This field cannot be updated.
 *                                                         Format: `projects/<Project ID>/locations/<Location
 *                                                         ID>/conversationProfiles/<Conversation Profile ID>`. Please see
 *                                                         {@see ConversationsClient::conversationProfileName()} for help formatting this field.
 */
function create_conversation_sample(
    string $formattedParent,
    string $formattedConversationConversationProfile
): void {
    // Create a client.
    $conversationsClient = new ConversationsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $conversation = (new Conversation())
        ->setConversationProfile($formattedConversationConversationProfile);

    // Call the API and handle any network failures.
    try {
        /** @var Conversation $response */
        $response = $conversationsClient->createConversation($formattedParent, $conversation);
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
    $formattedParent = ConversationsClient::projectName('[PROJECT]');
    $formattedConversationConversationProfile = ConversationsClient::conversationProfileName(
        '[PROJECT]',
        '[CONVERSATION_PROFILE]'
    );

    create_conversation_sample($formattedParent, $formattedConversationConversationProfile);
}
// [END dialogflow_v2_generated_Conversations_CreateConversation_sync]
