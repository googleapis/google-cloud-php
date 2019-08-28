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
//   title: Using Context Classes (Cloud Storage)
//   description: Transcribe a short audio file with static context classes.
//   usage: php samples/V1p1beta1/SpeechContextsClassesBeta.php [--storage_uri "gs://cloud-samples-data/speech/time.mp3"] [--phrase "$TIME"]
// [START speech_contexts_classes_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1p1beta1\SpeechContext;

/**
 * Transcribe a short audio file with static context classes.
 *
 * @param string $storageUri URI for audio file in Cloud Storage, e.g. gs://[BUCKET]/[FILE]
 * @param string $phrase     Phrase "hints" help recognize the specified phrases from your audio.
 *                           In this sample we are using a static class phrase ($TIME).
 *                           Classes represent groups of words that represent common concepts
 *                           that occur in natural language.
 */
function sampleRecognize($storageUri, $phrase)
{
    $speechClient = new SpeechClient();

    // $storageUri = 'gs://cloud-samples-data/speech/time.mp3';
    // $phrase = '$TIME';
    $phrases = [$phrase];
    $speechContextsElement = new SpeechContext();
    $speechContextsElement->setPhrases($phrases);
    $speechContexts = [$speechContextsElement];

    // The language of the supplied audio
    $languageCode = 'en-US';

    // Sample rate in Hertz of the audio data sent
    $sampleRateHertz = 24000;

    // Encoding of audio data sent. This sample sets this explicitly.
    // This field is optional for FLAC and WAV audio formats.
    $encoding = AudioEncoding::MP3;
    $config = new RecognitionConfig();
    $config->setSpeechContexts($speechContexts);
    $config->setLanguageCode($languageCode);
    $config->setSampleRateHertz($sampleRateHertz);
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
// [END speech_contexts_classes_beta]

$opts = [
    'storage_uri::',
    'phrase::',
];

$defaultOptions = [
    'storage_uri' => 'gs://cloud-samples-data/speech/time.mp3',
    'phrase' => '$TIME',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$storageUri = $options['storage_uri'];
$phrase = $options['phrase'];

sampleRecognize($storageUri, $phrase);
