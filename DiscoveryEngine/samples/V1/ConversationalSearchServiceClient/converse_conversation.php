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

// [START discoveryengine_v1_generated_ConversationalSearchService_ConverseConversation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\ConversationalSearchServiceClient;
use Google\Cloud\DiscoveryEngine\V1\ConverseConversationRequest;
use Google\Cloud\DiscoveryEngine\V1\ConverseConversationResponse;
use Google\Cloud\DiscoveryEngine\V1\TextInput;

/**
 * Converses a conversation.
 *
 * @param string $formattedName The resource name of the Conversation to get. Format:
 *                              `projects/{project_number}/locations/{location_id}/collections/{collection}/dataStores/{data_store_id}/conversations/{conversation_id}`.
 *                              Use
 *                              `projects/{project_number}/locations/{location_id}/collections/{collection}/dataStores/{data_store_id}/conversations/-`
 *                              to activate auto session mode, which automatically creates a new
 *                              conversation inside a ConverseConversation session. Please see
 *                              {@see ConversationalSearchServiceClient::conversationName()} for help formatting this field.
 */
function converse_conversation_sample(string $formattedName): void
{
    // Create a client.
    $conversationalSearchServiceClient = new ConversationalSearchServiceClient();

    // Prepare the request message.
    $query = new TextInput();
    $request = (new ConverseConversationRequest())
        ->setName($formattedName)
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var ConverseConversationResponse $response */
        $response = $conversationalSearchServiceClient->converseConversation($request);
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
    $formattedName = ConversationalSearchServiceClient::conversationName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]',
        '[CONVERSATION]'
    );

    converse_conversation_sample($formattedName);
}
// [END discoveryengine_v1_generated_ConversationalSearchService_ConverseConversation_sync]
