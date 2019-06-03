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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_transcribe_enhanced_model")
 */

// [START speech_transcribe_enhanced_model]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;

/**
 * Transcribe a short audio file using an enhanced model.
 *
 * @param string $localFilePath Path to local audio file, e.g. /path/audio.wav
 */
function sampleRecognize($localFilePath)
{
    // [START speech_transcribe_enhanced_model_core]

    $speechClient = new SpeechClient();

    // $localFilePath = 'resources/hello.wav';

    // The enhanced model to use, e.g. phone_call
    // Currently phone_call is the only model available as an enhanced model.
    $model = 'phone_call';

    // Use an enhanced model for speech recognition (when set to true).
    // Project must be eligible for requesting enhanced models.
    // Enhanced speech models require that you opt-in to data logging.
    $useEnhanced = true;

    // The language of the supplied audio
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setModel($model);
    $config->setUseEnhanced($useEnhanced);
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

    // [END speech_transcribe_enhanced_model_core]
}
// [END speech_transcribe_enhanced_model]

$opts = [
    'local_file_path::',
];

$defaultOptions = [
    'local_file_path' => 'resources/hello.wav',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$localFilePath = $options['local_file_path'];

sampleRecognize($localFilePath);
