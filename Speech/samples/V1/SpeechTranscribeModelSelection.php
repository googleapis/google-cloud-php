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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_transcribe_model_selection")
 */

// sample-metadata
//   title: Selecting a Transcription Model (Local File)
//   description: Transcribe a short audio file using a specified transcription model
//   usage: php samples/V1/SpeechTranscribeModelSelection.php [--local_file_path "resources/hello.wav"] [--model "phone_call"]
// [START speech_transcribe_model_selection]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;

/**
 * Transcribe a short audio file using a specified transcription model.
 *
 * @param string $localFilePath Path to local audio file, e.g. /path/audio.wav
 * @param string $model         The transcription model to use, e.g. video, phone_call, default
 *                              For a list of available transcription models, see:
 *                              https://cloud.google.com/speech-to-text/docs/transcription-model#transcription_models
 */
function sampleRecognize($localFilePath, $model)
{
    $speechClient = new SpeechClient();

    // $localFilePath = 'resources/hello.wav';
    // $model = 'phone_call';

    // The language of the supplied audio
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setModel($model);
    $config->setLanguageCode($languageCode);
    $content = file_get_contents($localFilePath);
    $audio = new RecognitionAudio();
    $audio->setContent($content);

    try {
        $response = $speechClient->recognize($config, $audio);
        foreach ($response->getResults() as $result) {
            // First alternative is the most probable result
            $alternative = $result->getAlternatives()[0];
            printf('Transcript: %s'.PHP_EOL, $alternative->getTranscript());
        }
    } finally {
        $speechClient->close();
    }
}
// [END speech_transcribe_model_selection]

$opts = [
    'local_file_path::',
    'model::',
];

$defaultOptions = [
    'local_file_path' => 'resources/hello.wav',
    'model' => 'phone_call',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$localFilePath = $options['local_file_path'];
$model = $options['model'];

sampleRecognize($localFilePath, $model);
