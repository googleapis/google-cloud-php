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
 * DO NOT EDIT! This is a generated sample ("Request",  "speech_transcribe_recognition_metadata_beta")
 */

// sample-metadata
//   title: Adding recognition metadata (Local File) (Beta)
//   description: Adds additional details short audio file included in this recognition request

//   usage: php samples/V1p1beta1/SpeechTranscribeRecognitionMetadataBeta.php [--local_file_path "resources/commercial_mono.wav"]
// [START speech_transcribe_recognition_metadata_beta]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionMetadata;
use Google\Cloud\Speech\V1p1beta1\RecognitionMetadata\InteractionType;
use Google\Cloud\Speech\V1p1beta1\RecognitionMetadata\RecordingDeviceType;

/**
 * Adds additional details short audio file included in this recognition request.
 *
 * @param string $localFilePath Path to local audio file, e.g. /path/audio.wav
 */
function sampleRecognize($localFilePath)
{
    $speechClient = new SpeechClient();

    // $localFilePath = 'resources/commercial_mono.wav';

    // The use case of the audio, e.g. PHONE_CALL, DISCUSSION, PRESENTATION, et al.
    $interactionType = InteractionType::VOICE_SEARCH;

    // The kind of device used to capture the audio
    $recordingDeviceType = RecordingDeviceType::SMARTPHONE;

    // The device used to make the recording.
    // Arbitrary string, e.g. 'Pixel XL', 'VoIP', 'Cardioid Microphone', or other value.
    $recordingDeviceName = 'Pixel 3';
    $metadata = new RecognitionMetadata();
    $metadata->setInteractionType($interactionType);
    $metadata->setRecordingDeviceType($recordingDeviceType);
    $metadata->setRecordingDeviceName($recordingDeviceName);

    // The language of the supplied audio. Even though additional languages are
    // provided by alternative_language_codes, a primary language is still required.
    $languageCode = 'en-US';
    $config = new RecognitionConfig();
    $config->setMetadata($metadata);
    $config->setLanguageCode($languageCode);
    $content = file_get_contents($localFilePath);
    $audio = new RecognitionAudio();
    $audio->setContent($content);

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
// [END speech_transcribe_recognition_metadata_beta]

$opts = [
    'local_file_path::',
];

$defaultOptions = [
    'local_file_path' => 'resources/commercial_mono.wav',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$localFilePath = $options['local_file_path'];

sampleRecognize($localFilePath);
