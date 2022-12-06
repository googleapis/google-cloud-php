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

// [START speech_v2_generated_Speech_UpdateRecognizer_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Speech\V2\Recognizer;
use Google\Cloud\Speech\V2\SpeechClient;
use Google\Rpc\Status;

/**
 * Updates the [Recognizer][google.cloud.speech.v2.Recognizer].
 *
 * @param string $recognizerModel                Which model to use for recognition requests. Select the model
 *                                               best suited to your domain to get best results.
 *
 *                                               Supported models:
 *
 *                                               - `latest_long`
 *
 *                                               Best for long form content like media or conversation.
 *
 *                                               - `latest_short`
 *
 *                                               Best for short form content like commands or single shot directed speech.
 *                                               When using this model, the service will stop transcribing audio after the
 *                                               first utterance is detected and completed.
 *
 *                                               When using this model,
 *                                               [SEPARATE_RECOGNITION_PER_CHANNEL][google.cloud.speech.v2.RecognitionFeatures.MultiChannelMode.SEPARATE_RECOGNITION_PER_CHANNEL]
 *                                               is not supported; multi-channel audio is accepted, but only the first
 *                                               channel will be processed and transcribed.
 * @param string $recognizerLanguageCodesElement The language of the supplied audio as a
 *                                               [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt) language tag.
 *
 *                                               Supported languages:
 *
 *                                               - `en-US`
 *
 *                                               - `en-GB`
 *
 *                                               - `fr-FR`
 *
 *                                               If additional languages are provided, recognition result will contain
 *                                               recognition in the most likely language detected. The recognition result
 *                                               will include the language tag of the language detected in the audio.
 *                                               When you create or update a Recognizer, these values are
 *                                               stored in normalized BCP-47 form. For example, "en-us" is stored as
 *                                               "en-US".
 */
function update_recognizer_sample(
    string $recognizerModel,
    string $recognizerLanguageCodesElement
): void {
    // Create a client.
    $speechClient = new SpeechClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $recognizerLanguageCodes = [$recognizerLanguageCodesElement,];
    $recognizer = (new Recognizer())
        ->setModel($recognizerModel)
        ->setLanguageCodes($recognizerLanguageCodes);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $speechClient->updateRecognizer($recognizer);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Recognizer $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $recognizerModel = '[MODEL]';
    $recognizerLanguageCodesElement = '[LANGUAGE_CODES]';

    update_recognizer_sample($recognizerModel, $recognizerLanguageCodesElement);
}
// [END speech_v2_generated_Speech_UpdateRecognizer_sync]
