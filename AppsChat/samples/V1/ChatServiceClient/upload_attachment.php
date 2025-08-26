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

// [START chat_v1_generated_ChatService_UploadAttachment_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\UploadAttachmentRequest;
use Google\Apps\Chat\V1\UploadAttachmentResponse;

/**
 * Uploads an attachment. For an example, see
 * [Upload media as a file
 * attachment](https://developers.google.com/workspace/chat/upload-media-attachments).
 *
 * Requires user
 * [authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with one of the following [authorization
 * scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.messages.create`
 * - `https://www.googleapis.com/auth/chat.messages`
 * - `https://www.googleapis.com/auth/chat.import` (import mode spaces only)
 *
 * You can upload attachments up to 200 MB. Certain file types aren't
 * supported. For details, see [File types blocked by Google
 * Chat](https://support.google.com/chat/answer/7651457?&co=GENIE.Platform%3DDesktop#File%20types%20blocked%20in%20Google%20Chat).
 *
 * @param string $formattedParent Resource name of the Chat space in which the attachment is
 *                                uploaded. Format "spaces/{space}". Please see
 *                                {@see ChatServiceClient::spaceName()} for help formatting this field.
 * @param string $filename        The filename of the attachment, including the file extension.
 */
function upload_attachment_sample(string $formattedParent, string $filename): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new UploadAttachmentRequest())
        ->setParent($formattedParent)
        ->setFilename($filename);

    // Call the API and handle any network failures.
    try {
        /** @var UploadAttachmentResponse $response */
        $response = $chatServiceClient->uploadAttachment($request);
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
    $formattedParent = ChatServiceClient::spaceName('[SPACE]');
    $filename = '[FILENAME]';

    upload_attachment_sample($formattedParent, $filename);
}
// [END chat_v1_generated_ChatService_UploadAttachment_sync]
