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
use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\FieldValue\DeleteFieldValue;
use Google\Cloud\Firestore\FieldValue\DocumentTransformInterface;
use Google\Cloud\Firestore\FieldValue\FieldValueInterface;

/**
 * Enqueue and write multiple mutations to Cloud Firestore.
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
    use TimeTrait;
    use ValidateTrait;

    const TYPE_UPDATE = 'update';
    const TYPE_SET = 'set';
    const TYPE_CREATE = 'create';
    const TYPE_DELETE = 'delete';
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
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object. Please
     *        note that DocumentReferences will be used only for the document
     *        name. Field data must be provided in the `$fields` argument.
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\DocumentReference::update()},
     *        field paths are NOT supported by this method.
     * @param array $options Configuration options
     * @return WriteBatch
     * @throws \InvalidArgumentException If `FieldValue::deleteField()` is found in the fields list.
     * @throws \InvalidArgumentException If `FieldValue::serverTimestamp()` is found in an array value.
     */
    public function create($document, array $fields, array $options = [])
    {
        // Record whether the document is empty before any filtering.
        $emptyDocument = count($fields) === 0;

        list ($fields, $sentinels, $metadata) = $this->filterFields($fields);

        if ($metadata['hasDelete']) {
            throw new \InvalidArgumentException('Cannot delete fields when creating a document.');
        }

        // Cannot create a document that already exists!
        $precondition = ['exists' => false];

        // Enqueue an update operation if an empty document was provided,
        // or if there are still fields after filtering.
        $transformOptions = [];
        if (!empty($fields) || $emptyDocument) {
            $this->writes[] = $this->createDatabaseWrite(self::TYPE_CREATE, $document, [
                'fields' => $this->valueMapper->encodeValues($fields),
                'precondition' => $precondition
            ] + $options);
        } else {
            // If no UPDATE mutation is enqueued, we need the precondition applied
            // to the transform mutation.
            $transformOptions = [
                'precondition' => $precondition
            ];
        }

        // document transform operations are enqueued as a separate mutation.
        $this->enqueueTransforms($document, $sentinels, $transformOptions);

        return $this;
    }

    /**
     * Enqueue a set mutation.
     *
     * Unless `$options['merge']` is set to `true, this method replaces all
     * fields in a Firestore document.
     *
     * Example:
     * ```
     * $batch->set($documentName, [
     *     'name' => 'John'
     * ]);
     *
     * @codingStandardsIgnoreStart
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object. Please
     *        note that DocumentReferences will be used only for the document
     *        name. Field data must be provided in the `$fields` argument.
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
     * @throws \InvalidArgumentException If `FieldValue::deleteField()` is found in the document when `$options.merge`
     *         is not `true`.
     * @throws \InvalidArgumentException If `FieldValue::serverTimestamp()` is found in an array value.
     */
    public function set($document, array $fields, array $options = [])
    {
        $merge = $this->pluck('merge', $options, false) ?: false;

        // Record whether the document is empty before any filtering.
        $emptyDocument = count($fields) === 0;

        list ($fields, $sentinels, $metadata) = $this->filterFields($fields);

        if (!$merge && $metadata['hasDelete']) {
            throw new \InvalidArgumentException('Delete cannot appear in data unless `$options[\'merge\']` is set.');
        }

        // Enqueue a write if any of the following conditions are met
        // - if there are still fields remaining after sentinels were removed
        // - if the user provided an empty set to begin with
        // - if the user provided only transform sentinel values AND did not specify merge behavior
        // - if the user provided only delete sentinel field values.

        $updateNotRequired = count($fields) === 0
            && !$emptyDocument
            && !$metadata['hasUpdateMask']
            && $metadata['hasTransform'];

        $shouldEnqueueUpdate = $fields
            || $emptyDocument
            || ($updateNotRequired && !$merge)
            || $metadata['hasUpdateMask'];

        if ($shouldEnqueueUpdate) {
            $write = [];
            $write['fields'] = $this->valueMapper->encodeValues($fields);

            if ($merge) {
                $write['updateMask'] = $this->pathsToStrings($this->encodeFieldPaths($fields), $sentinels);
            }

            $this->writes[] = $this->createDatabaseWrite(self::TYPE_SET, $document, array_merge($options, $write));
        }

        // document transform operations are enqueued as a separate mutation.
        $this->enqueueTransforms($document, $sentinels, $options);

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
     * Please note that conflicting paths will result in an exception. Paths
     * conflict when one path indicates a location nested within another path.
     * For instance, path `a.b` cannot be set directly if path `a` is also
     * provided.
     *
     * Example:
     * ```
     * $batch->update($documentName, [
     *     ['path' => 'name', 'value' => 'John'],
     *     ['path' => 'country', 'value' => 'USA'],
     *     ['path' => 'cryptoCurrencies.bitcoin', 'value' => 0.5],
     *     ['path' => 'cryptoCurrencies.ethereum', 'value' => 10],
     *     ['path' => 'cryptoCurrencies.litecoin', 'value' => 5.51]
     * ]);
     * ```
     *
     * ```
     * // Google Cloud PHP provides special field values to enable operations such
     * // as deleting fields or setting the value to the current server timestamp.
     * use Google\Cloud\Firestore\FieldValue;
     *
     * $batch->update($documentName, [
     *     ['path' => 'country', 'value' => FieldValue::deleteField()],
     *     ['path' => 'lastLogin', 'value' => FieldValue::serverTimestamp()]
     * ]);
     * ```
     *
     * ```
     * // If your field names contain special characters (such as `.`, or symbols),
     * // using {@see Google\Cloud\Firestore\FieldPath} will properly escape each element.
     *
     * use Google\Cloud\Firestore\FieldPath;
     *
     * $batch->update($documentName, [
     *     ['path' => new FieldPath(['cryptoCurrencies', 'big$$$coin']), 'value' => 5.51]
     * ]);
     * ```
     *
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object. Please
     *        note that DocumentReferences will be used only for the document
     *        name. Field data must be provided in the `$data` argument.
     * @param array[] $data A list of arrays of form
     *        `[FieldPath|string $path, mixed $value]`.
     * @param array $options Configuration options
     * @return WriteBatch
     * @throws \InvalidArgumentException If data is given in an invalid format
     *         or is empty.
     * @throws \InvalidArgumentException If any field paths are empty.
     * @throws \InvalidArgumentException If field paths conflict.
     */
    public function update($document, array $data, array $options = [])
    {
        if (!$data || $this->isAssoc($data)) {
            throw new \InvalidArgumentException(
                'Field data must be provided as a list of arrays of form `[string|FieldPath $path, mixed $value]`.'
            );
        }

        $paths = [];
        $fields = [];
        foreach ($data as $field) {
            $this->arrayHasKeys($field, ['path', 'value']);

            $path = ($field['path'] instanceof FieldPath)
                ? $field['path']
                : FieldPath::fromString($field['path']);

            if (!$path->path()) {
                throw new \InvalidArgumentException('Field Path cannot be empty.');
            }

            $paths[] = $path;

            $keys = $path->path();
            $num = count($keys);

            // Construct a nested array to represent a nested field path.
            // For instance, `a.b.c` = 'foo' will become
            // `['a' => ['b' => ['c' => 'foo']]]`
            $val = $field['value'];
            foreach (array_reverse($keys) as $index => $key) {
                if ($num >= $index + 1) {
                    $val = [
                        $key => $val
                    ];
                }
            }

            $fields = $this->arrayMergeRecursive($fields, $val);
        }

        if (count(array_unique($paths)) !== count($paths)) {
            throw new \InvalidArgumentException('Duplicate field paths are not allowed.');
        }

        // Record whether the document is empty before any filtering.
        $emptyDocument = count($fields) === 0;

        list ($fields, $sentinels, $metadata) = $this->filterFields($fields, $paths);

        // to conform to specification.
        if (isset($options['precondition']['exists'])) {
            throw new \InvalidArgumentException('Exists preconditions are not supported by this method.');
        }

        // We only want to enqueue an update write if there are non-sentinel fields
        // OR no transform sentinels are found.
        // We MUST always enqueue at least one write, so if there are no fields
        // and no transform sentinels, we can assume an empty write is intended
        // and enqueue an empty UPDATE operation.
        $shouldEnqueueUpdate = $fields
            || $emptyDocument
            || $metadata['hasUpdateMask'];

        if ($shouldEnqueueUpdate) {
            $write = [
                'fields' => $this->valueMapper->encodeValues($fields),
                'updateMask' => $this->pathsToStrings($paths, $sentinels, true)
            ];

            $this->writes[] = $this->createDatabaseWrite(
                self::TYPE_UPDATE,
                $document,
                $write + $this->formatPrecondition($options, true)
            );
        } else {
            // If no update write is enqueued, preconditions must be applied to
            // a transform.
            $options = $this->formatPrecondition($options, true);
        }

        // document transform operations are enqueued as a separate mutation.
        $this->enqueueTransforms($document, $sentinels, $options);

        return $this;
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
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object.
     * @param array $options Configuration Options
     * @return WriteBatch
     * @codingStandardsIgnoreEnd
     */
    public function delete($document, array $options = [])
    {
        $options = $this->formatPrecondition($options);
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_DELETE, $document, $options);

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
        unset($options['merge'], $options['precondition']);

        $response = $this->connection->commit(array_filter([
            'database' => $this->database,
            'writes' => $this->writes,
            'transaction' => $this->transaction
        ]) + $options);

        if (isset($response['commitTime'])) {
            $time = $this->parseTimeString($response['commitTime']);
            $response['commitTime'] = new Timestamp($time[0], $time[1]);
        }

        if (isset($response['writeResults'])) {
            foreach ($response['writeResults'] as &$result) {
                if (isset($result['updateTime'])) {
                    $time = $this->parseTimeString($result['updateTime']);
                    $result['updateTime'] = new Timestamp($time[0], $time[1]);
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
     * Check if the WriteBatch has any writes enqueued.
     *
     * @return bool
     * @access private
     */
    public function isEmpty()
    {
        return ! (bool) $this->writes;
    }

    /**
     * Enqueue transforms for CREATE, UPDATE, and SET calls.
     *
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object.
     * @param DocumentTransformInterface[] $transforms
     * @param array $options
     * @return void
     */
    private function enqueueTransforms($document, array $transforms, array $options = [])
    {
        $operations = [];

        foreach ($transforms as $transform) {
            if (!($transform instanceof DocumentTransformInterface)) {
                continue;
            }

            $args = $transform->args();
            if (!$transform->sendRaw()) {
                if (is_array($args) && !$this->isAssoc($args)) {
                    $args = $this->valueMapper->encodeArrayValue($args);
                } else {
                    $args = $this->valueMapper->encodeValue($args);
                }
            }

            $operations[] = [
                'fieldPath' => $transform->fieldPath()->pathString(),
                $transform->key() => $args
            ];
        }

        if ($operations) {
            $this->writes[] = $this->createDatabaseWrite(self::TYPE_TRANSFORM, $document, [
                'fieldTransforms' => $operations
            ] + $options);
        }
    }

    /**
     * @param string $type The write operation type.
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object.
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
    private function createDatabaseWrite($type, $document, array $options = [])
    {
        $mask = $this->pluck('updateMask', $options, false);
        if ($mask !== null) {
            sort($mask);
            $mask = ['fieldPaths' => $mask];
        }

        $document = ($document instanceof DocumentReference)
            ? $document->name()
            : $document;

        return $this->arrayFilterRemoveNull([
            'updateMask' => $mask,
            'currentDocument' => $this->validatePrecondition($options),
        ]) + $this->createDatabaseWriteOperation($type, $document, $options);
    }

    /**
     * Validates a document precondition, if set.
     *
     * @codingStandardsIgnoreStart
     * @param array $options Configuration Options
     * @return array|void [Precondition](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Precondition)
     * @throws \InvalidArgumentException If the precondition is invalid.
     * @codingStandardsIgnoreEnd
     */
    private function validatePrecondition(array &$options)
    {
        $precondition = isset($options['precondition'])
            ? $options['precondition']
            : null;

        if (!$precondition) {
            return;
        }

        if (isset($precondition['exists'])) {
            return $precondition;
        }

        if (isset($precondition['updateTime'])) {
            if (!($precondition['updateTime'] instanceof Timestamp)) {
                throw new \InvalidArgumentException(
                    'Precondition Update Time must be an instance of `Google\\Cloud\\Core\\Timestamp`'
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
     * @param string $document The document to target, either
     *        as a string document name, or DocumentReference object.
     * @param array $options Configuration Options.
     * @return array
     * @throws \InvalidArgumentException If $type is not a valid value.
     */
    private function createDatabaseWriteOperation($type, $document, array $options = [])
    {
        switch ($type) {
            case self::TYPE_UPDATE:
                return [
                    'update' => $this->arrayFilterRemoveNull([
                        'name' => $document,
                        // empty array -> set to null and filter for conformance.
                        'fields' => $this->pluck('fields', $options, false) ?: null
                    ])
                ];
                break;

            case self::TYPE_SET:
            case self::TYPE_CREATE:
                return [
                    'update' => [
                        'name' => $document,
                        'fields' => $this->pluck('fields', $options, false) ?: []
                    ]
                ];
                break;

            case self::TYPE_DELETE:
                return ['delete' => $document];
                break;

            case self::TYPE_TRANSFORM:
                return [
                    'transform' => [
                        'document' => $document,
                        'fieldTransforms' => $this->pluck('fieldTransforms', $options)
                    ]
                ];
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
     * Filter fields, removing sentinel values from the field list and recording
     * their location.
     *
     * @param array $fields The structured fields input.
     * @param FieldPath[] $inputPaths The paths provided by update-paths.
     * @return array An array containing the output fields at position 0,
     *         a sentinels list at position 1, and metadata at position 2.
     *         Metadata includes `array $types`, a list of class names of
     *         sentinels, and `bool $hasTransform`, indicating whether any
     *         instanceof of `DocumentTransformInterface` existed in the
     *         original input data.
     */
    private function filterFields(array $fields, array $inputPaths = [])
    {
        return $this->filterFieldsRecursive(
            $fields,
            [],
            [
                'hasTransform' => false,
                'hasUpdateMask' => false,
                'hasDelete' => false
            ],
            $inputPaths,
            new FieldPath([])
        );
    }

    /**
     * Recurses through the fields, filtering out sentinel values and
     * performing common validation.
     *
     * @param array $fields The original structured fields.
     * @param array $sentinels A list of sentinel values.
     * @param array $metadata A set of metadata describing the provided fields.
     * @param FieldPath[] $inputPaths The paths provided by update-paths.
     * @param FieldPath $path A field path instance used to track the current
     *        working path.
     * @param bool $inArray [optional] Whether or not we are recursing within
     *        an array.
     * @return array An array containing the output fields, a sentinels list,
     *         and metadata.
     * @throws \InvalidArgumentException
     */
    private function filterFieldsRecursive(
        array $fields,
        array $sentinels,
        array $metadata,
        array $inputPaths,
        FieldPath $path,
        $inArray = false
    ) {
        foreach ($fields as $key => $value) {
            $currentPath = $path->child($key);

            if (is_array($value) && !empty($value)) {
                list($fields[$key], $sentinels, $metadata) = $this->filterFieldsRecursive(
                    $value,
                    $sentinels,
                    $metadata,
                    $inputPaths,
                    $currentPath,
                    $inArray ?: !$this->isAssoc($value)
                );

                if (empty($fields[$key])) {
                    unset($fields[$key]);
                }
            } elseif ($value instanceof FieldValueInterface) {
                $value->setFieldPath($currentPath);
                $sentinels[] = $value;

                // Sentinels cannot be used within a non-associative array.
                if ($inArray) {
                    throw new \InvalidArgumentException(sprintf(
                        '%s values cannot be used anywhere within a non-associative array value. ' .
                        'Invalid value found at %s.',
                        FieldValue::class,
                        $currentPath->pathString()
                    ));
                }

                // Delete cannot be nested in update-paths
                // (i.e. the only case where `$inputPaths` would be available)
                $illegalNestedDelete = $inputPaths
                    && $value instanceof DeleteFieldValue
                    && !in_array($currentPath, $inputPaths);

                if ($illegalNestedDelete) {
                    throw new \InvalidArgumentException(sprintf(
                        '%s::deleteField() values cannot be nested. ' .
                        'Invalid value found at %s.',
                        FieldValue::class,
                        $currentPath->pathString()
                    ));
                }

                // Values of type `DocumentTransformInterface` cannot contain nested transforms.
                if ($value instanceof DocumentTransformInterface) {
                    $args = $value->args();
                    if (is_array($args) && !$this->isAssoc($args)) {
                        foreach ($args as $arg) {
                            if ($arg instanceof DocumentTransformInterface) {
                                throw new \InvalidArgumentException(sprintf(
                                    'Document transforms cannot contain %s values. ' .
                                    'Invalid value found at %s.',
                                    FieldValue::class,
                                    $currentPath->pathString()
                                ));
                            }
                        }
                    }
                }

                // Remove the sentinel value from the fields array.
                unset($fields[$key]);

                // Record whether the mutation contains a transform value.
                if (!$metadata['hasTransform'] && $value instanceof DocumentTransformInterface) {
                    $metadata['hasTransform'] = true;
                }

                // Record whether an update mask is required.
                if (!$metadata['hasUpdateMask'] && $value->includeInUpdateMask()) {
                    $metadata['hasUpdateMask'] = true;
                }

                // Record whether a field delete is provided.
                if (!$metadata['hasDelete'] && $value instanceof DeleteFieldValue) {
                    $metadata['hasDelete'] = true;
                }
            }
        }

        return [$fields, $sentinels, $metadata];
    }

    /**
     * Correctly formats a precondition for a write.
     *
     * @param array $options Configuration options input.
     * @param bool $mustExist If true, the precondition will always include at
     *        least `exists=true` precondition. **Defaults to** `false`.
     * @return array Modified configuration options.
     */
    private function formatPrecondition(array $options, $mustExist = false)
    {
        if (!isset($options['precondition']) && !$mustExist) {
            return $options;
        }

        $precondition = isset($options['precondition'])
            ? $options['precondition']
            : [];

        if (isset($precondition['updateTime'])) {
            return $options;
        }

        if ($mustExist) {
            $precondition['exists'] = true;
        }

        $options['precondition'] = $precondition;

        return $options;
    }

    /**
     * Create a list of fields paths from field data.
     *
     * The return value of this method does not include the field values. It
     * merely provides a list of field paths which were included in the input.
     *
     * @param array $fields A list of fields to map as paths.
     * @param FieldPath|null $path The parent path (used internally).
     * @return FieldPath[]
     */
    private function encodeFieldPaths(array $fields, $path = null)
    {
        $output = [];

        if (!$path) {
            $path = new FieldPath([]);
        }

        foreach ($fields as $key => $val) {
            $currentPath = $path->child($key);

            if (is_array($val) && $this->isAssoc($val)) {
                $output = array_merge(
                    $output,
                    $this->encodeFieldPaths($val, $currentPath)
                );
            } else {
                $output[] = $currentPath;
            }
        }

        return $output;
    }

    /**
     * Convert a set of {@see Google\Cloud\Firestore\FieldPath} objects to strings.
     *
     * @param FieldPath[] $paths The input paths.
     * @param FieldValueInterface[] $sentinels Sentinel values.
     * @param bool $checkPrefixes Whether to search the paths for illegal path
     *        prefixes.
     * @return string[]
     */
    private function pathsToStrings(array $paths, array $sentinels, $checkPrefixes = false)
    {
        $out = [];
        $excluded = [];
        foreach ($sentinels as $sentinel) {
            $path = $sentinel->fieldPath()
                ? $sentinel->fieldPath()->pathString()
                : null;

            if (!$sentinel->includeInUpdateMask()) {
                $excluded[] = $path;
                continue;
            }

            $out[] = $path;
        }

        foreach ($paths as $path) {
            $path = $path->pathString();
            if (!in_array($path, $excluded)) {
                $out[] = $path;
            }
        }

        // The flag isn't really necessary since prefixes can only happen in
        // update-paths, but using it lets us bypass the unnecessary check
        // unless we need it.
        if ($checkPrefixes) {
            $this->checkPrefixes($out);
        }

        // Remove any duplicate values before returning.
        return array_unique($out);
    }

    /**
     * Check list of FieldPaths for prefix paths and throw exception.
     *
     * @param string[] $paths
     * @throws \InvalidArgumentException If prefix paths are found.
     */
    private function checkPrefixes(array $paths)
    {
        sort($paths);

        for ($i = 1; $i < count($paths); $i++) {
            $prefix = $paths[$i-1];
            $suffix = $paths[$i];

            $prefix = explode('.', $prefix);
            $suffix = explode('.', $suffix);

            $isPrefix = count($prefix) < count($suffix)
                && $prefix === array_slice($suffix, 0, count($prefix));

            if ($isPrefix) {
                throw new \InvalidArgumentException(sprintf(
                    'Field path conflict detected for field path `%s`. ' .
                    'Conflicts occur when a field path descends from another ' .
                    'path. For instance `a.b` is not allowed when `a` is also ' .
                    'provided.',
                    implode('.', $prefix)
                ));
            }
        }
    }
}
