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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_transcribe_multichannel_gcs")
 */

// [START speech_transcribe_multichannel_gcs]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;

/**
 * Transcribe a short audio file from Cloud Storage with multiple channels.
 *
 * @param string $storageUri URI for audio file in Cloud Storage, e.g. gs://[BUCKET]/[FILE]
 */
function sampleRecognize($storageUri)
{
    // [START speech_transcribe_multichannel_gcs_core]

    $speechClient = new SpeechClient();

    // $storageUri = 'gs://cloud-samples-data/speech/multi.wav';

    // The number of channels in the input audio file (optional)
    $audioChannelCount = 2;

    // When set to true, each audio channel will be recognized separately.
    // The recognition result will contain a channel_tag field to state which
    // channel that result belongs to
    $enableSeparateRecognitionPerChannel = true;

    // The language of the supplied audio
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setAudioChannelCount($audioChannelCount);
    $config->setEnableSeparateRecognitionPerChannel($enableSeparateRecognitionPerChannel);
    $config->setLanguageCode($languageCode);
    $audio = new RecognitionAudio();
    $audio->setUri($storageUri);

    try {
        $response = $speechClient->recognize($config, $audio);
        foreach ($response->getResults() as $result) {
            // channelTag to recognize which audio channel this result is for
            printf('Channel tag: %s'.PHP_EOL, $result->getChannelTag());
            // First alternative is the most probable result
            $alternative = $result->getAlternatives()[0];
            printf('Transcript: %s'.PHP_EOL, $alternative->getTranscript());
        }
    } finally {
        $speechClient->close();
    }

    // [END speech_transcribe_multichannel_gcs_core]
}
// [END speech_transcribe_multichannel_gcs]

$opts = [
    'storage_uri::',
];

$defaultOptions = [
    'storage_uri' => 'gs://cloud-samples-data/speech/multi.wav',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$storageUri = $options['storage_uri'];

sampleRecognize($storageUri);
