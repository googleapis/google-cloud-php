<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable;

use Google\ApiCore\ValidationException;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Core\Exception\NotFoundException;

/**
 * Represents a Cloud Bigtable Instance Configuration.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\BigtableClient;
 *
 * $bigtable = new BigtableClient();
 *
 * $configuration = $bigtable->instanceConfiguration('regional-europe-west');
 * ```
 */
class InstanceConfiguration
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
    private $name;

    /**
     * @var array
     */
    private $info;

    /**
     * Create an instance configuration object.
     *
     * @param ConnectionInterface $connection A service connection for the
     *        Bigtable API.
     * @param string $projectId The current project ID.
     * @param string $name The configuration name or ID.
     * @param array $info [optional] A service representation of the
     *        configuration.
     */
    public function __construct(
        ConnectionInterface $connection,
        $projectId,
        $name,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedConfigName($name, $projectId);
        $this->info = $info;
    }

    /**
     * Return the configuration name.
     *
     * Example:
     * ```
     * $name = $configuration->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Return the service representation of the configuration.
     *
     * This method may require a service call.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/bigtable.admin` scope.
     *
     * Example:
     * ```
     * $info = $configuration->info();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] Configuration options.
     * @return array [InstanceConfig](https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#instanceconfig)
     * @codingStandardsIgnoreEnd
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Check if the configuration exists.
     *
     * This method requires a service call.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/bigtable.admin` scope.
     *
     * Example:
     * ```
     * if ($configuration->exists()) {
     *    echo 'Configuration exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->reload($options = []);
        } catch (NotFoundException $e) {
            return false;
        }
        return true;
    }

    /**
     * Fetch a fresh representation of the configuration from the service.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/bigtable.admin` scope.
     *
     * Example:
     * ```
     * $info = $configuration->reload();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] Configuration options.
     * @return array [InstanceConfig](https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#instanceconfig)
     * @codingStandardsIgnoreEnd
     */
    public function reload(array $options = [])
    {
        $this->info = $this->connection->getInstanceConfig($options + [
            'name' => $this->name,
            'projectId' => $this->projectId
        ]);

        return $this->info;
    }

    /**
     * A more readable representation of the object.
     *
     * @codeCoverageIgnore
     * @access private
     */
    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info,
        ];
    }

    /**
     * Get the fully qualified instance config name.
     *
     * @param string $name The configuration name.
     * @param string $projectId The project ID.
     * @return string
     */
    private function fullyQualifiedConfigName($name, $projectId)
    {
        try {
            return InstanceAdminClient::instanceName(
                $projectId,
                $name
            );
        } catch (ValidationException $e) {
            return $name;
        }
    }
}
