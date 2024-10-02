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

// [START chat_v1_generated_ChatService_GetSpace_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\GetSpaceRequest;
use Google\Apps\Chat\V1\Space;

/**
 * Returns details about a space. For an example, see
 * [Get details about a
 * space](https://developers.google.com/workspace/chat/get-spaces).
 *
 * Requires
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize).
 * Supports
 * [app
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app)
 * and [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user).
 *
 * @param string $formattedName Resource name of the space, in the form `spaces/{space}`.
 *
 *                              Format: `spaces/{space}`
 *                              Please see {@see ChatServiceClient::spaceName()} for help formatting this field.
 */
function get_space_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new GetSpaceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Space $response */
        $response = $chatServiceClient->getSpace($request);
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
    $formattedName = ChatServiceClient::spaceName('[SPACE]');

    get_space_sample($formattedName);
}
// [END chat_v1_generated_ChatService_GetSpace_sync]
