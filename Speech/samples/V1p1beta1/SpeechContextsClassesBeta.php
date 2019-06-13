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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_contexts_classes_beta")
 */

// sample-metadata
//   title:
//   description: Performs synchronous speech recognition with static context classes.
//   usage: php samples/V1p1beta1/SpeechContextsClassesBeta.php [--sample_rate_hertz 24000] [--language_code "en-US"] [--phrase "$TIME"] [--uri_path "gs://cloud-samples-data/speech/time.mp3"]
// [START speech_contexts_classes_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1p1beta1\SpeechContext;

/**
 * Performs synchronous speech recognition with static context classes.
 *
 * @param int    $sampleRateHertz Sample rate in Hertz of the audio data sent in all `RecognitionAudio`
 *                                messages. Valid values are: 8000-48000.
 * @param string $languageCode    The language of the supplied audio.
 * @param string $phrase          Phrase "hints" help Speech-to-Text API recognize the specified phrases from
 *                                your audio data. In this sample we are using a static class phrase ($TIME). Classes represent
 *                                groups of words that represent common concepts that occur in natural language. We recommend
 *                                checking out the docs page for more info on static classes.
 * @param string $uriPath         Path to the audio file stored on GCS.
 */
function sampleRecognize($sampleRateHertz, $languageCode, $phrase, $uriPath)
{
    $speechClient = new SpeechClient();

    // $sampleRateHertz = 24000;
    // $languageCode = 'en-US';
    // $phrase = '$TIME';
    // $uriPath = 'gs://cloud-samples-data/speech/time.mp3';
    $encoding = AudioEncoding::MP3;
    $phrases = [$phrase];
    $speechContextsElement = new SpeechContext();
    $speechContextsElement->setPhrases($phrases);
    $speechContexts = [$speechContextsElement];
    $config = new RecognitionConfig();
    $config->setEncoding($encoding);
    $config->setSampleRateHertz($sampleRateHertz);
    $config->setLanguageCode($languageCode);
    $config->setSpeechContexts($speechContexts);
    $audio = new RecognitionAudio();
    $audio->setUri($uriPath);

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
// [END speech_contexts_classes_beta]

$opts = [
    'sample_rate_hertz::',
    'language_code::',
    'phrase::',
    'uri_path::',
];

$defaultOptions = [
    'sample_rate_hertz' => 24000,
    'language_code' => 'en-US',
    'phrase' => '$TIME',
    'uri_path' => 'gs://cloud-samples-data/speech/time.mp3',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$sampleRateHertz = $options['sample_rate_hertz'];
$languageCode = $options['language_code'];
$phrase = $options['phrase'];
$uriPath = $options['uri_path'];

sampleRecognize($sampleRateHertz, $languageCode, $phrase, $uriPath);
