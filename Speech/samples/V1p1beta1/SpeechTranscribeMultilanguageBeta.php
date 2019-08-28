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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_transcribe_multilanguage_beta")
 */

// sample-metadata
//   title: Detecting language spoken automatically (Local File) (Beta)
//   description: Transcribe a short audio file with language detected from a list of possible languages
//   usage: php samples/V1p1beta1/SpeechTranscribeMultilanguageBeta.php [--local_file_path "resources/brooklyn_bridge.flac"]
// [START speech_transcribe_multilanguage_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;

/**
 * Transcribe a short audio file with language detected from a list of possible languages.
 *
 * @param string $localFilePath Path to local audio file, e.g. /path/audio.wav
 */
function sampleRecognize($localFilePath)
{
    $speechClient = new SpeechClient();

    // $localFilePath = 'resources/brooklyn_bridge.flac';

    // The language of the supplied audio. Even though additional languages are
    // provided by alternative_language_codes, a primary language is still required.
    $languageCode = 'fr';

    // Specify up to 3 additional languages as possible alternative languages
    // of the supplied audio.
    $alternativeLanguageCodesElement = 'es';
    $alternativeLanguageCodesElement2 = 'en';
    $alternativeLanguageCodes = [$alternativeLanguageCodesElement, $alternativeLanguageCodesElement2];
    $config = new RecognitionConfig();
    $config->setLanguageCode($languageCode);
    $config->setAlternativeLanguageCodes($alternativeLanguageCodes);
    $content = file_get_contents($localFilePath);
    $audio = new RecognitionAudio();
    $audio->setContent($content);

    try {
        $response = $speechClient->recognize($config, $audio);
        foreach ($response->getResults() as $result) {
            // The languageCode which was detected as the most likely being spoken in the audio
            printf('Detected language: %s'.PHP_EOL, $result->getLanguageCode());
            // First alternative is the most probable result
            $alternative = $result->getAlternatives()[0];
            printf('Transcript: %s'.PHP_EOL, $alternative->getTranscript());
        }
    } finally {
        $speechClient->close();
    }
}
// [END speech_transcribe_multilanguage_beta]

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
