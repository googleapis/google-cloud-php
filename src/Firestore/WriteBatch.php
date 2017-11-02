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

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Firestore\V1beta1\DocumentTransform_FieldTransform_ServerValue;

/**
 * Enqueue and write multiple mutations to Cloud Firestore
 *
 * This class may be used directly for multiple non-transactional writes. To
 * run changes in a transaction (with automatic retry/rollback on failure),
 * use {@see Google\Cloud\Firestore\Transaction}. Single modifications can be
 * made using the various methods on {@see Google\Cloud\Firestore\DocumentReference}.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $batch = $firestore->batch();
 * ```
 */
class WriteBatch
{
    use ArrayTrait;
    use DebugInfoTrait;
    use ValidateTrait;

    const TYPE_UPDATE = 'update';
    const TYPE_DELETE = 'delete';
    const TYPE_TRANSFORM = 'transform';

    const REQUEST_TIME = DocumentTransform_FieldTransform_ServerValue::REQUEST_TIME;

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
    private $transaction;

    /**
     * @var array
     */
    private $writes = [];

    /**
     * @param ConnectionInterface $connection A connection to Cloud Firestore
     * @param ValueMapper $valueMapper A Value Mapper instance
     * @param string $database The current database
     * @param string|null $transaction The transaction to run commits in.
     *        **Defaults to** `null`.
     */
    public function __construct(ConnectionInterface $connection, $valueMapper, $database, $transaction = null)
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->database = $database;
        $this->transaction = $transaction;
    }

    /**
     * Enqueue a document creation.
     *
     * This operation will fail (when committed) if the document already exists.
     *
     * Example:
     * ```
     * $batch->create($documentName, [
     *     'name' => 'John'
     * ]);
     * ```
     *
     * @param string $documentName The document to create.
     * @param array $fields An array containing field names paired with their value.
     *        Accepts a nested array, or a simple array of field paths.
     * @return WriteBatch
     */
    public function create($documentName, array $fields, array $options = [])
    {
        return $this->update($documentName, $fields, [
            'precondition' => ['exists' => false]
        ] + $options);
    }

    /**
     * Enqueue a set mutation.
     *
     * Replaces all fields in a Firestore document.
     *
     * Example:
     * ```
     * $batch->set($documentName, [
     *     'name' => 'John'
     * ]);
     *
     * @codingStandardsIgnoreStart
     * @param string $documentName The document to update.
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\WriteBatch::update()},
     *        field paths are NOT supported by this method.
     * @param array $options {
     *     Configuration Options
     *
     *     @type bool $merge If true, unwritten fields will be preserved.
     *           Otherwise, they will be overwritten (removed). **Defaults to**
     *           `false`.
     * }
     * @return WriteBatch
     * @codingStandardsIgnoreEnd
     */
    public function set($documentName, array $fields, array $options = [])
    {
        $options += [
            'merge' => false
        ];

        list($fields, $timestamps) = $this->valueMapper->findSentinels($fields);

        if ($fields) {
            $write = array_filter([
                'fields' => $this->valueMapper->encodeValues($fields),
                'updateMask' => $options['merge'] ? $this->valueMapper->encodeFieldPaths($fields) : null
            ]);

            $this->writes[] = $this->createDatabaseWrite(self::TYPE_UPDATE, $documentName, $write);
        }

        // Setting values to the server timestamp is implemented as a document tranformation.
        $this->updateTransformations($documentName, $timestamps);

        return $this;
    }

    /**
     * Enqueue an update to a Firestore document.
     *
     * Merges provided data with data stored in Firestore.
     *
     * Calling this method on a non-existent document will raise an exception.
     *
     * This method supports various sentinel values, to perform special operations
     * on fields. Available sentinel values are provided as methods, found in
     * {@see Google\Cloud\Firestore\FieldValue}.
     *
     * To update a document using field paths, see
     * {@see Google\Cloud\Firestore\WriteBatch::updatePaths()}.
     *
     * Example:
     * ```
     * $batch->update($documentName, [
     *     'name' => 'John'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param string $documentName The document to update.
     * @param array $fields An array containing field names paired with their value.
     * @param array $options Configuration options
     * @return WriteBatch
     * @codingStandardsIgnoreEnd
     */
    public function update($documentName, array $fields, array $options = [])
    {
        $options += [
            'precondition' => ['exists' => true]
        ];

        list($fields, $timestamps, $deletes) = $this->valueMapper->findSentinels($fields);

        // We only want to enqueue an update write if there are non-sentinel fields
        // OR no timestamp sentinels are found.
        // We MUST always enqueue at least one write, so if there are no fields
        // and no timestamp sentinels, we can assume an empty write is intended
        // and enqueue an empty UPDATE operation.
        if ($fields || !$timestamps) {
            $this->writes[] = $this->createDatabaseWrite(self::TYPE_UPDATE, $documentName, [
                'fields' => $this->valueMapper->encodeValues($fields),
                'updateMask' => array_merge($this->valueMapper->encodeFieldPaths($fields), $deletes)
            ] + $options);
        }

        // Setting values to the server timestamp is implemented as a document tranformation.
        $this->updateTransformations($documentName, $timestamps);

        return $this;
    }

    /**
     * Enqueue an update with field paths and values.
     *
     * Merges provided data with data stored in Firestore.
     *
     * Calling this method on a non-existent document will raise an exception.
     *
     * This method supports various sentinel values, to perform special operations
     * on fields. Available sentinel values are provided as methods, found in
     * {@see Google\Cloud\Firestore\FieldValue}.
     *
     * Note that field names must be provided using field paths, encoded either
     * as a dot-delimited string (i.e. `foo.bar`), or an instance of
     * {@see Google\Cloud\Firestore\FieldPath}. Nested arrays are not allowed.
     *
     * Example:
     * ```
     * $batch->updatePaths($documentName, [
     *     ['path' => 'name', 'value' => 'John'],
     *     ['path' => 'country', 'value' => 'USA'],
     *     ['path' => 'cryptoCurrencies.bitcoin', 'value' => 0.5],
     *     ['path' => 'cryptoCurrencies.ethereum', 'value' => 10],
     *     ['path' => 'cryptoCurrencies.litecoin', 'value' => 5.51]
     * ]);
     * ```
     *
     * ```
     * // If your field names contain special characters (such as `.`, or symbols),
     * // using {@see Google\Cloud\Firestore\FieldPath} will properly escape each element.
     *
     * use Google\Cloud\Firestore\FieldPath;
     *
     * $batch->updatePaths($documentName, [
     *     ['path' => new FieldPath(['cryptoCurrencies', 'big$$$coin']), 'value' => 5.51]
     * ]);
     * ```
     *
     * @param string $documentName The document name.
     * @param array[] $data A list of arrays of form `[FieldPath|string $path, mixed $value]`.
     * @param array $options Configuration options
     * @return WriteBatch
     */
    public function updatePaths($documentName, array $data, array $options = [])
    {
        if ($this->isAssoc($data)) {
            throw new \InvalidArgumentException(
                'Field data must be provided as a list of arrays of form `[string|FieldPath $path, mixed $value]`.'
            );
        }

        $paths = [];
        $values = [];
        foreach ($data as $field) {
            $this->arrayHasKeys($field, ['path', 'value']);

            $paths[] = ($field['path'] instanceof FieldPath)
                ? $field['path']
                : FieldPath::fromString($field['path']);

            $values[] = $field['value'];
        }

        $fields = $this->valueMapper->buildDocumentFromPathsAndValues($paths, $values);

        return $this->update($documentName, $fields, $options);
    }

    /**
     * Delete a Firestore document.
     *
     * Example:
     * ```
     * $batch->delete($documentName);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param string $documentName The document to delete.
     * @param array $options Configuration Options
     * @return WriteBatch
     * @codingStandardsIgnoreEnd
     */
    public function delete($documentName, array $options = [])
    {
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_DELETE, $documentName, $options);

        return $this;
    }

    /**
     * Enqueue a Transform operation.
     *
     * Note that UPDATE cannot follow TRANSFORM, so once any transforms are
     * enqueued (either by this method, or by using the `FirestoreClient::SERVER_TIMESTAMP`
     * sentinel value), any subsequent updates will fail.
     *
     * Example:
     * ```
     * $batch->transform($documentName, [
     *     [
     *         'fieldPath' => 'lastLoginTime',
     *         'setToServerValue' => WriteBatch::REQUEST_TIME
     *     ]
     * ]);
     * ```
     *
     * @param string $documentName The document to apply the transformation to.
     * @param array[] $transforms {
     *     A list of Document transformations.
     *
     *     @param string $fieldPath The path of the field.
     *     @param string $setToServerValue Sets the field to the given server value.
     * }
     * @param array $options Configuration options.
     * @return WriteBatch
     */
    private function transform($documentName, array $transforms = [], array $options = [])
    {
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_TRANSFORM, $documentName, [
            'fieldTransforms' => $transforms
        ] + $options);

        return $this;
    }

    /**
     * Commit writes to the database.
     *
     * Example:
     * ```
     * $batch->commit();
     * ```
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
        $response = $this->connection->commit(array_filter([
            'database' => $this->database,
            'writes' => $this->writes,
            'transaction' => $this->transaction
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
     * If the class was created without a Transaction ID, this method will fail.
     *
     * This method is intended for use internally and should not be considered
     * part of the public API.
     *
     * Example:
     * ```
     * $batch->rollback();
     * ```
     *
     * @access private
     * @param array $options Configuration Options
     * @return void
     * @throws \RuntimeException If no transaction ID is provided at class construction.
     */
    public function rollback(array $options = [])
    {
        if (!$this->transaction) {
            throw new \RuntimeException('Cannot rollback because no transaction id was provided.');
        }

        $this->connection->rollback([
            'database' => $this->database,
            'transaction' => $this->transaction
        ] + $options);
    }

    /**
     * Enqueue transformations for sentinels found in UPDATE calls.
     *
     * @param string $documentName
     * @param array $timestamps
     * @return void
     */
    private function updateTransformations($documentName, array $timestamps)
    {
        $transforms = [];
        foreach ($timestamps as $timestamp) {
            $transforms[] = [
                'fieldPath' => $timestamp,
                'setToServerValue' => self::REQUEST_TIME
            ];
        }

        if ($transforms) {
            $this->transform($documentName, $transforms);
        }
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
            'currentDocument' => $this->validatePrecondition($options),
        ]) + $this->createDatabaseWriteOperation($type, $name, $options);
    }

    /**
     * Validates a document precondition, if set.
     *
     * @codingStandardsIgnoreStart
     * @param array $options Configuration Options
     * @return array [Precondition](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Precondition)
     * @throws \InvalidArgumentException If the precondition is invalid.
     * @codingStandardsIgnoreEnd
     */
    private function validatePrecondition(array &$options)
    {
        $precondition = $this->pluck('precondition', $options, false);

        if (!$precondition) {
            return;
        }

        if (isset($precondition['exists'])) {
            return $precondition;
        }

        if (isset($precondition['updateTime'])) {
            if (!($precondition['updateTime'] instanceof Timestamp)) {
                throw new \InvalidArgumentException(
                    'Precondition Update Time must be an instance of Google\\Cloud\\Core\\Timestamp'
                );
            }

            return [
                'updateTime' => $precondition['updateTime']->formatForApi()
            ];
        }

        throw new \InvalidArgumentException('Preconditions must provide either `exists` or `updateTime`.');
    }

    /**
     * Create the write operation object.
     *
     * @param string $type The write type.
     * @param string $name The document name.
     * @param array $options Configuration Options.
     * @return array
     * @throws \InvalidArgumentException If $type is not a valid value.
     */
    private function createDatabaseWriteOperation($type, $name, array $options = [])
    {
        switch ($type) {
            case self::TYPE_UPDATE:
                return ['update' => [
                    'name' => $name,
                    'fields' => $this->pluck('fields', $options)
                ]];
                break;

            case self::TYPE_DELETE:
                return ['delete' => $name];
                break;

            case self::TYPE_TRANSFORM:
                return ['transform' => [
                    'document' => $name,
                    'fieldTransforms' => $this->pluck('fieldTransforms', $options)
                ]];
                break;

            // @codeCoverageIgnoreStart
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Write operation type `%s is not valid. Allowed values are update, delete, verify, transform.',
                    $type
                ));
                break;
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Check if the WriteBatch has any writes enqueued.
     *
     * @return bool
     * @access private
     */
    public function isEmpty()
    {
        return ! (bool) $this->writes;
    }
}
