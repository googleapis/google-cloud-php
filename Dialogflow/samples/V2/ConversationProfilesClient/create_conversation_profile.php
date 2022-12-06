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

// [START dialogflow_v2_generated_ConversationProfiles_CreateConversationProfile_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\ConversationProfile;
use Google\Cloud\Dialogflow\V2\ConversationProfilesClient;

/**
 * Creates a conversation profile in the specified project.
 *
 * [ConversationProfile.CreateTime][] and [ConversationProfile.UpdateTime][]
 * aren't populated in the response. You can retrieve them via
 * [GetConversationProfile][google.cloud.dialogflow.v2.ConversationProfiles.GetConversationProfile] API.
 *
 * @param string $formattedParent                The project to create a conversation profile for.
 *                                               Format: `projects/<Project ID>/locations/<Location ID>`. Please see
 *                                               {@see ConversationProfilesClient::projectName()} for help formatting this field.
 * @param string $conversationProfileDisplayName Human readable name for this profile. Max length 1024 bytes.
 */
function create_conversation_profile_sample(
    string $formattedParent,
    string $conversationProfileDisplayName
): void {
    // Create a client.
    $conversationProfilesClient = new ConversationProfilesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $conversationProfile = (new ConversationProfile())
        ->setDisplayName($conversationProfileDisplayName);

    // Call the API and handle any network failures.
    try {
        /** @var ConversationProfile $response */
        $response = $conversationProfilesClient->createConversationProfile(
            $formattedParent,
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
    $formattedParent = ConversationProfilesClient::projectName('[PROJECT]');
    $conversationProfileDisplayName = '[DISPLAY_NAME]';

    create_conversation_profile_sample($formattedParent, $conversationProfileDisplayName);
}
// [END dialogflow_v2_generated_ConversationProfiles_CreateConversationProfile_sync]
