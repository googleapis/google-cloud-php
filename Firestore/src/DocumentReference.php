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

use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * Represents a reference to a Firestore document.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $document = $firestore->document('users/john');
 * ```
 */
class DocumentReference
{
    use SnapshotTrait;
    use DebugInfoTrait;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var CollectionReference
     */
    private $parent;

    /**
     * @var string
     */
    private $name;

    /**
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param CollectionReference $parent The collection in which this document is contained.
     * @param string $name The fully-qualified document name.
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        CollectionReference $parent,
        $name
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->parent = $parent;
        $this->name = $name;
    }

    /**
     * Returns the parent collection.
     *
     * Example:
     * ```
     * $parent = $document->parent();
     * ```
     *
     * @return CollectionReference
     */
    public function parent()
    {
        return $this->parent;
    }

    /**
     * Get the document name.
     *
     * Names are absolute. The result of this call would be of the form
     * `projects/<project-id>/databases/<database-id>/documents/<relative-path>`.
     *
     * Other methods are available to retrieve different parts of a collection name:
     * * {@see Google\Cloud\Firestore\DocumentReference::id()} Returns the last element.
     * * {@see Google\Cloud\Firestore\DocumentReference::path()} Returns the path, relative to the database.
     *
     * Example:
     * ```
     * $name = $document->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get the document path.
     *
     * Paths identify the location of a document, relative to the database name.
     *
     * To retrieve the document ID (the last element of the path), use
     * {@see Google\Cloud\Firestore\DocumentReference::id()}.
     *
     * Example:
     * ```
     * $path = $document->path();
     * ```
     *
     * @return string
     */
    public function path()
    {
        return $this->relativeName($this->name);
    }

    /**
     * Get the document identifier (i.e. the last path element).
     *
     * IDs are the path element which identifies a resource. To retrieve the
     * path of a resource, relative to the database name, use
     * {@see Google\Cloud\Firestore\DocumentReference::path()}.
     *
     * Example:
     * ```
     * $id = $document->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->pathId($this->name);
    }

    /**
     * Create a new document in Firestore.
     *
     * If the document already exists, this method will fail.
     *
     * Example:
     * ```
     * $document->create([
     *     'name' => 'John',
     *     'country' => 'USA'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.Commit Commit
     *
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\DocumentReference::update()},
     *        field paths are NOT supported by this method.
     * @param array $options Configuration Options.
     * @return array [WriteResult](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.WriteResult)
     * @codingStandardsIgnoreEnd
     */
    public function create(array $fields = [], array $options = [])
    {
        return $this->writeResult(
            $this->batchFactory()
                ->create($this->name, $fields, $options)
                ->commit($options)
        );
    }

    /**
     * Write to a Firestore document, with optional merge behavior.
     *
     * This method will create the document if it does not already exist.
     *
     * Unless `$options.merge` is set to true, this method will replace all
     * existing document data.
     *
     * Example:
     * ```
     * $document->set([
     *     'name' => 'Dave'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.Commit Commit
     * @codingStandardsIgnoreEnd
     *
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\DocumentReference::update()},
     *        field paths are NOT supported by this method.
     * @param array $options {
     *     Configuration Options
     *
     *     @type bool $merge If true, unwritten fields will be preserved.
     *           Otherwise, they will be overwritten (removed). **Defaults to**
     *           `false`.
     * }
     * @codingStandardsIgnoreStart
     * @return array [WriteResult](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.WriteResult)
     * @codingStandardsIgnoreEnd
     */
    public function set(array $fields, array $options = [])
    {
        return $this->writeResult(
            $this->batchFactory()
                ->set($this->name, $fields, $options)
                ->commit($options)
        );
    }

    /**
     * Update a Firestore document using field paths and values.
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
     * $document->update([
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
     * $document->update([
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
     * $document->update([
     *     ['path' => new FieldPath(['cryptoCurrencies', 'big$$$coin']), 'value' => 5.51]
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.Commit Commit
     *
     * @param array[] $data A list of arrays of form
     *        `[FieldPath|string $path, mixed $value]`.
     * @param array $options Configuration options
     * @return array [WriteResult](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.WriteResult)
     * @throws \InvalidArgumentException If data is given in an invalid format
     *         or is empty.
     * @throws \InvalidArgumentException If any field paths are empty.
     * @throws \InvalidArgumentException If field paths conflict.
     * @codingStandardsIgnoreEnd
     */
    public function update(array $data, array $options = [])
    {
        return $this->writeResult(
            $this->batchFactory()
                ->update($this->name, $data, $options)
                ->commit($options)
        );
    }

    /**
     * Delete a Firestore document.
     *
     * Example:
     * ```
     * $document->delete();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.Commit Commit
     *
     * @param array $options Configuration Options
     * @return array [WriteResult](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.WriteResult)
     * @codingStandardsIgnoreEnd
     */
    public function delete(array $options = [])
    {
        return $this->writeResult(
            $this->batchFactory()
                ->delete($this->name, $options)
                ->commit($options)
        );
    }

    /**
     * Get a read-only snapshot of the document.
     *
     * Example:
     * ```
     * $snapshot = $document->snapshot();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.BatchGetDocuments BatchGetDocuments
     * @codingStandardsIgnoreEnd
     *
     * @param array $options Configuration Options
     * @return DocumentSnapshot
     */
    public function snapshot(array $options = [])
    {
        return $this->createSnapshot($this->connection, $this->valueMapper, $this, $options);
    }

    /**
     * Get a reference to a collection which is a child of the current document.
     *
     * Example:
     * ```
     * $child = $document->collection('wallet');
     * ```
     *
     * @param string $collectionId The ID of the child collection.
     * @return CollectionReference
     */
    public function collection($collectionId)
    {
        return new CollectionReference(
            $this->connection,
            $this->valueMapper,
            $this->childPath($this->name, $collectionId)
        );
    }

    /**
     * List all collections which are children of the current document.
     *
     * Example:
     * ```
     * $collections = $document->collections();
     * ```
     *
     * @codingStandardsIgnoreStart
     * https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.ListCollectionIds ListCollectionIds
     * @codingStandardsIgnoreEnd
     *
     * @param array $options Configuration options.
     * @return ItemIterator<CollectionReference>
     */
    public function collections(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function ($collectionId) {
                    return new CollectionReference(
                        $this->connection,
                        $this->valueMapper,
                        $this->childPath($this->name, $collectionId)
                    );
                },
                [$this->connection, 'listCollectionIds'],
                $options + ['parent' => $this->name],
                [
                    'itemsKey' => 'collectionIds',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Create a Batch Writer for single-use mutations in this class.
     *
     * @return WriteBatch
     */
    protected function batchFactory()
    {
        return new WriteBatch(
            $this->connection,
            $this->valueMapper,
            $this->databaseFromName($this->name)
        );
    }

    /**
     * Return the latest write result from a commit response
     *
     * @param array $commitResponse
     * @return array
     */
    private function writeResult(array $commitResponse)
    {
        return isset($commitResponse['writeResults']) && is_array($commitResponse['writeResults'])
            ? array_pop($commitResponse['writeResults'])
            : [];
    }
}
