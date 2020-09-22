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
class CollectionReference extends Query
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
     * @var DocumentReference|null
     */
    private $parent;

    /**
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param string $name The absolute name of the collection.
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        $name
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->name = $name;

        parent::__construct(
            $connection,
            $valueMapper,
            $this->parentPath($this->name),
            [
                'from' => [
                    [
                        'collectionId' => $this->pathId($this->name)
                    ]
                ]
            ]
        );
    }

    /**
     * Get the collection name.
     *
     * Names are absolute. The result of this call would be of the form
     * `projects/<project-id>/databases/<database-id>/documents/<relative-path>`.
     *
     * Other methods are available to retrieve different parts of a collection name:
     * * {@see Google\Cloud\Firestore\CollectionReference::id()} Returns the last element.
     * * {@see Google\Cloud\Firestore\CollectionReference::path()} Returns the path, relative to the database.
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
     * Get the collection path.
     *
     * Paths identify the location of a collection, relative to the database name.
     *
     * To retrieve the collection ID (the last element of the path), use
     * {@see Google\Cloud\Firestore\CollectionReference::id()}.
     *
     * Example:
     * ```
     * $path = $collection->path();
     * ```
     *
     * @return string
     */
    public function path()
    {
        return $this->relativeName($this->name);
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
     * Get a reference to a document which is a direct child of this collection.
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
     * Get a document reference with a randomly generated document ID.
     *
     * If you wish to create a document reference with a specified name, use
     * {@see Google\Cloud\Firestore\CollectionReference::document()}.
     *
     * This method does NOT insert the document until you call
     * {@see Google\Cloud\Firestore\DocumentReference::create()}.
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
     * Generate a new document reference, and insert it with the given field data.
     *
     * This method will generate a random document name. If you wish to create a
     * document with a specified name, create a reference with
     * {@see Google\Cloud\Firestore\CollectionReference::document()}, then call
     * {@see Google\Cloud\Firestore\DocumentReference::create()} to insert the
     * document.
     *
     * This method immediately inserts the document. If you wish for lazy
     * creation of a Document instance, refer to
     * {@see Google\Cloud\Firestore\CollectionReference::document()} or
     * {@see Google\Cloud\Firestore\CollectionReference::newDocument()}.
     *
     * Example:
     * ```
     * $newUser = $collection->add([
     *     'name' => 'Kate'
     * ]);
     * ```
     *
     * @param array $fields An array containing field names paired with their value.
     *        Accepts a nested array, or a simple array of field paths.
     * @param array $options Configuration Options.
     * @return DocumentReference
     */
    public function add(array $fields = [], array $options = [])
    {
        $name = $this->randomName($this->name);

        $document = $this->documentFactory($name);
        $result = $document->create($fields, $options);

        return $document;
    }

    /**
     * List all documents in the collection.
     *
     * Missing documents will be included in the result. A missing document is
     * one which does not exist, but has sub-documents.
     *
     * Example:
     * ```
     * $documents = $collection->listDocuments();
     * foreach ($documents as $document) {
     *     echo $document->name() . PHP_EOL;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.ListDocumentsRequest ListDocumentsRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options {
     *     Configuration options
     *
     *     @type int $pageSize The maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<DocumentReference>
     */
    public function listDocuments(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        $options += [
            'parent' => $this->parentPath($this->name),
            'collectionId' => $this->pathId($this->name),
            'mask' => []
        ];

        return new ItemIterator(
            new PageIterator(
                function ($document) {
                    return $this->documentFactory($document['name']);
                },
                [$this->connection, 'listDocuments'],
                $options,
                [
                    'itemsKey' => 'documents',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Get the parent document reference for a subcollection, or null if root.
     *
     * Example:
     * ```
     * $parent = $collection->parent();
     * ```
     *
     * @return DocumentReference|null
     */
    public function parent()
    {
        if (!isset($this->parent)) {
            $parentPath = $this->parentPath($this->name);
            if ($this->isDocument($parentPath)) {
                $this->parent = $this->documentFactory($parentPath);
            }
        }
        return $this->parent;
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
