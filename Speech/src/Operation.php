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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Speech\Connection\ConnectionInterface;

/**
 * Represents a long-running operation that is the result of a network API call.
 *
 * Example:
 * ```
 * use Google\Cloud\Speech\SpeechClient;
 *
 * $speech = new SpeechClient([
 *     'languageCode' => 'en-US'
 * ]);
 *
 * $operation = $speech->beginRecognizeOperation(
 *     fopen(__DIR__  . '/audio.flac', 'r')
 * );
 * ```
 *
 * @deprecated This class is no longer supported and will be removed in a future
 * release.
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
     * @param array $info [optional] The operation's data.
     */
    public function __construct(ConnectionInterface $connection, $name, array $info = [])
    {
        $this->connection = $connection;
        $this->name = $name;
        $this->info = $info;

        $class = get_class($this);
        $err = "The class {$class} is no longer supported";
        @trigger_error($err, E_USER_DEPRECATED);
    }

    /**
     * Check whether or not the operation is complete. A network request will be
     * triggered if no cached data exists.
     *
     * Example:
     * ```
     * if ($operation->isComplete()) {
     *     echo "The operation is complete!";
     * }
     * ```
     *
     * @param array $options [optional] Configuration Options.
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
     *     $results = $operation->results();
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/speech/reference/rest/v1/speech/recognize#SpeechRecognitionResult SpeechRecognitionResult
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
     * @return Result[]
     */
    public function results(array $options = [])
    {
        $info = $this->info($options);
        $results = [];

        if (!isset($info['response']['results'])) {
            return $results;
        }

        foreach ($info['response']['results'] as $result) {
            $results[] = new Result($result);
        }

        return $results;
    }

    /**
     * Check whether or not the operation exists.
     *
     * Example:
     * ```
     * if ($operation->exists()) {
     *     echo "The operation exists.";
     * }
     * ```
     *
     * @param array $options [optional] Configuration Options.
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
     * @see https://cloud.google.com/speech/reference/rest/v1/operations/get Operations get API documentation.
     * @see https://cloud.google.com/speech/reference/rest/v1/operations#Operation Operation resource documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
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
     * @see https://cloud.google.com/speech/reference/rest/v1/operations/get Operations get API documentation.
     * @see https://cloud.google.com/speech/reference/rest/v1/operations#Operation Operation resource documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
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
