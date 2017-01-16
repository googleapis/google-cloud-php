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

namespace Google\Cloud\LongRunning;

class Operation
{
    private $connection;
    private $name;
    private $type;
    private $info;

    public function __construct(LongRunningConnectionInterface $connection, $type, array $info = [])
    {
        $this->connection = $connection;
        $this->name = $name;
        $this->type = $type;
        $this->info = $info;
    }

    public function name()
    {
        return $this->name;
    }

    public function reload(array $options = [])
    {
        $this->info = $info = $this->connection->getOperation([
            'name' => $this->name,
            'type' => $this->type
        ] + $options);

        return $info;
    }

    public function info(array $options = [])
    {
        return $this->info ?: $this->reload($options);
    }

    public function wait(array $options = [])
    {
        do {
            $this->reload($options);
        } while(true);
    }

    public function cancel(array $options = [])
    {
        return $this->connection->cancelOperation([
            'name' => $this->name
        ] + $options);
    }

    public function delete(array $options = [])
    {
        return $this->connection->deleteOperation([
            'name' => $this->name
        ] + $options);
    }
}
