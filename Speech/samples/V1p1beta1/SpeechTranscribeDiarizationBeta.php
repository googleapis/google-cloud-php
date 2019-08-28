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
 * DO NOT EDIT! This is a generated sample ("LongRunningRequest",  "speech_transcribe_diarization_beta")
 */

// sample-metadata
//   title: Separating different speakers (Local File) (LRO) (Beta)
//   description: Print confidence level for individual words in a transcription of a short audio file
//     Separating different speakers in an audio file recording
//   usage: php samples/V1p1beta1/SpeechTranscribeDiarizationBeta.php [--local_file_path "resources/commercial_mono.wav"]
// [START speech_transcribe_diarization_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;

/**
 * Print confidence level for individual words in a transcription of a short audio file
 * Separating different speakers in an audio file recording.
 *
 * @param string $localFilePath Path to local audio file, e.g. /path/audio.wav
 */
function sampleLongRunningRecognize($localFilePath)
{
    $speechClient = new SpeechClient();

    // $localFilePath = 'resources/commercial_mono.wav';

    // If enabled, each word in the first alternative of each result will be
    // tagged with a speaker tag to identify the speaker.
    $enableSpeakerDiarization = true;

    // Optional. Specifies the estimated number of speakers in the conversation.
    $diarizationSpeakerCount = 2;

    // The language of the supplied audio
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setEnableSpeakerDiarization($enableSpeakerDiarization);
    $config->setDiarizationSpeakerCount($diarizationSpeakerCount);
    $config->setLanguageCode($languageCode);
    $content = file_get_contents($localFilePath);
    $audio = new RecognitionAudio();
    $audio->setContent($content);

    try {
        $operationResponse = $speechClient->longRunningRecognize($config, $audio);
        $operationResponse->pollUntilComplete();
        if ($operationResponse->operationSucceeded()) {
            $response = $operationResponse->getResult();
            foreach ($response->getResults() as $result) {
                // First alternative has words tagged with speakers
                $alternative = $result->getAlternatives()[0];
                printf('Transcript: %s'.PHP_EOL, $alternative->getTranscript());
                // Print the speakerTag of each word
                foreach ($alternative->getWords() as $word) {
                    printf('Word: %s'.PHP_EOL, $word->getWord());
                    printf('Speaker tag: %s'.PHP_EOL, $word->getSpeakerTag());
                }
            }
        } else {
            $error = $operationResponse->getError();
            // handleError($error)
        }
    } finally {
        $speechClient->close();
    }
}
// [END speech_transcribe_diarization_beta]

$opts = [
    'local_file_path::',
];

$defaultOptions = [
    'local_file_path' => 'resources/commercial_mono.wav',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$localFilePath = $options['local_file_path'];

sampleLongRunningRecognize($localFilePath);
