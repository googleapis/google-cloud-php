<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner\Connection;

use Google\Cloud\LongRunning\LongRunningConnectionInterface;

class LongRunningConnection implements LongRunningConnectionInterface
{
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function get(array $args)
    {
        return $this->connection->getOperation($args);
    }

    public function cancel(array $args)
    {
        return $this->connection->cancelOperation($args);
    }

    public function delete(array $args)
    {
        return $this->connection->deleteOperation($args);
    }

    public function list(array $args)
    {
        return $this->connection->listOperations($args);
    }
}
