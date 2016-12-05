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

namespace Google\Cloud\Spanner\Admin;

use Google\Cloud\Spanner\Admin\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminApi;

class Database
{
    private $connection;

    private $projectId;

    private $name;

    private $info;

    public function __construct(ConnectionInterface $connection, $projectId, $name, array $info = [])
    {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->name = $name;
        $this->info = $info;
    }

    public function name()
    {
        return $this->name;
    }

    public function info()
    {
        return $this->info;
    }

    public function update($statements, array $options = [])
    {
        if (!is_array($statements)) {
            $statements = [$statements];
        }

        $res = $this->connection->updateDatabase([
            'name' => DatabaseAdminApi::formatDatabaseName($this->projectId, $this->instance)
        ]);
    }

    public function drop() {}

    public function ddl() {}

    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info
        ];
    }
}
