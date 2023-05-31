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

// [START dialogflow_v2_generated_Conversations_GenerateStatelessSummary_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\ConversationProfile;
use Google\Cloud\Dialogflow\V2\ConversationsClient;
use Google\Cloud\Dialogflow\V2\GenerateStatelessSummaryRequest\MinimalConversation;
use Google\Cloud\Dialogflow\V2\GenerateStatelessSummaryResponse;
use Google\Cloud\Dialogflow\V2\Message;

/**
 * Generates and returns a summary for a conversation that does not have a
 * resource created for it.
 *
 * @param string $statelessConversationMessagesContent The message content.
 * @param string $formattedStatelessConversationParent The parent resource to charge for the Summary's generation.
 *                                                     Format: `projects/<Project ID>/locations/<Location ID>`. Please see
 *                                                     {@see ConversationsClient::locationName()} for help formatting this field.
 * @param string $conversationProfileDisplayName       Human readable name for this profile. Max length 1024 bytes.
 */
function generate_stateless_summary_sample(
    string $statelessConversationMessagesContent,
    string $formattedStatelessConversationParent,
    string $conversationProfileDisplayName
): void {
    // Create a client.
    $conversationsClient = new ConversationsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $message = (new Message())
        ->setContent($statelessConversationMessagesContent);
    $statelessConversationMessages = [$message,];
    $statelessConversation = (new MinimalConversation())
        ->setMessages($statelessConversationMessages)
        ->setParent($formattedStatelessConversationParent);
    $conversationProfile = (new ConversationProfile())
        ->setDisplayName($conversationProfileDisplayName);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateStatelessSummaryResponse $response */
        $response = $conversationsClient->generateStatelessSummary(
            $statelessConversation,
            $conversationProfile
        );
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
    $statelessConversationMessagesContent = '[CONTENT]';
    $formattedStatelessConversationParent = ConversationsClient::locationName(
        '[PROJECT]',
        '[LOCATION]'
    );
    $conversationProfileDisplayName = '[DISPLAY_NAME]';

    generate_stateless_summary_sample(
        $statelessConversationMessagesContent,
        $formattedStatelessConversationParent,
        $conversationProfileDisplayName
    );
}
// [END dialogflow_v2_generated_Conversations_GenerateStatelessSummary_sync]
