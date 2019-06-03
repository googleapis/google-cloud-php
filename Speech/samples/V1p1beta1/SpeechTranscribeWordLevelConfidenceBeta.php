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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_transcribe_word_level_confidence_beta")
 */

// [START speech_transcribe_word_level_confidence_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;

/**
 * Print confidence level for individual words in a transcription of a short audio file.
 *
 * @param string $localFilePath Path to local audio file, e.g. /path/audio.wav
 */
function sampleRecognize($localFilePath)
{
    // [START speech_transcribe_word_level_confidence_beta_core]

    $speechClient = new SpeechClient();

    // $localFilePath = 'resources/brooklyn_bridge.flac';

    // When enabled, the first result returned by the API will include a list
    // of words and the confidence level for each of those words.
    $enableWordConfidence = true;

    // The language of the supplied audio
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setEnableWordConfidence($enableWordConfidence);
    $config->setLanguageCode($languageCode);
    $content = file_get_contents($localFilePath);
    $audio = new RecognitionAudio();
    $audio->setContent($content);

    try {
        $response = $speechClient->recognize($config, $audio);
        // The first result includes confidence levels per word
        $result = $response->getResults()[0];
        // First alternative is the most probable result
        $alternative = $result->getAlternatives()[0];
        printf('Transcript: %s'.PHP_EOL, $alternative->getTranscript());
        // Print the confidence level of each word
        foreach ($alternative->getWords() as $word) {
            printf('Word: %s'.PHP_EOL, $word->getWord());
            printf('Confidence: %s'.PHP_EOL, $word->getConfidence());
        }
    } finally {
        $speechClient->close();
    }

    // [END speech_transcribe_word_level_confidence_beta_core]
}
// [END speech_transcribe_word_level_confidence_beta]

$opts = [
    'local_file_path::',
];

$defaultOptions = [
    'local_file_path' => 'resources/brooklyn_bridge.flac',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$localFilePath = $options['local_file_path'];

sampleRecognize($localFilePath);
