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
 * https://github.com/google/googleapis/blob/master/google/cloud/speech/v1beta1/cloud_speech.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Speech\V1beta1;

use Generator;
use Google\Cloud\Speech\SpeechHelpersTrait;
use Google\Cloud\Speech\V1beta1\Gapic\SpeechGapicClient;

/**
 * {@inheritdoc}
 */
class SpeechClient extends SpeechGapicClient
{
    use SpeechHelpersTrait;

    /**
     * Performs synchronous speech recognition: receive results after all audio
     * has been sent and processed.
     *
     * Example:
     * ```
     * use Google\Cloud\Speech\V1beta1\RecognitionConfig_AudioEncoding;
     * use Google\Cloud\Speech\V1beta1\RecognitionConfig;
     *
     * $encoding = RecognitionConfig_AudioEncoding::FLAC;
     * $sampleRateHertz = 44100;
     * $languageCode = 'en-US';
     * $config = new RecognitionConfig();
     * $config->setEncoding($encoding);
     * $config->setSampleRate($sampleRateHertz);
     * $config->setLanguageCode($languageCode);
     * $audioUri = 'gs://bucket_name/file_name.flac';
     * $response = $speechClient->syncRecognize($config, $audioUri);
     * ```
     *
     * @param RecognitionConfig                $config       *Required* Provides information to the recognizer that specifies how to
     *                                                       process the request.
     * @param RecognitionAudio|resource|string $audio        *Required* The audio data to be recognized. This can be a RecognitionAudio
     *                                                       object, a Google Cloud Storage URI, a resource object, or a string of bytes.
     * @param array                            $optionalArgs {
     *                                                        Optional.
     *
     * @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return RecognizeResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function syncRecognize($config, $audio, $optionalArgs = [])
    {
        return parent::syncRecognize($config, $this->createRecognitionAudioHelper(RecognitionAudio::class, $audio), $optionalArgs);
    }

    /**
     * Performs asynchronous speech recognition: receive results via the
     * google.longrunning.Operations interface. Returns either an
     * `Operation.error` or an `Operation.response` which contains
     * a `LongRunningRecognizeResponse` message.
     *
     * Example:
     * ```
     * use Google\Cloud\Speech\V1beta1\RecognitionConfig_AudioEncoding;
     * use Google\Cloud\Speech\V1beta1\RecognitionConfig;
     *
     * $encoding = RecognitionConfig_AudioEncoding::FLAC;
     * $sampleRateHertz = 44100;
     * $languageCode = 'en-US';
     * $config = new RecognitionConfig();
     * $config->setEncoding($encoding);
     * $config->setSampleRate($sampleRateHertz);
     * $config->setLanguageCode($languageCode);
     * $audioUri = 'gs://bucket_name/file_name.flac';
     * $operationResponse = $speechClient->asyncRecognize($config, $audioUri);
     * $operationResponse->pollUntilComplete();
     * if ($operationResponse->operationSucceeded()) {
     *   $result = $operationResponse->getResult();
     *   // doSomethingWith($result)
     * } else {
     *   $error = $operationResponse->getError();
     *   // handleError($error)
     * }
     *```
     *
     * ```
     * //[snippet=resume]
     * // OR start the operation, keep the operation name, and resume later
     * $operationResponse = $speechClient->asyncRecognize($config, $audioUri);
     * $operationName = $operationResponse->getName();
     * // ... do other work
     * $newOperationResponse = $speechClient->resumeOperation($operationName, 'asyncRecognize');
     * while (!$newOperationResponse->isDone()) {
     *     // ... do other work
     *     $newOperationResponse->reload();
     * }
     * if ($newOperationResponse->operationSucceeded()) {
     *   $result = $newOperationResponse->getResult();
     *   // doSomethingWith($result)
     * } else {
     *   $error = $newOperationResponse->getError();
     *   // handleError($error)
     * }
     * ```
     *
     * @param RecognitionConfig                $config       *Required* Provides information to the recognizer that specifies how to
     *                                                       process the request.
     * @param RecognitionAudio|resource|string $audio        *Required* The audio data to be recognized. This can be a RecognitionAudio
     *                                                       object, a Google Cloud Storage URI, a resource object, or a string of bytes.
     * @param array                            $optionalArgs {
     *                                                        Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function asyncRecognize($config, $audio, $optionalArgs = [])
    {
        return parent::asyncRecognize($config, $this->createRecognitionAudioHelper(RecognitionAudio::class, $audio), $optionalArgs);
    }

    /**
     * Performs speech recognition on a stream of audio data. This method is only available via
     * the gRPC API (not REST).
     *
     * Example:
     * ```
     * use Google\Cloud\Speech\V1beta1\RecognitionConfig_AudioEncoding;
     * use Google\Cloud\Speech\V1beta1\RecognitionConfig;
     * use Google\Cloud\Speech\V1beta1\StreamingRecognitionConfig;
     *
     * $recognitionConfig = new RecognitionConfig();
     * $recognitionConfig->setEncoding(RecognitionConfig_AudioEncoding::FLAC);
     * $recognitionConfig->setSampleRate(44100);
     * $recognitionConfig->setLanguageCode('en-US');
     * $config = new StreamingRecognitionConfig();
     * $config->setConfig($recognitionConfig);
     *
     * $audioResource = fopen('path/to/audio.flac', 'r');
     *
     * $responseStream = $speechClient->recognizeAudioStream($config, $audioResource);
     *
     * foreach ($responseStream as $element) {
     *     // doSomethingWith($element);
     * }
     * ```
     *
     * @param StreamingRecognitionConfig  $config         *Required* Provides information to the recognizer that specifies how to
     *                                                    process the request.
     * @param iterable|resource|string    $audio          *Required* Audio data to be streamed. Can be a resource, a string of bytes,
     *                                                    or an iterable of StreamingRecognizeRequest[] or string[].
     * @param array                       $optionalArgs   {
     *                                                    Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     * @return StreamingRecognizeResponse[]
     */
    public function recognizeAudioStream($config, $audio, $optionalArgs = [])
    {
        $bidiStream = $this->streamingRecognize($optionalArgs);
        $bidiStream->writeAll($this->createAudioStreamHelper(StreamingRecognizeRequest::class, $config, $audio));
        return $bidiStream->closeWriteAndReadAll();
    }
}
