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

// [START dialogflow_v2_generated_Conversations_SearchKnowledge_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\ConversationsClient;
use Google\Cloud\Dialogflow\V2\SearchKnowledgeResponse;
use Google\Cloud\Dialogflow\V2\TextInput;

/**
 * Get answers for the given query based on knowledge documents.
 *
 * @param string $queryText                    The UTF-8 encoded natural language text to be processed.
 *                                             Text length must not exceed 256 characters for virtual agent interactions.
 * @param string $queryLanguageCode            The language of this conversational query. See [Language
 *                                             Support](https://cloud.google.com/dialogflow/docs/reference/language)
 *                                             for a list of the currently supported language codes. Note that queries in
 *                                             the same session do not necessarily need to specify the same language.
 * @param string $formattedConversationProfile The conversation profile used to configure the search.
 *                                             Format: `projects/<Project ID>/locations/<Location
 *                                             ID>/conversationProfiles/<Conversation Profile ID>`. Please see
 *                                             {@see ConversationsClient::conversationProfileName()} for help formatting this field.
 */
function search_knowledge_sample(
    string $queryText,
    string $queryLanguageCode,
    string $formattedConversationProfile
): void {
    // Create a client.
    $conversationsClient = new ConversationsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $query = (new TextInput())
        ->setText($queryText)
        ->setLanguageCode($queryLanguageCode);

    // Call the API and handle any network failures.
    try {
        /** @var SearchKnowledgeResponse $response */
        $response = $conversationsClient->searchKnowledge($query, $formattedConversationProfile);
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
    $queryText = '[TEXT]';
    $queryLanguageCode = '[LANGUAGE_CODE]';
    $formattedConversationProfile = ConversationsClient::conversationProfileName(
        '[PROJECT]',
        '[CONVERSATION_PROFILE]'
    );

    search_knowledge_sample($queryText, $queryLanguageCode, $formattedConversationProfile);
}
// [END dialogflow_v2_generated_Conversations_SearchKnowledge_sync]
