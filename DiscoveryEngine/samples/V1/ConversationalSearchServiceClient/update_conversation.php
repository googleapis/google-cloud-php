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

// [START discoveryengine_v1_generated_ConversationalSearchService_UpdateConversation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\ConversationalSearchServiceClient;
use Google\Cloud\DiscoveryEngine\V1\Conversation;
use Google\Cloud\DiscoveryEngine\V1\UpdateConversationRequest;

/**
 * Updates a Conversation.
 *
 * [Conversation][google.cloud.discoveryengine.v1.Conversation] action type
 * cannot be changed. If the
 * [Conversation][google.cloud.discoveryengine.v1.Conversation] to update does
 * not exist, a NOT_FOUND error is returned.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_conversation_sample(): void
{
    // Create a client.
    $conversationalSearchServiceClient = new ConversationalSearchServiceClient();

    // Prepare the request message.
    $conversation = new Conversation();
    $request = (new UpdateConversationRequest())
        ->setConversation($conversation);

    // Call the API and handle any network failures.
    try {
        /** @var Conversation $response */
        $response = $conversationalSearchServiceClient->updateConversation($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END discoveryengine_v1_generated_ConversationalSearchService_UpdateConversation_sync]
