<?php
/*
 * Copyright 2024 Google LLC
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

// [START chat_v1_generated_ChatService_CreateReaction_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\ChatServiceClient;
use Google\Apps\Chat\V1\Reaction;

/**
 * Creates a reaction and adds it to a message. For an example, see
 * [Create a
 * reaction](https://developers.google.com/chat/api/guides/v1/reactions/create).
 * Requires [user
 * authentication](https://developers.google.com/chat/api/guides/auth/users).
 * Only unicode emoji are supported.
 *
 * @param string $formattedParent The message where the reaction is created.
 *
 *                                Format: `spaces/{space}/messages/{message}`
 *                                Please see {@see ChatServiceClient::messageName()} for help formatting this field.
 */
function create_reaction_sample(string $formattedParent): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $reaction = new Reaction();

    // Call the API and handle any network failures.
    try {
        /** @var Reaction $response */
        $response = $chatServiceClient->createReaction($formattedParent, $reaction);
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
    $formattedParent = ChatServiceClient::messageName('[SPACE]', '[MESSAGE]');

    create_reaction_sample($formattedParent);
}
// [END chat_v1_generated_ChatService_CreateReaction_sync]
