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

// [START speech_v1_generated_Speech_Recognize_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognizeResponse;
use Google\Cloud\Speech\V1\SpeechClient;

/**
 * Performs synchronous speech recognition: receive results after all audio
 * has been sent and processed.
 *
 * @param string $configLanguageCode The language of the supplied audio as a
 *                                   [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt) language tag.
 *                                   Example: "en-US".
 *                                   See [Language
 *                                   Support](https://cloud.google.com/speech-to-text/docs/languages) for a list
 *                                   of the currently supported language codes.
 */
function recognize_sample(string $configLanguageCode): void
{
    // Create a client.
    $speechClient = new SpeechClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $config = (new RecognitionConfig())
        ->setLanguageCode($configLanguageCode);
    $audio = new RecognitionAudio();

    // Call the API and handle any network failures.
    try {
        /** @var RecognizeResponse $response */
        $response = $speechClient->recognize($config, $audio);
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
    $configLanguageCode = '[LANGUAGE_CODE]';

    recognize_sample($configLanguageCode);
}
// [END speech_v1_generated_Speech_Recognize_sync]
