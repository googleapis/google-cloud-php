<?php
/**
 * Copyright 2024 Google Inc.
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

/**
 * @internal
 */
class MutationGroup
{
    use MutationTrait;

    private array $mutationGroup;
    private ValueMapper $mapper;

    /**
     * @param bool $returnInt64AsObject [optional If true, 64 bit integers will
     *        be returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit
     *        platform compatibility. **Defaults to** false.
     */
    public function __construct($returnInt64AsObject)
    {
        $this->mapper = new ValueMapper($returnInt64AsObject);
        $this->mutationGroup = [];
    }

    /**
     * Add an insert mutation.
     *
     * Example:
     * ```
     * $mutationGroup->insert('Posts', [
     *     'ID' => 10,
     *     'title' => 'My New Post',
     *     'content' => 'Hello World'
     * ]);
     * ```
     *
     * @param string $table The table to insert into.
     * @param array $data The data to insert.
     * @return MutationGroup Current mutation group data object.
     */
    public function insert($table, array $data)
    {
        return $this->insertBatch($table, [$data]);
    }

    /**
     * Add one or more insert mutations.
     *
     * Example:
     * ```
     * $mutationGroup->insertBatch('Posts', [
     *     [
     *         'ID' => 10,
     *         'title' => 'My New Post',
     *         'content' => 'Hello World'
     *     ]
     * ]);
     * ```
     *
     * @param string $table The table to insert into.
     * @param array $dataSet The data to insert.
     * @return MutationGroup Current mutation group, to enable object chaining.
     */
    public function insertBatch($table, array $dataSet)
    {
        $this->enqueue(Operation::OP_INSERT, $table, $dataSet);

        return $this;
    }

    /**
     * Add an update mutation.
     *
     * Example:
     * ```
     * $mutationGroup->update('Posts', [
     *     'ID' => 10,
     *     'title' => 'My New Post [Updated!]',
     *     'content' => 'Modified Content'
     * ]);
     * ```
     *
     * @param string $table The table to update.
     * @param array $data The data to update.
     * @return MutationGroup Current mutation group, to enable object chaining.
     */
    public function update($table, array $data)
    {
        return $this->updateBatch($table, [$data]);
    }

    /**
     * Add one or more update mutations.
     *
     * Example:
     * ```
     * $mutationGroup->updateBatch('Posts', [
     *     [
     *         'ID' => 10,
     *         'title' => 'My New Post [Updated!]',
     *         'content' => 'Modified Content'
     *     ]
     * ]);
     * ```
     *
     * @param string $table The table to update.
     * @param array $dataSet The data to update.
     * @return MutationGroup Current mutation group, to enable object chaining.
     */
    public function updateBatch($table, array $dataSet)
    {
        $this->enqueue(Operation::OP_UPDATE, $table, $dataSet);

        return $this;
    }

    /**
     * Add an insert or update mutation.
     *
     * Example:
     * ```
     * $mutationGroup->insertOrUpdate('Posts', [
     *     'ID' => 10,
     *     'title' => 'My New Post',
     *     'content' => 'Hello World'
     * ]);
     * ```
     *
     * @param string $table The table to insert into or update.
     * @param array $data The data to insert or update.
     * @return MutationGroup Current mutation group, to enable object chaining.
     */
    public function insertOrUpdate($table, array $data)
    {
        return $this->insertOrUpdateBatch($table, [$data]);
    }

    /**
     * Add one or more insert or update mutations.
     *
     * Example:
     * ```
     * $mutationGroup->insertOrUpdateBatch('Posts', [
     *     [
     *         'ID' => 10,
     *         'title' => 'My New Post',
     *         'content' => 'Hello World'
     *     ]
     * ]);
     * ```
     *
     * @param string $table The table to insert into or update.
     * @param array $dataSet The data to insert or update.
     * @return MutationGroup Current mutation group, to enable object chaining.
     */
    public function insertOrUpdateBatch($table, array $dataSet)
    {
        $this->enqueue(Operation::OP_INSERT_OR_UPDATE, $table, $dataSet);

        return $this;
    }

    /**
     * Add an replace mutation.
     *
     * Example:
     * ```
     * $mutationGroup->replace('Posts', [
     *     'ID' => 10,
     *     'title' => 'My New Post [Replaced]',
     *     'content' => 'Hello Moon'
     * ]);
     * ```
     *
     * @param string $table The table to replace into.
     * @param array $data The data to replace.
     * @return MutationGroup Current mutation group, to enable object chaining.
     */
    public function replace($table, array $data)
    {
        return $this->replaceBatch($table, [$data]);
    }

    /**
     * Add one or more replace mutations.
     *
     * Example:
     * ```
     * $mutationGroup->replaceBatch('Posts', [
     *     [
     *         'ID' => 10,
     *         'title' => 'My New Post [Replaced]',
     *         'content' => 'Hello Moon'
     *     ]
     * ]);
     * ```
     *
     * @param string $table The table to replace into.
     * @param array $dataSet The data to replace.
     * @return MutationGroup Current mutation group, to enable object chaining.
     */
    public function replaceBatch($table, array $dataSet)
    {
        $this->enqueue(Operation::OP_REPLACE, $table, $dataSet);

        return $this;
    }

    /**
     * Add an delete mutation.
     *
     * Example:
     * ```
     * $keySet = new KeySet([
     *     'keys' => [10]
     * ]);
     *
     * $mutationGroup->delete('Posts', $keySet);
     * ```
     *
     * @param string $table The table to mutate.
     * @param KeySet $keySet The KeySet to identify rows to delete.
     * @return MutationGroup Current mutation group, to enable object chaining.
     */
    public function delete($table, KeySet $keySet)
    {
        $this->enqueue(Operation::OP_DELETE, $table, [$keySet]);

        return $this;
    }

    public function toArray(): array
    {
        return ['mutations' => $this->mutationGroup];
    }

    /**
     * Format, validate and enqueue mutations in the transaction.
     *
     * @param string $op The operation type.
     * @param string $table The table name
     * @param array $dataSet the mutations to enqueue
     * @return void
     */
    private function enqueue($op, $table, array $dataSet)
    {
        foreach ($dataSet as $data) {
            if ($op === Operation::OP_DELETE) {
                $this->mutationGroup[] = $this->deleteMutation($table, $data);
            } else {
                $this->mutationGroup[] = $this->mutation($op, $table, $data);
            }
        }
    }
}
