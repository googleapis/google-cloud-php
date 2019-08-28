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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_adaptation_beta")
 */

// sample-metadata
//   title: Speech Adaptation (Cloud Storage)
//   description: Transcribe a short audio file with speech adaptation.
//   usage: php samples/V1p1beta1/SpeechAdaptationBeta.php [--storage_uri "gs://cloud-samples-data/speech/brooklyn_bridge.mp3"] [--phrase "Brooklyn Bridge"]
// [START speech_adaptation_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1p1beta1\SpeechContext;

/**
 * Transcribe a short audio file with speech adaptation.
 *
 * @param string $storageUri URI for audio file in Cloud Storage, e.g. gs://[BUCKET]/[FILE]
 * @param string $phrase     Phrase "hints" help recognize the specified phrases from your audio.
 */
function sampleRecognize($storageUri, $phrase)
{
    $speechClient = new SpeechClient();

    // $storageUri = 'gs://cloud-samples-data/speech/brooklyn_bridge.mp3';
    // $phrase = 'Brooklyn Bridge';
    $phrases = [$phrase];

    // Hint Boost. This value increases the probability that a specific
    // phrase will be recognized over other similar sounding phrases.
    // The higher the boost, the higher the chance of false positive
    // recognition as well. Can accept wide range of positive values.
    // Most use cases are best served with values between 0 and 20.
    // Using a binary search happroach may help you find the optimal value.
    $boost = 20.0;
    $speechContextsElement = new SpeechContext();
    $speechContextsElement->setPhrases($phrases);
    $speechContextsElement->setBoost($boost);
    $speechContexts = [$speechContextsElement];

    // Sample rate in Hertz of the audio data sent
    $sampleRateHertz = 44100;

    // The language of the supplied audio
    $languageCode = 'en-US';

    // Encoding of audio data sent. This sample sets this explicitly.
    // This field is optional for FLAC and WAV audio formats.
    $encoding = AudioEncoding::MP3;
    $config = new RecognitionConfig();
    $config->setSpeechContexts($speechContexts);
    $config->setSampleRateHertz($sampleRateHertz);
    $config->setLanguageCode($languageCode);
    $config->setEncoding($encoding);
    $audio = new RecognitionAudio();
    $audio->setUri($storageUri);

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
// [END speech_adaptation_beta]

$opts = [
    'storage_uri::',
    'phrase::',
];

$defaultOptions = [
    'storage_uri' => 'gs://cloud-samples-data/speech/brooklyn_bridge.mp3',
    'phrase' => 'Brooklyn Bridge',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$storageUri = $options['storage_uri'];
$phrase = $options['phrase'];

sampleRecognize($storageUri, $phrase);
