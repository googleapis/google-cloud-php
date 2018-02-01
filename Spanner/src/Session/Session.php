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

namespace Google\Cloud\Spanner\Session;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Represents and manages a single Cloud Spanner session.
 */
class Session
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $instance;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int|null
     */
    private $expiration;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Spanner.
     * @param string $projectId The project ID.
     * @param string $instance The instance name.
     * @param string $database The database name.
     * @param string $name The session name.
     */
    public function __construct(
        ConnectionInterface $connection,
        $projectId,
        $instance,
        $database,
        $name
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->instance = $instance;
        $this->database = $database;
        $this->name = $name;
    }

    /**
     * Return info on the session.
     *
     * @return array An array containing the `projectId`, `instance`, `database` and session `name` keys.
     */
    public function info()
    {
        return [
            'projectId' => $this->projectId,
            'instance' => $this->instance,
            'database' => $this->database,
            'name' => $this->name
        ];
    }

    /**
     * Check if the session exists.
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->connection->getSession($options + [
                'name' => $this->name(),
                'database' => $this->database
            ]);

            return true;
        } catch (NotFoundException $e) {
            return false;
        }
    }

    /**
     * Delete the session.
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function delete(array $options = [])
    {
        return $this->connection->deleteSession($options + [
            'name' => $this->name(),
            'database' => $this->database
        ]);
    }

    /**
     * Format the constituent parts of a session name into a fully qualified session name.
     *
     * @return string
     */
    public function name()
    {
        return SpannerClient::sessionName(
            $this->projectId,
            $this->instance,
            $this->database,
            $this->name
        );
    }

    /**
     * Sets the expiration.
     *
     * @param int $expiration [optional] The Unix timestamp in seconds upon
     *        which the session will expire.  **Defaults to** now plus 60
     *        minutes.
     * @return int
     */
    public function setExpiration($expiration = null)
    {
        $this->expiration = $expiration ?: time() + SessionPoolInterface::SESSION_EXPIRATION_SECONDS;
    }

    /**
     * Gets the expiration.
     *
     * @return int|null
     */
    public function expiration()
    {
        return $this->expiration;
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
            'connection' => get_class($this->connection),
            'projectId' => $this->projectId,
            'instance' => $this->instance,
            'database' => $this->database,
            'name' => $this->name,
        ];
    }
}
