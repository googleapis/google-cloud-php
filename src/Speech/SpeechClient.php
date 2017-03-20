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
 * To enable better detection of encoding/sample rate values it is recommended
 * to install the getID3() library by James Heinrich. Please note that using
 * the library will require files to be temporarily stored on disk. To install
 * add `james-heinrich/getid3` to your composer require section or run the
 * following:
 *
 * ```sh
 * $ composer require james-heinrich/getid3
 * ```
 *
 * Example:
 * ```
 * use Google\Cloud\Speech\SpeechClient;
 *
 * $speech = new SpeechClient();
 * ```
 */
class SpeechClient
{
    use ClientTrait;

    const VERSION = '0.2.0';

    const SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Create a Speech client.
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Runs a recognize request and returns the results immediately. Ideal when
     * working with audio up to approximately one minute in length.
     *
     * The Google Cloud Client Library will attempt to infer the sample rate
     * and encoding used by the provided audio file for you. This feature is
     * recommended only if you are unsure of what the values may be and is
     * currently limited to .flac, .amr, and .awb file types. The sample rate
     * cannot be inferred from audio provided from a Google Storage object.
     *
     * Example:
     * ```
     * $results = $speech->recognize(
     *     fopen(__DIR__  . '/audio.flac', 'r')
     * );
     *
     * foreach ($results as $result) {
     *     echo $result['transcript'];
     * }
     * ```
     *
     * ```
     * // Run with speech context, sample rate, and encoding provided
     * $results = $speech->recognize(
     *     fopen(__DIR__  . '/audio.flac', 'r'), [
     *     'encoding' => 'FLAC',
     *     'sampleRate' => 16000,
     *     'speechContext' => [
     *         'phrases' => [
     *             'The Google Cloud Platform',
     *             'Speech API'
     *         ]
     *     ]
     * ]);
     *
     * foreach ($results as $result) {
     *     echo $result['transcript'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/speech/syncrecognize#SpeechRecognitionAlternative SpeechRecognitionAlternative
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/speech/syncrecognize SyncRecognize API documentation
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/RecognitionConfig#AudioEncoding AudioEncoding types
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
     *     @type int $sampleRate Sample rate in Hertz of the provided audio.
     *           Valid values are: 8000-48000. 16000 is optimal. For best
     *           results, set the sampling rate of the audio source to 16000 Hz.
     *           If that's not possible, use the native sample rate of the audio
     *           source (instead of re-sampling). **Defaults to** `8000`
     *           with .amr files and `16000` with .awb files. If the
     *           getID3 library has been installed this value will **default
     *           to** the value read from the file's headers (if they exists).
     *     @type string $encoding Encoding of the provided audio. May be one of
     *           `"LINEAR16"`, `"FLAC"`, `"MULAW"`, `"AMR"`, `"AMR_WB"`. **Defaults to**
     *           `"FLAC"` with .flac files, `"AMR"` with .amr files and `"AMR_WB"`
     *           with .awb files.
     *     @type int $maxAlternatives Maximum number of alternatives to be
     *           returned. Valid values are 1-30. **Defaults to** `1`.
     *     @type string $languageCode The language of the content. BCP-47
     *           (e.g., `"en-US"`, `"es-ES"`) language codes are accepted. **Defaults to**
     *           `"en-US"` (English).
     *     @type bool $profanityFilter If set to `true`, the server will attempt
     *           to filter out profanities, replacing all but the initial
     *           character in each filtered word with asterisks, e.g. \"f***\".
     *           **Defaults to** `false`.
     *     @type array $speechContext Must contain a key `phrases` which is to
     *           be an array of strings which provide "hints" to the speech
     *           recognizer to favor specific words and phrases in the results.
     *           Please see
     *           [SpeechContext](https://cloud.google.com/speech/reference/rest/v1beta1/RecognitionConfig#SpeechContext)
     *           for more information.
     * }
     * @return array The transcribed results. Each element of the array contains
     *         a `transcript` key which holds the transcribed text. Optionally
     *         a `confidence` key holding the confidence estimate ranging from
     *         0.0 to 1.0 may be present. `confidence` is typically provided
     *         only for the top hypothesis.
     * @throws \InvalidArgumentException
     */
    public function recognize($audio, array $options = [])
    {
        $response = $this->connection->syncRecognize(
            $this->formatRequest($audio, $options)
        );

        return isset($response['results']) ? $response['results'][0]['alternatives'] : [];
    }

    /**
     * Runs a recognize request as an operation. Ideal when working with audio
     * longer than approximately one minute. Requires polling of the returned
     * operation in order to fetch results.
     *
     * The Google Cloud Client Library will attempt to infer the sample rate
     * and encoding used by the provided audio file for you. This feature is
     * recommended only if you are unsure of what the values may be and is
     * currently limited to .flac, .amr, and .awb file types. The sample rate
     * cannot be inferred from audio provided from a Google Storage object.
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
     * print_r($operation->results());
     * ```
     *
     * ```
     * // Run with speech context, sample rate, and encoding provided
     * $operation = $speech->beginRecognizeOperation(
     *     fopen(__DIR__  . '/audio.flac', 'r'), [
     *     'encoding' => 'FLAC',
     *     'sampleRate' => 16000,
     *     'speechContext' => [
     *         'phrases' => [
     *             'The Google Cloud Platform',
     *             'Speech API'
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
     * print_r($operation->results());
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/operations Operations
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/speech/asyncrecognize AsyncRecognize API documentation
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/RecognitionConfig#AudioEncoding AudioEncoding types
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
     *     @type int $sampleRate Sample rate in Hertz of the provided audio.
     *           Valid values are: 8000-48000. 16000 is optimal. For best
     *           results, set the sampling rate of the audio source to 16000 Hz.
     *           If that's not possible, use the native sample rate of the audio
     *           source (instead of re-sampling). **Defaults to** `8000` with .amr
     *           files and `16000` with .awb files. If the getID3 library has
     *           been installed this value will default to the value read from
     *           the file's headers (if it exists).
     *     @type string $encoding Encoding of the provided audio. May be one of
     *           `"LINEAR16"`, `"FLAC"`, `"MULAW"`, `"AMR"`, `"AMR_WB"`.
     *           **Defaults to** `"FLAC"` with .flac files, `"AMR"` with .amr
     *           files and `"AMR_WB"` with .awb files.
     *     @type int $maxAlternatives Maximum number of alternatives to be
     *           returned. Valid values are 1-30. **Defaults to** `1`.
     *     @type string $languageCode The language of the content. BCP-47
     *           (e.g., `"en-US"`, `"es-ES"`) language codes are accepted.
     *           **Defaults to** `"en"` (English).
     *     @type bool $profanityFilter If set to `true`, the server will attempt
     *           to filter out profanities, replacing all but the initial
     *           character in each filtered word with asterisks, e.g. \"f***\".
     *           **Defaults to** `false`.
     *     @type array $speechContext Must contain a key `phrases` which is to
     *           be an array of strings which provide "hints" to the speech
     *           recognizer to favor specific words and phrases in the results.
     *           Please see
     *           [SpeechContext](https://cloud.google.com/speech/reference/rest/v1beta1/RecognitionConfig#SpeechContext)
     *           for more information.
     * }
     * @return Operation
     * @throws \InvalidArgumentException
     */
    public function beginRecognizeOperation($audio, array $options = [])
    {
        $response = $this->connection->asyncRecognize(
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
        $analyzedFileInfo = null;
        $fileFormat = null;
        $options += ['detectGcsUri' => true];
        $recognizeOptions = [
            'encoding',
            'sampleRate',
            'languageCode',
            'maxAlternatives',
            'profanityFilter',
            'speechContext'
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

        if (isset($options['encoding'])) {
            $options['encoding'] = strtoupper($options['encoding']);
        } else {
            $analyzedFileInfo = $this->analyzeAudio($audio);

            $options['encoding'] = isset($analyzedFileInfo['fileformat'])
                ? $this->determineEncoding($analyzedFileInfo['fileformat'])
                : $this->determineEncoding($fileFormat);
        }

        if (isset($options['sampleRate'])) {
            $options['sampleRate'] = (int) $options['sampleRate'];
        } else {
            if (!$analyzedFileInfo) {
                $analyzedFileInfo = $this->analyzeAudio($audio);
            }

            $options['sampleRate'] = isset($analyzedFileInfo['audio']['sample_rate'])
                ? $analyzedFileInfo['audio']['sample_rate']
                : $this->determineSampleRate($options['encoding']);
        }

        if (!$options['encoding']) {
            throw new \InvalidArgumentException('Unable to determine encoding. Please provide the value manually.');
        }

        if (!$options['sampleRate']) {
            throw new \InvalidArgumentException('Unable to determine sample rate. Please provide the value manually.');
        }

        foreach ($options as $option => $value) {
            if (in_array($option, $recognizeOptions)) {
                $options['config'][$option] = $value;
                unset($options[$option]);
            }
        }

        return $options;
    }

    /**
     * Analyzes the provided audio using the getid3() library.
     *
     * @param resource|string|StorageObject $audio
     * @return array|null
     */
    private function analyzeAudio($audio)
    {
        $fileInfo = null;
        $isTempResource = false;

        if (class_exists('getID3') && !($audio instanceof StorageObject)) {
            if (is_string($audio) || $this->isRemoteResource($audio)) {
                $audio = $this->getTempResource($audio);
                $isTempResource = true;
            }

            $path = stream_get_meta_data($audio)['uri'];
            $fileInfo = (new \getID3())->analyze($path);

            if ($isTempResource) {
                fclose($audio);
            }
        }

        return $fileInfo;
    }

    /**
     * Takes in a resource or string and makes sure it is available as a local
     * file in order for the getID3 library to be able to analzye it.
     *
     * @param resource|string $audio
     * @return resource
     */
    private function getTempResource($audio)
    {
        $temp = tmpfile();
        is_string($audio) ? fwrite($temp, $audio) : stream_copy_to_stream($audio, $temp);
        return $temp;
    }

    /**
     * Determines if the resource provided is remote.
     *
     * @param resource $audio
     * @return bool
     */
    private function isRemoteResource($audio)
    {
        $scheme = parse_url(
            stream_get_meta_data($audio)['uri'],
            PHP_URL_SCHEME
        );

        return ($scheme === 'http' || $scheme === 'ftp');
    }

    /**
     * Attempts to determine the encoding based on the file format.
     *
     * @param string $fileFormat
     * @return string|null
     */
    private function determineEncoding($fileFormat)
    {
        switch ($fileFormat) {
            case 'flac':
                return 'FLAC';
            case 'amr':
                return 'AMR';
            case 'awb':
                return 'AMR_WB';
            default:
                return null;
        }
    }

    /**
     * Attempts to determine the sample rate based on the encoding.
     *
     * @param string $encoding
     * @return int|null
     */
    private function determineSampleRate($encoding)
    {
        switch ($encoding) {
            case 'AMR':
                return 8000;
            case 'AMR_WB':
                return 16000;
            default:
                return null;
        }
    }
}
