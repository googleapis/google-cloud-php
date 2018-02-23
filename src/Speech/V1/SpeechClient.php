<?php
/*
 * Copyright 2017 Google LLC
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
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/speech/v1/cloud_speech.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Speech\V1;

use Generator;
use Google\Cloud\Speech\SpeechHelpersTrait;
use Google\Cloud\Speech\V1\Gapic\SpeechGapicClient;

/**
 * {@inheritdoc}
 */
class SpeechClient extends SpeechGapicClient
{
    use SpeechHelpersTrait;

    /**
     * Creates a stream of StreamingRecognizeRequest objects from a stream of audio data.
     *
     * @param iterable|string[] $chunks
     * @return Generator|StreamingRecognizeRequest[]
     */
    public function createRequestStream($chunks)
    {
        return $this->createRequestStreamHelper(StreamingRecognizeRequest::class, $chunks);
    }

    /**
     * Performs speech recognition on a stream of audio data. This method is only available via
     * the gRPC API (not REST).
     *
     * Example:
     * ```
     * use Google\Cloud\Speech\V1\RecognitionConfig_AudioEncoding;
     * use Google\Cloud\Speech\V1\RecognitionConfig;
     * use Google\Cloud\Speech\V1\StreamingRecognitionConfig;
     *
     * $recognitionConfig = new RecognitionConfig();
     * $recognitionConfig->setEncoding(RecognitionConfig_AudioEncoding::FLAC);
     * $recognitionConfig->setSampleRateHertz(44100);
     * $recognitionConfig->setLanguageCode('en-US');
     * $config = new StreamingRecognitionConfig();
     * $config->setConfig($recognitionConfig);
     *
     * $f = fopen('path/to/audio.flac', 'r');
     * $audioStream = $speechClient->createAudioStream($f);
     *
     * $responseStream = $speechClient->recognizeAudioStream($config, $audioStream);
     *
     * foreach ($responseStream as $element) {
     *     // doSomethingWith($element);
     * }
     * ```
     *
     * @param StreamingRecognitionConfig  $config         *Required* Provides information to the recognizer that specifies how to
     *                                                    process the request.
     * @param iterable|string[]           $audioStream    *Required* A stream of audio data.
     * @param array                       $optionalArgs   {
     *                                                    Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     * @return StreamingRecognizeResponse[]
     */
    public function recognizeAudioStream($config, $audioStream, $optionalArgs = [])
    {
        $bidiStream = $this->streamingRecognize($optionalArgs);
        return $this->recognizeRequestStreamHelper(
            StreamingRecognizeRequest::class,
            $bidiStream,
            $config,
            $this->createRequestStream($audioStream)
        );
    }
}
