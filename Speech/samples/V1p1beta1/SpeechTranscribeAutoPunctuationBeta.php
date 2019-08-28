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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_transcribe_auto_punctuation_beta")
 */

// sample-metadata
//   title: Getting punctuation in results (Local File) (Beta)
//   description: Transcribe a short audio file with punctuation
//   usage: php samples/V1p1beta1/SpeechTranscribeAutoPunctuationBeta.php [--local_file_path "resources/commercial_mono.wav"]
// [START speech_transcribe_auto_punctuation_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;

/**
 * Transcribe a short audio file with punctuation.
 *
 * @param string $localFilePath Path to local audio file, e.g. /path/audio.wav
 */
function sampleRecognize($localFilePath)
{
    $speechClient = new SpeechClient();

    // $localFilePath = 'resources/commercial_mono.wav';

    // When enabled, trascription results may include punctuation
    // (available for select languages).
    $enableAutomaticPunctuation = true;

    // The language of the supplied audio. Even though additional languages are
    // provided by alternative_language_codes, a primary language is still required.
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setEnableAutomaticPunctuation($enableAutomaticPunctuation);
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
// [END speech_transcribe_auto_punctuation_beta]

$opts = [
    'local_file_path::',
];

$defaultOptions = [
    'local_file_path' => 'resources/commercial_mono.wav',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$localFilePath = $options['local_file_path'];

sampleRecognize($localFilePath);
