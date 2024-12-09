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

// [START chat_v1_generated_ChatService_GetAttachment_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Attachment;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\GetAttachmentRequest;

/**
 * Gets the metadata of a message attachment. The attachment data is fetched
 * using the [media
 * API](https://developers.google.com/workspace/chat/api/reference/rest/v1/media/download).
 * For an example, see
 * [Get metadata about a message
 * attachment](https://developers.google.com/workspace/chat/get-media-attachments).
 * Requires [app
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-app).
 *
 * @param string $formattedName Resource name of the attachment, in the form
 *                              `spaces/{space}/messages/{message}/attachments/{attachment}`. Please see
 *                              {@see ChatServiceClient::attachmentName()} for help formatting this field.
 */
function get_attachment_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new GetAttachmentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Attachment $response */
        $response = $chatServiceClient->getAttachment($request);
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
    $formattedName = ChatServiceClient::attachmentName('[SPACE]', '[MESSAGE]', '[ATTACHMENT]');

    get_attachment_sample($formattedName);
}
// [END chat_v1_generated_ChatService_GetAttachment_sync]
