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

// [START chat_v1_generated_ChatService_CompleteImportSpace_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\CompleteImportSpaceRequest;
use Google\Apps\Chat\V1\CompleteImportSpaceResponse;

/**
 * Completes the
 * [import process](https://developers.google.com/workspace/chat/import-data)
 * for the specified space and makes it visible to users.
 * Requires app authentication and domain-wide delegation. For more
 * information, see [Authorize Google Chat apps to import
 * data](https://developers.google.com/workspace/chat/authorize-import).
 *
 * @param string $formattedName Resource name of the import mode space.
 *
 *                              Format: `spaces/{space}`
 *                              Please see {@see ChatServiceClient::spaceName()} for help formatting this field.
 */
function complete_import_space_sample(string $formattedName): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new CompleteImportSpaceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CompleteImportSpaceResponse $response */
        $response = $chatServiceClient->completeImportSpace($request);
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

    complete_import_space_sample($formattedName);
}
// [END chat_v1_generated_ChatService_CompleteImportSpace_sync]
