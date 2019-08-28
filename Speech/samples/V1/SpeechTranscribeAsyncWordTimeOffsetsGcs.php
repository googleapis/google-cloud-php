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
 * DO NOT EDIT! This is a generated sample ("LongRunningRequest",  "speech_transcribe_async_word_time_offsets_gcs")
 */

// sample-metadata
//   title: Getting word timestamps (Cloud Storage) (LRO)
//   description: Print start and end time of each word spoken in audio file from Cloud Storage
//   usage: php samples/V1/SpeechTranscribeAsyncWordTimeOffsetsGcs.php [--storage_uri "gs://cloud-samples-data/speech/brooklyn_bridge.flac"]
// [START speech_transcribe_async_word_time_offsets_gcs]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;

/**
 * Print start and end time of each word spoken in audio file from Cloud Storage.
 *
 * @param string $storageUri URI for audio file in Cloud Storage, e.g. gs://[BUCKET]/[FILE]
 */
function sampleLongRunningRecognize($storageUri)
{
    $speechClient = new SpeechClient();

    // $storageUri = 'gs://cloud-samples-data/speech/brooklyn_bridge.flac';

    // When enabled, the first result returned by the API will include a list
    // of words and the start and end time offsets (timestamps) for those words.
    $enableWordTimeOffsets = true;

    // The language of the supplied audio
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setEnableWordTimeOffsets($enableWordTimeOffsets);
    $config->setLanguageCode($languageCode);
    $audio = new RecognitionAudio();
    $audio->setUri($storageUri);

    try {
        $operationResponse = $speechClient->longRunningRecognize($config, $audio);
        $operationResponse->pollUntilComplete();
        if ($operationResponse->operationSucceeded()) {
            $response = $operationResponse->getResult();
            // The first result includes start and end time word offsets
            $result = $response->getResults()[0];
            // First alternative is the most probable result
            $alternative = $result->getAlternatives()[0];
            printf('Transcript: %s'.PHP_EOL, $alternative->getTranscript());
            // Print the start and end time of each word
            foreach ($alternative->getWords() as $word) {
                printf('Word: %s'.PHP_EOL, $word->getWord());
                printf('Start time: %s seconds %s nanos'.PHP_EOL, $word->getStartTime()->getSeconds(), $word->getStartTime()->getNanos());
                printf('End time: %s seconds %s nanos'.PHP_EOL, $word->getEndTime()->getSeconds(), $word->getEndTime()->getNanos());
            }
        } else {
            $error = $operationResponse->getError();
            // handleError($error)
        }
    } finally {
        $speechClient->close();
    }
}
// [END speech_transcribe_async_word_time_offsets_gcs]

$opts = [
    'storage_uri::',
];

$defaultOptions = [
    'storage_uri' => 'gs://cloud-samples-data/speech/brooklyn_bridge.flac',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$storageUri = $options['storage_uri'];

sampleLongRunningRecognize($storageUri);
