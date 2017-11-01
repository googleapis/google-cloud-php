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
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ConflictException;
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
     * To retrieve the document ID (the last element of the path), use
     * {@see Google\Cloud\Firestore\DocumentReference::id()}.
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
     * Get the document identifier (i.e. the last path element).
     *
     * IDs are the path element which identifies a resource. To retrieve the
     * full path to a resource (the resource name), use
     * {@see Google\Cloud\Firestore\DocumentReference::name()}.
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
     * Create a new document in Firestore. If the document already exists, this method will fail.
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
     * @param array $fields An array containing field names paired with their value.
     *        Accepts a nested array, or a simple array of field paths.
     * @param array $options Configuration Options.
     * @return array [WriteResult](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.WriteResult)
     * @throws ConflictException
     * @codingStandardsIgnoreEnd
     */
    public function create(array $fields = [], array $options = [])
    {
        $writer = $this->batchFactory();

        $writer->create($this->name, $fields, $options);

        return $this->writeResult($writer->commit($options));
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
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\Document::update()},
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
     * @throws ConflictException If the precondition is not met.
     * @codingStandardsIgnoreEnd
     */
    public function set(array $fields, array $options = [])
    {
        $writer = $this->batchFactory();

        $writer->set($this->name, $fields, $options);

        return $this->writeResult($writer->commit($options));
    }

    /**
     * Update a Firestore document.
     *
     * Merges provided data with data stored in Firestore.
     *
     * Calling this method on a non-existent document will raise an exception.
     *
     * To remove a field, set the field value to {@see Gooogle\Cloud\Firestore\FieldValue::deleteField()}.
     *
     * To update a document using field paths, see
     * {@see Google\Cloud\Firestore\DocumentReference::updatePaths()}.
     *
     * Example:
     * ```
     * $document->update([
     *     'name' => 'John',
     *     'country' => 'USA',
     *     'cryptoCurrencies' => [
     *         'bitcoin' => 0.5,
     *         'ethereum' => 10,
     *         'litecoin' => 5.51
     *     ]
     * ]);
     * ```
     *
     * ```
     * // Remove a field using the {@see Gooogle\Cloud\Firestore\FieldValue::deleteField()} special value.
     * use Google\Cloud\Firestore\FieldValue;
     *
     * $document->update([
     *     'country' => FieldValue::deleteField()
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array $fields An array containing field names paired with their value.
     * @param array $options Configuration Options
     * @return array [WriteResult](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.WriteResult)
     * @throws ConflictException If the document does not exist.
     * @codingStandardsIgnoreEnd
     */
    public function update(array $fields, array $options = [])
    {
        $writer = $this->batchFactory();

        $writer->update($this->name, $fields, $options);

        return $this->writeResult($writer->commit($options));
    }

    /**
     * Enqueue an update with field paths and values.
     *
     * Example:
     * ```
     * // todo
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array[] $data A list of arrays of form `[FieldPath|string $path, mixed $value]`.
     * @param array $options Configuration options
     * @return array [WriteResult](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.WriteResult)
     * @throws ConflictException If the document does not exist.
     * @codingStandardsIgnoreEnd
     */
    public function updatePaths(array $data, array $options = [])
    {
        $writer = $this->batchFactory();
        $writer->updatePaths($this->name, $data, $options);

        return $this->writeResult($writer->commit($options));
    }

    /**
     * Delete a Firestore document.
     *
     * Example:
     * ```
     * $document->delete();
     * ```
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type array $precondition An optional precondition on the document. If
     *           this is set and not met by the target document, the write will
     *           fail. Allowed arguments are `(bool) $exists` and
     *           {@see Google\Cloud\Core\Timestamp} `$updateTime`.
     *           To completely disable precondition checks, provide an empty array
     *           as the value of `$precondition`. **Defaults to**
     *           `['exists' => true]` (i.e. Document must exist in Firestore).
     * }
     * @codingStandardsIgnoreStart
     * @return array [WriteResult](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.WriteResult)
     * @throws ConflictException If the precondition is not met.
     * @codingStandardsIgnoreEnd
     */
    public function delete(array $options = [])
    {
        $writer = $this->batchFactory();

        $writer->delete($this->name, $options);

        return $this->writeResult($writer->commit($options));
    }

    /**
     * Get a read-only snapshot of the document.
     *
     * Example:
     * ```
     * $snapshot = $document->snapshot();
     * ```
     *
     * @param array $options Configuration Options
     * @return DocumentSnapshot
     */
    public function snapshot(array $options = [])
    {
        return $this->createSnapshot($this, $this->valueMapper, $options);
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
     * @param array $options Configuration options.
     * @return ItemIterator<Collection>
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
     * Return the first write result from a commit response
     *
     * @param array $commitResponse
     * @return array
     */
    private function writeResult(array $commitResponse)
    {
        return isset($commitResponse['writeResults'][0])
            ? $commitResponse['writeResults'][0]
            : [];
    }
}
