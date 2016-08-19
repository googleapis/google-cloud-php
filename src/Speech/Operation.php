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

use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Speech\Connection\ConnectionInterface;

/**
 * Represents a long-running operation that is the result of a network API call.
 *
 * Example:
 * ```
 * $operation = $speech->beginRecognizeOperation(
 *     fopen(__DIR__  . '/audio.flac', 'r')
 * );
 * ```
 */
class Operation
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $info;

    /**
     * @param ConnectionInterface $connection Represents a connection to the
     *        Google Cloud Speech API.
     * @param string $name The operation's name.
     * @param array $info The operation's data.
     */
    public function __construct(ConnectionInterface $connection, $name, array $info = [])
    {
        $this->connection = $connection;
        $this->name = $name;
        $this->info = $info;
    }

    /**
     * Check whether or not the operation is complete. A network request will be
     * triggered if no cached data exists.
     *
     * Example:
     * ```
     * if ($operation->isComplete()) {
     *     print_r($operation->results());
     * }
     * ```
     *
     * @param array $options Configuration options.
     * @return bool
     */
    public function isComplete(array $options = [])
    {
        $info = $this->info($options);

        return (isset($info['done']) && $info['done']);
    }

    /**
     * Retrieves the results of the operation. A network request will be
     * triggered if no cached data exists.
     *
     * Example:
     * ```
     * if ($operation->isComplete()) {
     *     print_r($operation->results());
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/speech/syncrecognize#SpeechRecognitionAlternative SpeechRecognitionAlternative
     * @codingStandardsIgnoreEnd
     *
     * @param array $options Configuration options.
     * @return array The transcribed results. Each element of the array contains
     *         a `transcript` key which holds the transcribed text. Optionally
     *         a `confidence` key holding the confidence estimate ranging from
     *         0.0 to 1.0 may be present. `confidence` is typically provided
     *         only for the top hypothesis.
     */
    public function results(array $options = [])
    {
        $info = $this->info($options);

        return isset($info['response']['results'])
            ? $info['response']['results'][0]['alternatives']
            : [];
    }

    /**
     * Check whether or not the operation exists.
     *
     * Example:
     * ```
     * $operation->exists();
     * ```
     *
     * @param array $options Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->info($options);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    /**
     * Retrieves the operation's details. If no data is cached a network request
     * will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $operation->info();
     * print_r($info['response']);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/operations/get Operations get API documentation.
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/operations#Operation Operation resource documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options Configuration options.
     * @return array
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Triggers a network request to reload the operation's details.
     *
     * Example:
     * ```
     * $operation->reload();
     * $info = $operation->info();
     * print_r($info['response']);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/operations/get Operations get API documentation.
     * @see https://cloud.google.com/speech/reference/rest/v1beta1/operations#Operation Operation resource documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getOperation($options + [
            'name' => $this->name
        ]);
    }

    /**
     * Returns the operation's name.
     *
     * Example:
     * ```
     * echo $operation->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
