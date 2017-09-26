<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

class WriteBatch
{
    use ArrayTrait;

    const TYPE_UPDATE = 'update';
    const TYPE_DELETE = 'delete';
    const TYPE_VERIFY = 'verify';
    const TYPE_TRANSFORM = 'transform';

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string|null
     */
    private $transactionId;

    /**
     * @var array
     */
    private $writes = [];

    /**
     * @var bool
     */
    private $hasPreviousTransform = false;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Firestore
     * @param ValueMapper $valueMapper A Value Mapper instance
     * @param string $database The current database
     * @param string|null $transactionId The transaction to run commits in.
     *        **Defaults to** `null`.
     */
    public function __construct(ConnectionInterface $connection, $valueMapper, $database, $transactionId = null)
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->database = $database;
        $this->transactionId = $transactionId;
    }

    public function update($documentName, array $fields, array $options = [])
    {
        if ($this->hasPreviousTransform) {
            throw new \BadMethodCallException(
                'Cannot apply an UPDATE operation after a TRANSFORM operation has been enqueued.'
            );
        }

        $options += [
            'updateMask' => null
        ];

        $this->writes[] = $this->createDatabaseWrite(self::TYPE_UPDATE, $documentName, [
            'fields' => $this->valueMapper->decodeFieldPaths(
                $this->valueMapper->encodeValues($fields)
            ),
            'updateMask' => ($options['updateMask'] !== null)
                ? $options['updateMask']
                : $this->valueMapper->encodeFieldPaths($fields)
        ] + $options);
    }

    public function set($documentName, array $fields, $merge = false)
    {
        if ($this->hasPreviousTransform) {
            throw new \BadMethodCallException(
                'Cannot apply an UPDATE operation after a TRANSFORM operation has been enqueued.'
            );
        }

        $write = array_filter([
            'fields' => $this->valueMapper->encodeValues($fields),
            'updateMask' => $merge ? $this->valueMapper->encodeFieldPaths($fields) : null
        ]);

        $this->writes[] = $this->createDatabaseWrite(self::TYPE_UPDATE, $documentName, $write);
    }

    public function delete($documentName, array $options = [])
    {
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_DELETE, $documentName, $options);
    }

    public function verify($documentName, array $options = [])
    {
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_VERIFY, $documentName, $options);
    }

    public function transform($documentName, array $transforms = [], array $options = [])
    {
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_TRANSFORM, $documentName, [
            'fieldTransforms' => $transforms
        ] + $options);
        $this->hasPreviousTransform = true;
    }

    /**
     * Commit writes to the database.
     *
     * @codingStandardsIgnoreStart
     * @see https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.Commit Commit
     *
     * @param array $options Configuration Options
     * @return array [https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#commitresponse](CommitResponse)
     * @codingStandardsIgnoreEnd
     */
    public function commit(array $options = [])
    {
        print_r($this->writes);exit;
        $response = $this->connection->commit(array_filter([
            'database' => $this->database,
            'writes' => $this->writes,
            'transaction' => $this->transactionId
        ]) + $options);

        if (isset($response['commitTime'])) {
            $response['commitTime'] = $this->valueMapper->createTimestampWithNanos($response['commitTime']);
        }

        if (isset($response['writeResults'])) {
            foreach ($response['writeResults'] as &$result) {
                if (isset($result['updateTime'])) {
                    $result['updateTime'] = $this->valueMapper->createTimestampWithNanos($result['updateTime']);
                }
            }
        }

        return $response;
    }

    /**
     * Rollback a transaction.
     *
     * Example:
     * ```
     * $batch->rollback();
     * ```
     *
     * @param array $options Configuration Options
     * @return void
     */
    public function rollback(array $options = [])
    {
        if (!$this->transactionId) {
            throw new \BadMethodCallException('Cannot rollback because no transaction id was provided.');
        }

        $this->connection->rollback([
            'database' => $this->database,
            'transaction' => $this->transactionId
        ] + $options);
    }

    /**
     * @param string $type The write operation type.
     * @param string $name The document name to update.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type array $updateMask A list of field paths to update in this document.
     *     @type array $currentDocument An optional precondition.
     *     @type array $fields An array of document fields and their values. Required
     *           if $type is `update`.
     * }
     * @return array
     */
    private function createDatabaseWrite($type, $name, array $options = [])
    {
        return array_filter([
            'updateMask' => $this->pluck('updateMask', $options, false),
            'currentDocument' => $this->pluck('currentDocument', $options, false),
        ]) + $this->createDatabaseWriteOperation($type, $name, $options);
    }

    private function createDatabaseWriteOperation($type, $name, array $options = [])
    {
        switch ($type) {
            case 'update':
                return ['update' => [
                    'name' => $name,
                    'fields' => $this->pluck('fields', $options)
                ]];
                break;

            case 'delete':
                return ['delete' => $name];
                break;

            case 'verify':
                return ['verify' => $name];
                break;

            case 'transform':
                throw new \BadMethodCallException('not implemented');
                break;

            default:
                throw new \BadMethodCallException(sprintf(
                    'Write operation type `%s is not valid. Allowed values are update, delete, verify, transform.',
                    $type
                ));
                break;
        }
    }
}
