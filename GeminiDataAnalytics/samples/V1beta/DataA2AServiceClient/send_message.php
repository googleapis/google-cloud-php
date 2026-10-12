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

// [START geminidataanalytics_v1beta_generated_DataA2AService_SendMessage_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GeminiDataAnalytics\V1beta\A2AMessage;
use Google\Cloud\GeminiDataAnalytics\V1beta\Client\DataA2AServiceClient;
use Google\Cloud\GeminiDataAnalytics\V1beta\SendMessageRequest;
use Google\Cloud\GeminiDataAnalytics\V1beta\SendMessageResponse;

/**
 * Send a message to the agent. This is a blocking call that will return the
 * task once it is completed.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function send_message_sample(): void
{
    // Create a client.
    $dataA2AServiceClient = new DataA2AServiceClient();

    // Prepare the request message.
    $message = new A2AMessage();
    $request = (new SendMessageRequest())
        ->setMessage($message);

    // Call the API and handle any network failures.
    try {
        /** @var SendMessageResponse $response */
        $response = $dataA2AServiceClient->sendMessage($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END geminidataanalytics_v1beta_generated_DataA2AService_SendMessage_sync]
