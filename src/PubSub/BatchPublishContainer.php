<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\PubSub;

/**
 * A container whose job is to execute queued items from the batch.
 *
 * @internal
 */
class BatchPublishContainer
{
    /**
     * @var array
     */
    private static $topics = [];

    /**
     * @var string
     */
    private $topicName;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * @var bool
     */
    private $debugOutput;

    /**
     * @param string $topicName
     * @param array $clientConfig
     * @param bool $debugOutput
     */
    public function __construct($topicName, array $clientConfig, $debugOutput)
    {
        $this->topicName = $topicName;
        $this->clientConfig = $clientConfig;
        $this->debugOutput = $debugOutput;
    }

    /**
     * @param array $items
     * @return bool
     */
    public function send(array $items)
    {
        $start = microtime(true);
        try {
            $this->getTopic()->publishBatch($items);
        } catch (\Exception $e) {
            fwrite(STDERR, $e->getMessage() . PHP_EOL);
            return false;
        }
        $end = microtime(true);
        if ($this->debugOutput) {
            printf(
                '%f seconds for publishing %d messages' . PHP_EOL,
                $end - $start,
                count($entries)
            );
            printf('memory used: %d' . PHP_EOL, memory_get_usage());
        }
        return true;
    }

    /**
     * @return Topic
     */
    private function getTopic()
    {
        if (!array_key_exists($this->topicName, self::$topics)) {
            $client = new PubSubClient($this->clientConfig);
            self::$topics[$this->topicName] = $client->topic($this->topicName);
        }
        return self::$topics[$this->topicName];
    }
}
