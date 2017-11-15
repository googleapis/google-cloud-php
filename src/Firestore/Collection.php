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

class Collection
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
     * @param ConnectionInterface $connection
     * @param ValueMapper $valueMapper
     * @param string $name
     */
    public function __construct(ConnectionInterface $connection, ValueMapper $valueMapper, $name)
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }

    /**
     * Get all documents belonging to this collection.
     *
     * @todo This method is not in the document defining the API behavior, so it may have been omitted for a reason (and
     * may therefore be removed later). In testing, I found it useful to list documents in a collection, so I've
     * included it for the time being. (jdp)
     *
     * @param array $options
     * @return ItemIterator<Document>
     */
    public function documents(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function (array $document) {
                    return $this->documentFactory($document['name']);
                },
                [$this->connection, 'listDocuments'],
                [
                    'parent' => $this->parent($this->name),
                    'collectionId' => $this->id($this->name),
                    'mask' => [] // do not return any fields, since we only need a list of document names.
                ] + $options, [
                    'itemsKey' => 'documents',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Lazily get a document which is a direct child of this collection.
     *
     * @param string $documentId The document ID.
     * @return Document
     */
    public function document($documentId)
    {
        return $this->documentFactory($this->child($this->name, $documentId));
    }

    /**
     * Lazily generate a new document with a random name.
     *
     * This method does NOT insert the document until you call {@see Google\Cloud\Firestore\Document::create()}.
     *
     * @param array $fields
     * @param array $options
     * @return Document
     */
    public function newDocument()
    {
        return $this->documentFactory($this->randomName($this->name));
    }

    /**
     * Generate a new document with a random name, and insert it with the given field data.
     *
     * This method immediately inserts the document. If you wish for lazy creation of a Document instance,
     * refer to {@see Google\Cloud\Firestore\Collection::document()} or
     * {@see Google\Cloud\Firestore\Collection::newDocument()}.
     *
     * @param array $fields
     * @param array $options
     * @return array [{@see Google\Cloud\Firestore\Document}, array $result]
     */
    public function add(array $fields = [], array $options = [])
    {
        $document = $this->documentFactory($this->randomName($this->name));
        $result = $document->create($fields, $options);

        return [$document, $result];
    }

    /**
     * Create a document instance with the given document name.
     *
     * @param string $name
     * @return Document
     */
    private function documentFactory($name)
    {
        return new Document($this->connection, $this->valueMapper, $this, $name);
    }
}
