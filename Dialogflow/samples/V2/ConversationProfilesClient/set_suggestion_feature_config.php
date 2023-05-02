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

// [START dialogflow_v2_generated_ConversationProfiles_SetSuggestionFeatureConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\ConversationProfile;
use Google\Cloud\Dialogflow\V2\ConversationProfilesClient;
use Google\Cloud\Dialogflow\V2\HumanAgentAssistantConfig\SuggestionFeatureConfig;
use Google\Cloud\Dialogflow\V2\Participant\Role;
use Google\Rpc\Status;

/**
 * Adds or updates a suggestion feature in a conversation profile.
 * If the conversation profile contains the type of suggestion feature for
 * the participant role, it will update it. Otherwise it will insert the
 * suggestion feature.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [SetSuggestionFeatureConfigOperationMetadata][google.cloud.dialogflow.v2.SetSuggestionFeatureConfigOperationMetadata]
 * - `response`:
 * [ConversationProfile][google.cloud.dialogflow.v2.ConversationProfile]
 *
 * If a long running operation to add or update suggestion feature
 * config for the same conversation profile, participant role and suggestion
 * feature type exists, please cancel the existing long running operation
 * before sending such request, otherwise the request will be rejected.
 *
 * @param string $conversationProfile The Conversation Profile to add or update the suggestion feature
 *                                    config. Format: `projects/<Project ID>/locations/<Location
 *                                    ID>/conversationProfiles/<Conversation Profile ID>`.
 * @param int    $participantRole     The participant role to add or update the suggestion feature
 *                                    config. Only HUMAN_AGENT or END_USER can be used.
 */
function set_suggestion_feature_config_sample(
    string $conversationProfile,
    int $participantRole
): void {
    // Create a client.
    $conversationProfilesClient = new ConversationProfilesClient();

    // Prepare the request message.
    $suggestionFeatureConfig = new SuggestionFeatureConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $conversationProfilesClient->setSuggestionFeatureConfig(
            $conversationProfile,
            $participantRole,
            $suggestionFeatureConfig
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ConversationProfile $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $conversationProfile = '[CONVERSATION_PROFILE]';
    $participantRole = Role::ROLE_UNSPECIFIED;

    set_suggestion_feature_config_sample($conversationProfile, $participantRole);
}
// [END dialogflow_v2_generated_ConversationProfiles_SetSuggestionFeatureConfig_sync]
