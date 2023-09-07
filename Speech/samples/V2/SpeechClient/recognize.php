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

// [START speech_v2_generated_Speech_Recognize_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Speech\V2\RecognizeResponse;
use Google\Cloud\Speech\V2\SpeechClient;

/**
 * Performs synchronous Speech recognition: receive results after all audio
 * has been sent and processed.
 *
 * @param string $formattedRecognizer The name of the Recognizer to use during recognition. The
 *                                    expected format is
 *                                    `projects/{project}/locations/{location}/recognizers/{recognizer}`. The
 *                                    {recognizer} segment may be set to `_` to use an empty implicit Recognizer. Please see
 *                                    {@see SpeechClient::recognizerName()} for help formatting this field.
 */
function recognize_sample(string $formattedRecognizer): void
{
    // Create a client.
    $speechClient = new SpeechClient();

    // Call the API and handle any network failures.
    try {
        /** @var RecognizeResponse $response */
        $response = $speechClient->recognize($formattedRecognizer);
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
    $formattedRecognizer = SpeechClient::recognizerName('[PROJECT]', '[LOCATION]', '[RECOGNIZER]');

    recognize_sample($formattedRecognizer);
}
// [END speech_v2_generated_Speech_Recognize_sync]
