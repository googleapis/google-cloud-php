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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_quickstart_beta")
 */

// sample-metadata
//   title:
//   description: Performs synchronous speech recognition on an audio file.
//   usage: php samples/V1p1beta1/SpeechQuickstartBeta.php [--sample_rate_hertz 44100] [--language_code "en-US"] [--uri_path "gs://cloud-samples-data/speech/brooklyn_bridge.mp3"]
// [START speech_quickstart_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;

/**
 * Performs synchronous speech recognition on an audio file.
 *
 * @param int    $sampleRateHertz Sample rate in Hertz of the audio data sent in all `RecognitionAudio`
 *                                messages. Valid values are: 8000-48000.
 * @param string $languageCode    The language of the supplied audio.
 * @param string $uriPath         Path to the audio file stored on GCS.
 */
function sampleRecognize($sampleRateHertz, $languageCode, $uriPath)
{
    $speechClient = new SpeechClient();

    // $sampleRateHertz = 44100;
    // $languageCode = 'en-US';
    // $uriPath = 'gs://cloud-samples-data/speech/brooklyn_bridge.mp3';
    $encoding = AudioEncoding::MP3;
    $config = new RecognitionConfig();
    $config->setEncoding($encoding);
    $config->setSampleRateHertz($sampleRateHertz);
    $config->setLanguageCode($languageCode);
    $audio = new RecognitionAudio();
    $audio->setUri($uriPath);

    try {
        $response = $speechClient->recognize($config, $audio);
        foreach ($response->getResults() as $result) {
            $transcript = $result->getAlternatives()[0]->getTranscript();
            printf('Transcript: %s'.PHP_EOL, $transcript);
        }
    } finally {
        $speechClient->close();
    }
}
// [END speech_quickstart_beta]

$opts = [
    'sample_rate_hertz::',
    'language_code::',
    'uri_path::',
];

$defaultOptions = [
    'sample_rate_hertz' => 44100,
    'language_code' => 'en-US',
    'uri_path' => 'gs://cloud-samples-data/speech/brooklyn_bridge.mp3',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$sampleRateHertz = $options['sample_rate_hertz'];
$languageCode = $options['language_code'];
$uriPath = $options['uri_path'];

sampleRecognize($sampleRateHertz, $languageCode, $uriPath);
