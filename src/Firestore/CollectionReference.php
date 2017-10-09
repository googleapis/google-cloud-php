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
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * Represents a Cloud Firestore Collection.
 *
 * Collections are implicit namespaces for Firestore Documents. They are created
 * when the first document is inserted, and cease to exist when the last
 * document is removed.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $collection = $firestore->collection('users');
 * ```
 */
class CollectionReference
{
    use ArrayTrait;
    use DebugInfoTrait;
    use PathTrait;

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
    private $name;

    /**
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param string $name The absolute name of the collection.
     */
    public function __construct(ConnectionInterface $connection, ValueMapper $valueMapper, $name)
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->name = $name;
    }

    /**
     * Get the collection name.
     *
     * Names are absolute. The result of this call would be of the form
     * `projects/<project-id>/databases/<database-id>/documents/<relative-path>`.
     *
     * To retrieve the collection ID (the last element of the path), use
     * {@see Google\Cloud\Firestore\CollectionReference::id()}.
     *
     * Example:
     * ```
     * $name = $collection->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get the collection ID.
     *
     * IDs are the path element which identifies a resource. To retrieve the
     * full path to a resource (the resource name), use
     * {@see Google\Cloud\Firestore\CollectionReference::name()}.
     *
     * Example:
     * ```
     * $id = $collection->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->pathId($this->name);
    }

    /**
     * Lazily get a document which is a direct child of this collection.
     *
     * Example:
     * ```
     * $newUser = $collection->document('john');
     * ```
     *
     * @param string $documentId The document ID.
     * @return DocumentReference
     */
    public function document($documentId)
    {
        return $this->documentFactory($this->childPath($this->name, $documentId));
    }

    /**
     * Lazily generate a new document with a random name.
     *
     * This method does NOT insert the document until you call {@see Google\Cloud\Firestore\Document::create()}.
     *
     * Example:
     * ```
     * $newUser = $collection->newDocument();
     * ```
     *
     * @return DocumentReference
     */
    public function newDocument()
    {
        return $this->documentFactory($this->randomName($this->name));
    }

    /**
     * Generate a new document, and insert it with the given field data.
     *
     * This method immediately inserts the document. If you wish for lazy
     * creation of a Document instance, refer to
     * {@see Google\Cloud\Firestore\Collection::document()} or
     * {@see Google\Cloud\Firestore\Collection::newDocument()}.
     *
     * Example:
     * ```
     * $newUser = $collection->add([
     *     'name' => 'Kate'
     * ]);
     * ```
     *
     * ```
     * // To specify a document ID, supply it in `$options`.
     * $newUser = $collection->add([
     *     'name' => 'David'
     * ], [
     *     'documentId' => 'david'
     * ]);
     * ```
     *
     * @param array $fields An array containing field names paired with their value.
     *        Accepts a nested array, or a simple array of field paths.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $documentId The ID of the new document. If not set, a
     *           random name will be generated. **Defaults to** `null`.
     * }
     * @return DocumentReference
     */
    public function add(array $fields = [], array $options = [])
    {
        $name = isset($options['documentId'])
            ? $this->childPath($this->name, $this->pluck('documentId', $options))
            : $this->randomName($this->name);

        $document = $this->documentFactory($name);
        $result = $document->create($fields, $options);

        return $document;
    }

    /**
     * Query the current collection.
     *
     * Example:
     * ```
     * $query = $collection->query();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array $query [StructuredQuery](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#structuredquery)
     * @return Query
     * @codingStandardsIgnoreEnd
     */
    public function query(array $query = [])
    {
        return new Query($this->connection, $this->valueMapper, $this->name, [
            'from' => [
                [
                    'collectionId' => $this->pathId($this->name)
                ]
            ] + $query
        ]);
    }

    /**
     * Create a document instance with the given document name.
     *
     * @param string $name The document name.
     * @return DocumentReference
     */
    private function documentFactory($name)
    {
        return new DocumentReference($this->connection, $this->valueMapper, $this, $name);
    }
}
