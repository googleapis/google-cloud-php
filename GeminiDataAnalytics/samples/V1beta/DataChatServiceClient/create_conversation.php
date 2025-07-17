<?php
/*
 * Copyright 2025 Google LLC
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

// [START geminidataanalytics_v1beta_generated_DataChatService_CreateConversation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GeminiDataAnalytics\V1beta\Client\DataChatServiceClient;
use Google\Cloud\GeminiDataAnalytics\V1beta\Conversation;
use Google\Cloud\GeminiDataAnalytics\V1beta\CreateConversationRequest;

/**
 * Creates a new conversation to persist the conversation history. Each
 * conversation will have multiple messages associated with it.
 *
 * @param string $formattedParent           Parent value for CreateConversationRequest.
 *                                          Format: `projects/{project}/locations/{location}`
 *                                          Please see {@see DataChatServiceClient::locationName()} for help formatting this field.
 * @param string $conversationAgentsElement Agent(s) in the conversation.
 *                                          Currently, only one agent is supported. This field is repeated to allow
 *                                          for future support of multiple agents in a conversation.
 *                                          Format: `projects/{project}/locations/{location}/dataAgents/{agent}`
 */
function create_conversation_sample(
    string $formattedParent,
    string $conversationAgentsElement
): void {
    // Create a client.
    $dataChatServiceClient = new DataChatServiceClient();

    // Prepare the request message.
    $conversationAgents = [$conversationAgentsElement,];
    $conversation = (new Conversation())
        ->setAgents($conversationAgents);
    $request = (new CreateConversationRequest())
        ->setParent($formattedParent)
        ->setConversation($conversation);

    // Call the API and handle any network failures.
    try {
        /** @var Conversation $response */
        $response = $dataChatServiceClient->createConversation($request);
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
    $formattedParent = DataChatServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $conversationAgentsElement = '[AGENTS]';

    create_conversation_sample($formattedParent, $conversationAgentsElement);
}
// [END geminidataanalytics_v1beta_generated_DataChatService_CreateConversation_sync]
