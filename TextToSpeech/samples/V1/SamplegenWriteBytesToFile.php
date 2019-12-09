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
 * DO NOT EDIT! This is a generated sample ("Request",  "samplegen_write_bytes_to_file")
 */

// sample-metadata
//   title: Synthesize an .mp3 file with audio saying the provided phrase
//   description: Synthesize an .mp3 file with audio saying the provided phrase
//   usage: php samples/V1/SamplegenWriteBytesToFile.php
// [START samplegen_write_bytes_to_file]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

/** Synthesize an .mp3 file with audio saying the provided phrase */
function sampleSynthesizeSpeech()
{
    $textToSpeechClient = new TextToSpeechClient();

    $text = 'Hello, world!';
    $input = new SynthesisInput();
    $input->setText($text);
    $languageCode = 'en';
    $voice = new VoiceSelectionParams();
    $voice->setLanguageCode($languageCode);
    $audioEncoding = AudioEncoding::MP3;
    $audioConfig = new AudioConfig();
    $audioConfig->setAudioEncoding($audioEncoding);

    try {
        $response = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
        printf('Writing the synthsized results to output.mp3'.PHP_EOL);
        file_put_contents('output.mp3', $response->getAudioContent());
    } finally {
        $textToSpeechClient->close();
    }
}
// [END samplegen_write_bytes_to_file]

sampleSynthesizeSpeech();
