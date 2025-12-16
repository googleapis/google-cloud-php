<?php
/*
 * Copyright 2025 Google LLC
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

// [START geminidataanalytics_v1beta_generated_DataChatService_Chat_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\GeminiDataAnalytics\V1beta\ChatRequest;
use Google\Cloud\GeminiDataAnalytics\V1beta\Client\DataChatServiceClient;
use Google\Cloud\GeminiDataAnalytics\V1beta\Message;

/**
 * Answers a data question by generating a stream of
 * [Message][google.cloud.geminidataanalytics.v1alpha.Message] objects.
 *
 * @param string $parent The parent value for chat request.
 *                       Pattern: `projects/{project}/locations/{location}`
 */
function chat_sample(string $parent): void
{
    // Create a client.
    $dataChatServiceClient = new DataChatServiceClient();

    // Prepare the request message.
    $messages = [new Message()];
    $request = (new ChatRequest())
        ->setParent($parent)
        ->setMessages($messages);

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $dataChatServiceClient->chat($request);

        /** @var Message $element */
        foreach ($stream->readAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $parent = '[PARENT]';

    chat_sample($parent);
}
// [END geminidataanalytics_v1beta_generated_DataChatService_Chat_sync]
