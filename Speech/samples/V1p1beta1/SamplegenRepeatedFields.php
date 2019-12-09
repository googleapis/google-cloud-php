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
 * DO NOT EDIT! This is a generated sample ("Request",  "samplegen_repeated_fields")
 */

// sample-metadata
//   title: Showing repeated fields (in request and response)
//   description: Showing repeated fields (in request and response)
//   usage: php samples/V1p1beta1/SamplegenRepeatedFields.php
// [START samplegen_repeated_fields]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1p1beta1\SpeechContext;

/** Showing repeated fields (in request and response) */
function sampleRecognize()
{
    $speechClient = new SpeechClient();

    $encoding = AudioEncoding::MP3;

    // A list of strings containing words and phrases "hints"
    $phrasesElement = 'Fox in socks';
    $phrasesElement2 = 'Knox in box';
    $phrases = [$phrasesElement, $phrasesElement2];
    $speechContextsElement = new SpeechContext();
    $speechContextsElement->setPhrases($phrases);
    $speechContexts = [$speechContextsElement];
    $config = new RecognitionConfig();
    $config->setEncoding($encoding);
    $config->setSpeechContexts($speechContexts);
    $uri = 'gs://[BUCKET]/[FILENAME]';
    $audio = new RecognitionAudio();
    $audio->setUri($uri);

    try {
        $response = $speechClient->recognize($config, $audio);
        // Loop over all transcription results
        foreach ($response->getResults() as $result) {
            // The first "alternative" of each result contains most likely transcription
            $alternative = $result->getAlternatives()[0];
            printf('Transcription of result: %s'.PHP_EOL, $alternative->getTranscript());
        }
    } finally {
        $speechClient->close();
    }
}
// [END samplegen_repeated_fields]

sampleRecognize();
