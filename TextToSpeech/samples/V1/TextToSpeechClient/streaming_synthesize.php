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

// [START texttospeech_v1_generated_TextToSpeech_StreamingSynthesize_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\TextToSpeech\V1\Client\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\StreamingSynthesizeRequest;
use Google\Cloud\TextToSpeech\V1\StreamingSynthesizeResponse;

/**
 * Performs bidirectional streaming speech synthesis: receive audio while
 * sending text.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function streaming_synthesize_sample(): void
{
    // Create a client.
    $textToSpeechClient = new TextToSpeechClient();

    // Prepare the request message.
    $request = new StreamingSynthesizeRequest();

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $textToSpeechClient->streamingSynthesize();
        $stream->writeAll([$request,]);

        /** @var StreamingSynthesizeResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END texttospeech_v1_generated_TextToSpeech_StreamingSynthesize_sync]
