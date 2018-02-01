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

namespace Google\Cloud\Datastore\Connection;

/**
 * Represents a connection to
 * [Datastore](https://cloud.google.com/datastore/).
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     */
    public function allocateIds(array $args);

    /**
     * @param array $args
     */
    public function beginTransaction(array $args);

    /**
     * @param array $args
     */
    public function commit(array $args);

    /**
     * @param array $args
     */
    public function lookup(array $args);

    /**
     * @param array $args
     */
    public function rollback(array $args);

    /**
     * @param array $args
     */
    public function runQuery(array $args);
}
