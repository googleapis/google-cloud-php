<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

use InvalidArgumentException;

/**
 * Provides helper functions for generated Speech clients.
 */
trait SpeechHelpersTrait
{
    /**
     * A list of allowed url schemes.
     *
     * @var array
     */
    private static $urlSchemes = [
        'gs'
    ];

    /**
     * @param string                           $recognitionAudioClass
     * @param resource|string|RecognitionAudio $audio
     * @return mixed A RecognitionAudio instance matching the requested version of Speech
     */
    private function createRecognitionAudioHelper($recognitionAudioClass, $audio)
    {
        if ($audio instanceof $recognitionAudioClass) {
            return $audio;
        }
        $recognitionAudio = new $recognitionAudioClass();
        if (is_string($audio)) {
            if (in_array(parse_url($audio, PHP_URL_SCHEME), self::$urlSchemes)) {
                $recognitionAudio->setUri($audio);
            } else {
                $recognitionAudio->setContent($audio);
            }
        } elseif (is_resource($audio)) {
            $recognitionAudio->setContent(stream_get_contents($audio));
        } else {
            throw new InvalidArgumentException(
                'Given $audio is not valid. ' .
                'Audio must be a RecognitionAudio ' .
                'object, a string of bytes, a valid ' .
                'Google Cloud Storage URI, or a resource.'
            );
        }
        return $recognitionAudio;
    }

    /**
     * @param string $requestClass
     * @param iterable|resource|string $audio
     * @return mixed An iterable of StreamingRecognizeRequest instances matching the requested version of Speech
     */
    private function createStreamingRequestsHelper($requestClass, $audio)
    {
        // First, convert string/resource audio into an iterable
        if (is_string($audio)) {
            $audio = [$audio];
        }
        if (is_resource($audio)) {
            $audio = $this->createAudioStreamFromResource($audio);
        }

        // For each chuck in iterable $audio, convert to a request if necessary
        foreach ($audio as $audioChunk) {
            if (is_object($audioChunk) && $audioChunk instanceof $requestClass) {
                yield $audioChunk;
            } elseif (is_string($audioChunk)) {
                $request = new $requestClass();
                $request->setAudioContent($audioChunk);
                yield $request;
            } else {
                throw new InvalidArgumentException(
                    'Found invalid audio chunk in $audio. ' .
                    'Audio must be a resource, a string of ' .
                    'bytes, or an iterable of StreamingRecognizeRequest[] ' .
                    'or string[].'
                );
            }
        }
    }

    /**
     * Convert a PHP resource instance into an iterable of data "chunks".
     *
     * @param resource $resource   The resource object to read data from.
     * @param int      $chunkSize  The chunk size to use, in bytes. Defaults to 32000
     * @return \Generator<string>   An iterable of strings that have been read from the resource.
     */
    public function createAudioStreamFromResource($resource, $chunkSize = 32000)
    {
        while (!feof($resource)) {
            $chunk = fread($resource, $chunkSize);
            if (strlen($chunk) > 0) {
                yield $chunk;
            }
        }
    }
}
