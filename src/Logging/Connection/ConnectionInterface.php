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

namespace Google\Cloud\Logging\Connection;

/**
 * Represents a connection to
 * [Stackdriver Logging](https://cloud.google.com/logging/).
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     * @return array
     */
    public function writeEntries(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listEntries(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function createSink(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getSink(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listSinks(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function updateSink(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function deleteSink(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function createMetric(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getMetric(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function listMetrics(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function updateMetric(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function deleteMetric(array $args = []);
    /**
     * @param array $args
     * @return array
     */
    public function deleteLog(array $args = []);
}
