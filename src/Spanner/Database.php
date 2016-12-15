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

namespace Google\Cloud\Spanner;

use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Iam\Iam;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminApi;
use Google\Cloud\Spanner\Connection\AdminConnectionInterface;
use Google\Cloud\Spanner\Connection\IamDatabase;

/**
 * Represents a Google Cloud Spanner Database
 *
 * Example:
 * ```
 * $database = $instance->database('my-database');
 * ```
 */
class Database
{
    /**
     * @var AdminConnectionInterface
     */
    private $adminConnection;

    /**
     * @var Instance
     */
    private $instance;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Iam
     */
    private $iam;

    /**
     * Create an object representing a Database.
     *
     * @param AdminConnectionInterface $adminConnection The connection to the
     *        Google Cloud Spanner Admin API.
     * @param Instance $instance The instance in which the database exists.
     * @param string $projectId The project ID.
     * @param string $name The database name.
     * @param array $info [optional] A representation of the database object.
     */
    public function __construct(
        AdminConnectionInterface $adminConnection,
        Instance $instance,
        $projectId,
        $name
    ) {
        $this->adminConnection = $adminConnection;
        $this->instance = $instance;
        $this->projectId = $projectId;
        $this->name = $name;
        $this->iam = new Iam(
            new IamDatabase($this->adminConnection),
            $this->fullyQualifiedDatabaseName()
        );
    }

    /**
     * Return the simple database name.
     *
     * Example:
     * ```
     * $name = $database->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Check if the database exists.
     *
     * This method sends a service request.
     *
     * Example:
     * ```
     * if ($database->exists()) {
     *     echo 'The database exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->adminConnection->getDatabaseDDL($options + [
                'name' => $this->fullyQualifiedDatabaseName()
            ]);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Update the Database.
     *
     * Example:
     * ```
     * $database->update([
     *     'CREATE TABLE Users (
     *         id INT64 NOT NULL,
     *         name STRING(100) NOT NULL
     *         password STRING(100) NOT NULL
     *     )'
     * ]);
     * ```
     *
     * @param string|array $statements One or more DDL statements to execute.
     * @param array $options [optional] Configuration options.
     * @return <something>
     */
    public function update($statements, array $options = [])
    {
        $options += [
            'operationId' => null
        ];

        if (!is_array($statements)) {
            $statements = [$statements];
        }

        return $this->adminConnection->updateDatabase($options + [
            'name' => $this->fullyQualifiedDatabaseName(),
            'statements' => $statements,
        ]);
    }

    /**
     * Drop the database.
     *
     * Example:
     * ```
     * $database->drop();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function drop(array $options = [])
    {
        return $this->adminConnection->dropDatabase($options + [
            'name' => $this->fullyQualifiedDatabaseName()
        ]);
    }

    /**
     * Get a list of all database DDL statements.
     *
     * Example:
     * ```
     * $statements = $database->ddl();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function ddl(array $options = [])
    {
        $ddl = $this->adminConnection->getDatabaseDDL($options + [
            'name' => $this->fullyQualifiedDatabaseName()
        ]);

        if (isset($ddl['statements'])) {
            return $ddl['statements'];
        }

        return [];
    }

    /**
     * Manage the database IAM policy
     *
     * Example:
     * ```
     * $iam = $database->iam();
     * ```
     *
     * @return Iam
     */
    public function iam()
    {
        return $this->iam;
    }

    /**
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'adminConnection' => get_class($this->adminConnection),
            'projectId' => $this->projectId,
            'name' => $this->name
        ];
    }

    /**
     * Convert the simple database name to a fully qualified name.
     *
     * @return string
     */
    private function fullyQualifiedDatabaseName()
    {
        return DatabaseAdminApi::formatDatabaseName(
            $this->projectId,
            $this->instance->name(),
            $this->name
        );
    }
}
