<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

/**
 * Represents a speech recognition result.
 *
 * Example:
 * ```
 * use Google\Cloud\Speech\SpeechClient;
 *
 * $speech = new SpeechClient([
 *     'languageCode' => 'en-US'
 * ]);
 *
 * $result = $speech->recognize(
 *     fopen(__DIR__  . '/audio.flac', 'r')
 * );
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/speech/reference/rest/v1/speech/recognize#SpeechRecognitionResult SpeechRecognitionResult
 * @codingStandardsIgnoreEnd
 *
 * @deprecated This class is no longer supported and will be removed in a future
 * release.
 */
class Result
{
    /**
     * @var array
     */
    private $info;

    /**
     * @param array $info Data corresponding to the result.
     */
    public function __construct(array $info)
    {
        $this->info = $info;

        $class = get_class($this);
        $err = "The class {$class} is no longer supported";
        @trigger_error($err, E_USER_DEPRECATED);
    }

    /**
     * Retrieves the alternatives.
     *
     * Example:
     * ```
     * $alternatives = $result->alternatives();
     *
     * foreach ($alternatives as $alternative) {
     *     echo $alternative['transcript'] . PHP_EOL;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1/speech/recognize#SpeechRecognitionAlternative SpeechRecognitionAlternative
     * @codingStandardsIgnoreEnd
     *
     * @return array The transcribed results. Each element of the array contains
     *         a `transcript` key which holds the transcribed text. Optionally
     *         a `confidence` key holding the confidence estimate ranging from
     *         0.0 to 1.0 may be present. `confidence` is typically provided
     *         only for the top hypothesis. If the `enableWordTimeOffsets`
     *         option was set in the request, the top hypothesis will also
     *         contain a list of `wordTimeOffsets`.
     */
    public function alternatives()
    {
        return $this->info['alternatives'];
    }

    /**
     * Retrieves the top alternative. This is typically the most reliable
     * transcription.
     *
     * Example:
     * ```
     * $alternative = $result->topAlternative();
     *
     * echo $alternative['transcript'];
     * ```
     *
     * @return array The top alternative. Contains a `transcript` key which
     *         holds the transcribed text. Optionally a `confidence` key holding
     *         the confidence estimate ranging from 0.0 to 1.0 may be present.
     *         If the `enableWordTimeOffsets` option was set in the request, this
     *         will also contain a list of `wordTimeOffsets`.
     */
    public function topAlternative()
    {
        return $this->info['alternatives'][0];
    }

    /**
     * Retrieves all available result data.
     *
     * Example:
     * ```
     * $info = $result->info();
     *
     * echo $info['alternatives'][0]['transcript'];
     * ```
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }
}
