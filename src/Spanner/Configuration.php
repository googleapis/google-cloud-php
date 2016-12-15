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
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminApi;
use Google\Cloud\Spanner\Connection\AdminConnectionInterface;

/**
 * Represents a Cloud Spanner Configuration
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $spanner = $cloud->spanner();
 *
 * $configuration = $spanner->configuration('regional-europe-west');
 * ```
 */
class Configuration
{
    /**
     * @var AdminConnectionInterface
     */
    private $adminConnection;

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
     * Create a configuration instance.
     *
     * @param AdminConnectionInterface $adminConnection A service connection for the Spanner Admin API.
     * @param string $projectId The current project ID.
     * @param string $name The simple configuration name.
     * @param array $info [optional] A service representation of the configuration.
     */
    public function __construct(
        AdminConnectionInterface $adminConnection,
        $projectId,
        $name,
        array $info = []
    ) {
        $this->adminConnection = $adminConnection;
        $this->projectId = $projectId;
        $this->name = $name;
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
     * Example:
     * ```
     * $info = $configuration->info();
     * echo $info['nodeCount'];
     * ```
     *
     * @param array $options [optional] Configuration options.
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
     * Check if the configuration exists.
     *
     * This method requires a service call.
     *
     * Example:
     * ```
     * if ($configuration->exists()) {
     *    echo 'The configuration exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
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
     * Example:
     * ```
     * $info = $configuration->reload();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        $this->info = $this->adminConnection->getConfig($options + [
            'name' => InstanceAdminApi::formatInstanceConfigName($this->projectId, $this->name),
            'projectId' => $this->projectId
        ]);

        return $this->info;
    }
}
