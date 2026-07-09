<?php
/*
 * Copyright 2026 Google LLC
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

// [START chat_v1_generated_ChatService_UpdateSection_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\Section;
use Google\Apps\Chat\V1\Section\SectionType;
use Google\Apps\Chat\V1\UpdateSectionRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates a section. Only sections of type `CUSTOM_SECTION` can be updated.
 * For details, see [Create and organize sections in Google
 * Chat](https://support.google.com/chat/answer/16059854).
 *
 * Requires [user
 * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user)
 * with the [authorization
 * scope](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes):
 *
 * - `https://www.googleapis.com/auth/chat.users.sections`
 *
 * @param int $sectionType The type of the section.
 */
function update_section_sample(int $sectionType): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $section = (new Section())
        ->setType($sectionType);
    $updateMask = new FieldMask();
    $request = (new UpdateSectionRequest())
        ->setSection($section)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Section $response */
        $response = $chatServiceClient->updateSection($request);
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
    $sectionType = SectionType::SECTION_TYPE_UNSPECIFIED;

    update_section_sample($sectionType);
}
// [END chat_v1_generated_ChatService_UpdateSection_sync]
