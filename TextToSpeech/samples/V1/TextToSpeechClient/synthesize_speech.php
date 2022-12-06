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

// [START texttospeech_v1_generated_TextToSpeech_SynthesizeSpeech_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechResponse;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

/**
 * Synthesizes speech synchronously: receive results after all text input
 * has been processed.
 *
 * @param string $voiceLanguageCode        The language (and potentially also the region) of the voice expressed as a
 *                                         [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt) language tag, e.g.
 *                                         "en-US". This should not include a script tag (e.g. use
 *                                         "cmn-cn" rather than "cmn-Hant-cn"), because the script will be inferred
 *                                         from the input provided in the SynthesisInput.  The TTS service
 *                                         will use this parameter to help choose an appropriate voice.  Note that
 *                                         the TTS service may choose a voice with a slightly different language code
 *                                         than the one selected; it may substitute a different region
 *                                         (e.g. using en-US rather than en-CA if there isn't a Canadian voice
 *                                         available), or even a different language, e.g. using "nb" (Norwegian
 *                                         Bokmal) instead of "no" (Norwegian)".
 * @param int    $audioConfigAudioEncoding The format of the audio byte stream.
 */
function synthesize_speech_sample(string $voiceLanguageCode, int $audioConfigAudioEncoding): void
{
    // Create a client.
    $textToSpeechClient = new TextToSpeechClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $input = new SynthesisInput();
    $voice = (new VoiceSelectionParams())
        ->setLanguageCode($voiceLanguageCode);
    $audioConfig = (new AudioConfig())
        ->setAudioEncoding($audioConfigAudioEncoding);

    // Call the API and handle any network failures.
    try {
        /** @var SynthesizeSpeechResponse $response */
        $response = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
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
    $voiceLanguageCode = '[LANGUAGE_CODE]';
    $audioConfigAudioEncoding = AudioEncoding::AUDIO_ENCODING_UNSPECIFIED;

    synthesize_speech_sample($voiceLanguageCode, $audioConfigAudioEncoding);
}
// [END texttospeech_v1_generated_TextToSpeech_SynthesizeSpeech_sync]
