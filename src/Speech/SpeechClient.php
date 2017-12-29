<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Speech;

use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Speech\Connection\ConnectionInterface;
use Google\Cloud\Speech\Connection\Rest;
use Google\Cloud\Storage\StorageObject;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Google Cloud Speech enables easy integration of Google speech recognition
 * technologies into developer applications. Send audio and receive a text
 * transcription from the Cloud Speech API service. Find more information at the
 * [Google Cloud Speech docs](https://cloud.google.com/speech/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\Speech\SpeechClient;
 *
 * $speech = new SpeechClient([
 *     'languageCode' => 'en-US'
 * ]);
 * ```
 */
class SpeechClient
{
    use ClientTrait;

    const VERSION = '0.10.2';

    const SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    private $languageCode;

    /**
     * Create a Speech client.
     *
     * Note that when creating a SpeechClient instance, setting
     * `$config.projectId` is not supported. To switch between projects, you
     * must provide credentials with access to the project.
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type CacheItemPoolInterface $authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `0` with REST and `60` with gRPC.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type string $languageCode The language of the content to be
     *           recognized. Only BCP-47 (e.g., `"en-US"`, `"es-ES"`) language
     *           codes are accepted. See
     *           [Language Support](https://cloud.google.com/speech/docs/languages)
     *           for a list of the currently supported language codes. This
     *           value will be used by default for any requests sent through the
     *           client. If not provided, you must include a language code with
     *           each individual request.
     * }
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::SCOPE];
        }

        if (isset($config['languageCode'])) {
            $this->languageCode = $config['languageCode'];
            unset($config['languageCode']);
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Runs a recognize request and returns the results immediately. Ideal when
     * working with audio up to approximately one minute in length.
     *
     * Example:
     * ```
     * $results = $speech->recognize(
     *     fopen(__DIR__  . '/audio.flac', 'r')
     * );
     *
     * foreach ($results as $result) {
     *     echo $result->topAlternative()['transcript'] . PHP_EOL;
     * }
     * ```
     *
     * ```
     * // Run with speech contexts, sample rate, and encoding provided
     * $results = $speech->recognize(
     *     fopen(__DIR__  . '/audio.flac', 'r'), [
     *     'encoding' => 'FLAC',
     *     'sampleRateHertz' => 16000,
     *     'speechContexts' => [
     *         [
     *             'phrases' => [
     *                 'The Google Cloud Platform',
     *                 'Speech API'
     *             ]
     *         ]
     *     ]
     * ]);
     *
     * foreach ($results as $result) {
     *     echo $result->topAlternative()['transcript'] . PHP_EOL;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1/speech/recognize#SpeechRecognitionResult SpeechRecognitionResult
     * @see https://cloud.google.com/speech/reference/rest/v1/speech/recognize Recognize API documentation
     * @see https://cloud.google.com/speech/reference/rest/v1/RecognitionConfig#AudioEncoding AudioEncoding types
     * @see https://cloud.google.com/speech/docs/best-practices Speech API best practices
     * @codingStandardsIgnoreEnd
     *
     * @param resource|string|StorageObject $audio The audio to recognize. May
     *        be a resource, string of bytes, a URI pointing to a
     *        Google Cloud Storage object in the format of
     *        `gs://{bucket-name}/{object-name}` or a
     *        {@see Google\Cloud\Storage\StorageObject}.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $detectGcsUri When providing $audio as a string, this flag
     *           determines whether or not to attempt to detect if the string
     *           represents a Google Cloud Storage URI in the format of
     *           `gs://{bucket-name}/{object-name}`. **Defaults to** `true`.
     *     @type string $languageCode The language of the content. BCP-47
     *           (e.g., `"en-US"`, `"es-ES"`) language codes are accepted. See
     *           [Language Support](https://cloud.google.com/speech/docs/languages)
     *           for a list of the currently supported language codes. This
     *           value will be required if a default has not been set on the
     *           client. **Defaults to** the value set on the client.
     *     @type int $sampleRateHertz Sample rate in Hertz of the provided
     *           audio. Valid values are: 8000-48000. 16000 is optimal. For best
     *           results, set the sampling rate of the audio source to 16000 Hz.
     *           If that's not possible, use the native sample rate of the audio
     *           source (instead of re-sampling). For .flac and .wav files the
     *           Speech API will make a best effort to read the sample rate from
     *           the file's headers.
     *     @type string $encoding Encoding of the provided audio. May be one of
     *           `"LINEAR16"`, `"FLAC"`, `"MULAW"`, `"AMR"`, `"AMR_WB"`. For
     *           .flac and .wav files the Speech API will make a best effort to
     *           determine the encoding type from the file's headers.
     *     @type int $maxAlternatives Maximum number of alternatives to be
     *           returned. Valid values are 1-30. **Defaults to** `1`.
     *     @type bool $profanityFilter If set to `true`, the server will attempt
     *           to filter out profanities, replacing all but the initial
     *           character in each filtered word with asterisks, e.g. \"f***\".
     *           **Defaults to** `false`.
     *     @type array $speechContexts A list of arrays where each element must
     *           contain a key `phrases`. Each key `phrases` should contain an
     *           array of strings which provide "hints" to the speech recognizer
     *           to favor specific words and phrases in the results. Please see
     *           [SpeechContext](https://cloud.google.com/speech/reference/rest/v1/RecognitionConfig#SpeechContext)
     *           for more information.
     *     @type bool $enableWordTimeOffsets If set to `true`, a list of
     *           `wordTimeOffsets` are returned with the top alternative. If
     *           `false` or omitted, no `wordTimeOffsets` are returned.
     *           **Defaults to** `false`.
     * }
     * @return array Result[]
     * @throws \InvalidArgumentException
     */
    public function recognize($audio, array $options = [])
    {
        $results = [];
        $response = $this->connection->recognize(
            $this->formatRequest($audio, $options)
        );

        if (!isset($response['results'])) {
            return $results;
        }

        foreach ($response['results'] as $result) {
            $results[] = new Result($result);
        }

        return $results;
    }

    /**
     * Runs a recognize request as an operation. Ideal when working with audio
     * longer than approximately one minute. Requires polling of the returned
     * operation in order to fetch results.
     *
     * For longer audio, up to approximately 80 minutes, you must use Google
     * Cloud Storage objects as input. In addition to this restriction, only
     * LINEAR16 audio encoding can be used for long audio inputs.
     *
     * Example:
     * ```
     * $operation = $speech->beginRecognizeOperation(
     *     fopen(__DIR__  . '/audio.flac', 'r')
     * );
     *
     * $isComplete = $operation->isComplete();
     *
     * while (!$isComplete) {
     *     sleep(1); // let's wait for a moment...
     *     $operation->reload();
     *     $isComplete = $operation->isComplete();
     * }
     *
     * $result = $operation->results()[0];
     * print_r($result->topAlternative());
     * ```
     *
     * ```
     * // Run with speech contexts, sample rate, and encoding provided
     * $operation = $speech->beginRecognizeOperation(
     *     fopen(__DIR__  . '/audio.flac', 'r'), [
     *     'encoding' => 'FLAC',
     *     'sampleRateHertz' => 16000,
     *     'speechContexts' => [
     *         [
     *             'phrases' => [
     *                 'The Google Cloud Platform',
     *                 'Speech API'
     *             ]
     *         ]
     *     ]
     * ]);
     *
     * $isComplete = $operation->isComplete();
     *
     * while (!$isComplete) {
     *     sleep(1); // let's wait for a moment...
     *     $operation->reload();
     *     $isComplete = $operation->isComplete();
     * }
     *
     * $result = $operation->results()[0];
     * print_r($result->topAlternative());
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1/operations Operations
     * @see https://cloud.google.com/speech/reference/rest/v1/speech/longrunningrecognize LongRunningRecognize API documentation
     * @see https://cloud.google.com/speech/reference/rest/v1/RecognitionConfig#AudioEncoding AudioEncoding types
     * @see https://cloud.google.com/speech/docs/best-practices Speech API best practices
     * @codingStandardsIgnoreEnd
     *
     * @param resource|string|StorageObject $audio The audio to recognize. May
     *        be a resource, string of bytes, a URI pointing to a
     *        Google Cloud Storage object in the format of
     *        `gs://{bucket-name}/{object-name}` or a
     *        {@see Google\Cloud\Storage\StorageObject}.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $detectGcsUri When providing $audio as a string, this flag
     *           determines whether or not to attempt to detect if the string
     *           represents a Google Cloud Storage URI in the format of
     *           `gs://{bucket-name}/{object-name}`. **Defaults to** `true`.
     *     @type string $languageCode The language of the content. BCP-47
     *           (e.g., `"en-US"`, `"es-ES"`) language codes are accepted. See
     *           [Language Support](https://cloud.google.com/speech/docs/languages)
     *           for a list of the currently supported language codes. This
     *           value will be required if a default has not been set on the
     *           client. **Defaults to** the value set on the client.
     *     @type int $sampleRateHertz Sample rate in Hertz of the provided
     *           audio. Valid values are: 8000-48000. 16000 is optimal. For best
     *           results, set the sampling rate of the audio source to 16000 Hz.
     *           If that's not possible, use the native sample rate of the audio
     *           source (instead of re-sampling). For .flac and .wav files the
     *           Speech API will make a best effort to read the sample rate from
     *           the file's headers.
     *     @type string $encoding Encoding of the provided audio. May be one of
     *           `"LINEAR16"`, `"FLAC"`, `"MULAW"`, `"AMR"`, `"AMR_WB"`. For
     *           .flac and .wav files the Speech API will make a best effort to
     *           determine the encoding type from the file's headers.
     *     @type int $maxAlternatives Maximum number of alternatives to be
     *           returned. Valid values are 1-30. **Defaults to** `1`.
     *     @type bool $profanityFilter If set to `true`, the server will attempt
     *           to filter out profanities, replacing all but the initial
     *           character in each filtered word with asterisks, e.g. \"f***\".
     *           **Defaults to** `false`.
     *     @type array $speechContexts A list of arrays where each element must
     *           contain a key `phrases`. Each key `phrases` should contain an
     *           array of strings which provide "hints" to the speech recognizer
     *           to favor specific words and phrases in the results. Please see
     *           [SpeechContext](https://cloud.google.com/speech/reference/rest/v1/RecognitionConfig#SpeechContext)
     *           for more information.
     *     @type bool $enableWordTimeOffsets If set to `true`, a list of
     *           `wordTimeOffsets` are returned with the top alternative. If
     *           `false` or omitted, no `wordTimeOffsets` are returned.
     *           **Defaults to** `false`.
     * }
     * @return Operation
     * @throws \InvalidArgumentException
     */
    public function beginRecognizeOperation($audio, array $options = [])
    {
        $response = $this->connection->longRunningRecognize(
            $this->formatRequest($audio, $options)
        );

        return new Operation(
            $this->connection,
            $response['name'],
            $response
        );
    }

    /**
     * Lazily instantiates an operation. There are no network requests made at
     * this point. To see the operations that can be performed on an operation
     * please see {@see Google\Cloud\Speech\Operation}.
     *
     * Example:
     * ```
     * // Access an existing operation by its server generated name.
     * $operation = $speech->operation($operationName);
     * ```
     *
     * @param string $name The name of the operation to request.
     * @return Operation
     */
    public function operation($name)
    {
        return new Operation($this->connection, $name);
    }

    /**
     * Formats the request for the API.
     *
     * @param resource|string|StorageObject $audio
     * @param array $options
     * @return array
     * @throws \InvalidArgumentException
     */
    private function formatRequest($audio, array $options)
    {
        $fileFormat = null;
        $options += [
            'detectGcsUri' => true,
            'languageCode' => $this->languageCode
        ];
        $recognizeOptions = [
            'encoding',
            'sampleRateHertz',
            'languageCode',
            'maxAlternatives',
            'profanityFilter',
            'speechContexts',
            'enableWordTimeOffsets'
        ];

        if ($audio instanceof StorageObject) {
            $options['audio']['uri'] = $audio->gcsUri();
            $fileFormat = pathinfo($options['audio']['uri'], PATHINFO_EXTENSION);
        } elseif (is_resource($audio)) {
            $options['audio']['content'] = base64_encode(stream_get_contents($audio));
            $fileFormat = pathinfo(stream_get_meta_data($audio)['uri'], PATHINFO_EXTENSION);
        } elseif ($options['detectGcsUri'] && substr($audio, 0, 5) === 'gs://') {
            $options['audio']['uri'] = $audio;
            $fileFormat = pathinfo($options['audio']['uri'], PATHINFO_EXTENSION);
        } else {
            $options['audio']['content'] = base64_encode($audio);
        }

        unset($options['detectGcsUri']);

        if (!$options['languageCode']) {
            throw new \InvalidArgumentException('A valid BCP-47 language code is required.');
        }

        foreach ($options as $option => $value) {
            if (in_array($option, $recognizeOptions)) {
                $options['config'][$option] = $value;
                unset($options[$option]);
            }
        }

        return $options;
    }
}
