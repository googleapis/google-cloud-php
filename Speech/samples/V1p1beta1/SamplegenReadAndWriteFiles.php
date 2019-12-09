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
 * DO NOT EDIT! This is a generated sample ("Request",  "samplegen_read_and_write_files")
 */

// sample-metadata
//   title: Showing repeated fields (in request and response)
//   description: Showing repeated fields (in request and response)
//   usage: php samples/V1p1beta1/SamplegenReadAndWriteFiles.php
// [START samplegen_read_and_write_files]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;

/** Showing repeated fields (in request and response) */
function sampleRecognize()
{
    $speechClient = new SpeechClient();

    $encoding = AudioEncoding::MP3;
    $config = new RecognitionConfig();
    $config->setEncoding($encoding);

    // The bytes from this file will be read into `content`
    $content = file_get_contents('path/to/file.mp3');
    $audio = new RecognitionAudio();
    $audio->setContent($content);

    try {
        $response = $speechClient->recognize($config, $audio);
        // Your audio has been transcribed.
        // Writing audio transcript to transcript.txt for demonstration:
        file_put_contents('transcript.txt', $response->getResults()[0]->getAlternatives()[0]->getTranscript());
    } finally {
        $speechClient->close();
    }
}
// [END samplegen_read_and_write_files]

sampleRecognize();
