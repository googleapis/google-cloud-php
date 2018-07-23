<?php
/**
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

use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient as TableAdminClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LROTrait;

/**
 * Represents a Cloud Bigtable table
 *
 * Example:
 * ```
 * $table = $instance->table('my-table');
 * ```
 *
 * @method LongRunningOperation resumeOperation() {
 *     Resume a Long Running Operation
 *
 *     Example:
 *     ```
 *     $operation = $table->resumeOperation($operationName);
 *     ```
 *
 *     @param string $operationName The Long Running Operation name.
 *     @param array $info [optional] The operation data.
 *     @return LongRunningOperation
 * }
 */
class Table
{
    use LROTrait;

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
    private $instanceId;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $info;

    /**
     *
     * @param ConnectionInterface $connection The connection to the
     *        Cloud Bigtable Admin API.
     * @param LongRunningConnectionInterface $lroConnection An implementation
     *        mapping to methods which handle LRO resolution in the service.
     * @param array $lroCallables An collection of form [(string) typeUrl, (callable) callable]
     *        providing a function to invoke when an operation completes. The
     *        callable Type should correspond to an expected value of
     *        operation.metadata.typeUrl.
     * @param string $projectId The project ID.
     * @param string $instanceId The instance ID.
     * @param string $tableId The table ID.
     * @param array $info [optional] A representation of the table object.
     * @throws \InvalidArgumentException if invalid argument
     */
    public function __construct(
        ConnectionInterface $connection,
        LongRunningConnectionInterface $lroConnection,
        array $lroCallables,
        $projectId,
        $instanceId,
        $tableId,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->validate($instanceId, 'instance');
        $this->instanceId = $instanceId;
        $this->validate($tableId, 'table');
        $this->name = TableAdminClient::tableName($projectId, $instanceId, $tableId);
        $this->id = $tableId;
        $this->info = $info;
        $this->setLroProperties($lroConnection, $lroCallables, $this->name);
    }

    /**
     * Return the table name.
     *
     * Example:
     * ```
     * $name = $table->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Return the table id.
     *
     * Example:
     * ```
     * $tableId = $table->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Return the service representation of the table.
     *
     * This method may require a service call.
     *
     *
     * @param array $options [optional] Configuration options.
     */
    public function info(array $options = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * Check if the table exists.
     *
     * This method requires a service call.
     *
     *
     * @param array $options [optional] Configuration options.
     */
    public function exists(array $options = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * Fetch a fresh representation of the table from the service.
     *
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#google.bigtable.admin.v2.GetTableRequest GetTableRequest
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#table Table
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     */
    public function reload(array $options = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * Return the table state.
     *
     * When tables are created or updated, they may take some time before
     * they are ready for use. This method allows for checking whether an
     * table is ready.
     *
     *
     * @param array $options [optional] Configuration options.
     */
    public function state(array $options = [])
    {
        throw new \BadMethodCallException('This method is not implemented yet');
    }

    /**
     * Create a table.
     *
     * Example:
     * ```
     * $tableInfo = $table->create();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#google.bigtable.admin.v2.CreateTableRequest CreateTableRequest
     * @codingStandardsIgnoreEnd
     *
     * @return array Table information
     *
     * @throws \InvalidArgumentException
     */
    public function create()
    {
        $instanceName = TableAdminClient::instanceName($this->projectId, $this->instanceId);
        $this->info = $this->connection->createTable([
            'parent' => $instanceName,
            'tableId' => $this->id
        ]);

        return $this->info;
    }

    /**
     * Delete table.
     *
     * Example:
     * ```
     * $table->delete();
     * ```
     *
     * @return void
     */
    public function delete()
    {
        return $this->connection->deleteTable([
            'name' => $this->name
        ]);
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
            'instanceId' => $this->instanceId,
            'tableId' => $this->id,
            'name' => $this->name,
            'info' => $this->info
        ];
    }

    /**
     * Check invalid exception
     *
     * @param string $value value to be validated for emptiness or containing '/' character.
     * @param string $text type of value to be validated.
     *
     * @throws \InvalidArgumentException
     */
    private function validate($value, $text)
    {
        if (empty($value) || strpos($value, '/') !== false) {
            throw new \InvalidArgumentException(
                "Please pass the {$text} id, rather than the fully-qualified resource name."
            );
        }
    }
}
