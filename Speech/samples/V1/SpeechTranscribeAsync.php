<?php
/*
 * Copyright 2019 Google LLC
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
 * DO NOT EDIT! This is a generated sample ("LongRunningRequest",  "speech_transcribe_async")
 */

// sample-metadata
//   title: Transcribe Audio File using Long Running Operation (Local File) (LRO)
//   description: Transcribe a long audio file using asynchronous speech recognition
//   usage: php samples/V1/SpeechTranscribeAsync.php [--local_file_path "resources/brooklyn_bridge.raw"]
// [START speech_transcribe_async]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

/**
 * Transcribe a long audio file using asynchronous speech recognition.
 *
 * @param string $localFilePath Path to local audio file, e.g. /path/audio.wav
 */
function sampleLongRunningRecognize($localFilePath)
{
    $speechClient = new SpeechClient();

    // $localFilePath = 'resources/brooklyn_bridge.raw';

    // The language of the supplied audio
    $languageCode = 'en-US';

    // Sample rate in Hertz of the audio data sent
    $sampleRateHertz = 16000;

    // Encoding of audio data sent. This sample sets this explicitly.
    // This field is optional for FLAC and WAV audio formats.
    $encoding = AudioEncoding::LINEAR16;
    $config = new RecognitionConfig();
    $config->setLanguageCode($languageCode);
    $config->setSampleRateHertz($sampleRateHertz);
    $config->setEncoding($encoding);
    $content = file_get_contents($localFilePath);
    $audio = new RecognitionAudio();
    $audio->setContent($content);

    try {
        $operationResponse = $speechClient->longRunningRecognize($config, $audio);
        $operationResponse->pollUntilComplete();
        if ($operationResponse->operationSucceeded()) {
            $response = $operationResponse->getResult();
            foreach ($response->getResults() as $result) {
                // First alternative is the most probable result
                $alternative = $result->getAlternatives()[0];
                printf('Transcript: %s'.PHP_EOL, $alternative->getTranscript());
            }
        } else {
            $error = $operationResponse->getError();
            // handleError($error)
        }
    } finally {
        $speechClient->close();
    }
}
// [END speech_transcribe_async]

$opts = [
    'local_file_path::',
];

$defaultOptions = [
    'local_file_path' => 'resources/brooklyn_bridge.raw',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$localFilePath = $options['local_file_path'];

sampleLongRunningRecognize($localFilePath);
