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

// [START mediatranslation_v1beta1_generated_SpeechTranslationService_StreamingTranslateSpeech_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\MediaTranslation\V1beta1\SpeechTranslationServiceClient;
use Google\Cloud\MediaTranslation\V1beta1\StreamingTranslateSpeechRequest;
use Google\Cloud\MediaTranslation\V1beta1\StreamingTranslateSpeechResponse;

/**
 * Performs bidirectional streaming speech translation: receive results while
 * sending audio. This method is only available via the gRPC API (not REST).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function streaming_translate_speech_sample(): void
{
    // Create a client.
    $speechTranslationServiceClient = new SpeechTranslationServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $request = new StreamingTranslateSpeechRequest();

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $speechTranslationServiceClient->streamingTranslateSpeech();
        $stream->writeAll([$request,]);

        /** @var StreamingTranslateSpeechResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END mediatranslation_v1beta1_generated_SpeechTranslationService_StreamingTranslateSpeech_sync]
