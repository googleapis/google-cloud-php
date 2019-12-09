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
 * DO NOT EDIT! This is a generated sample ("LongRunningRequest",  "samplegen_lro")
 */

// sample-metadata
//   title: Calling Long-Running API method
//   description: Calling Long-Running API method
//   usage: php samples/V1p1beta1/SamplegenLro.php
// [START samplegen_lro]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;

/** Calling Long-Running API method */
function sampleLongRunningRecognize()
{
    $speechClient = new SpeechClient();

    $encoding = AudioEncoding::MP3;
    $config = new RecognitionConfig();
    $config->setEncoding($encoding);
    $uri = 'gs://[BUCKET]/[FILENAME]';
    $audio = new RecognitionAudio();
    $audio->setUri($uri);

    try {
        $operationResponse = $speechClient->longRunningRecognize($config, $audio);
        $operationResponse->pollUntilComplete();
        if ($operationResponse->operationSucceeded()) {
            $response = $operationResponse->getResult();
            // Your audio has been transcribed.
            printf('Transcript: %s'.PHP_EOL, $response->getResults()[0]->getAlternatives()[0]->getTranscript());
        } else {
            $error = $operationResponse->getError();
            // handleError($error)
        }
    } finally {
        $speechClient->close();
    }
}
// [END samplegen_lro]

sampleLongRunningRecognize();
