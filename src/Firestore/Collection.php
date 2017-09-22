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
use Google\Firestore\V1beta1\StructuredQuery_Direction;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Firestore\V1beta1\StructuredQuery_FieldFilter_Operator;
use Google\Firestore\V1beta1\StructuredQuery_CompositeFilter_Operator;

class Collection
{
    use ArrayTrait;
    use DebugInfoTrait;
    use PathTrait;

    const OP_LESS_THAN = StructuredQuery_FieldFilter_Operator::LESS_THAN;
    const OP_LESS_THAN_OR_EQUAL = StructuredQuery_FieldFilter_Operator::LESS_THAN_OR_EQUAL;
    const OP_GREATER_THAN = StructuredQuery_FieldFilter_Operator::GREATER_THAN;
    const OP_GREATER_THAN_OR_EQUAL = StructuredQuery_FieldFilter_Operator::GREATER_THAN_OR_EQUAL;
    const OP_EQUAL = StructuredQuery_FieldFilter_Operator::EQUAL;

    const DIR_ASCENDING = StructuredQuery_Direction::ASCENDING;
    const DIR_DESCENDING = StructuredQuery_Direction::DESCENDING;

    private $allowedOperators = [
        self::OP_LESS_THAN,
        self::OP_LESS_THAN_OR_EQUAL,
        self::OP_EQUAL,
        self::OP_GREATER_THAN,
        self::OP_GREATER_THAN_OR_EQUAL,
    ];

    private $shortOperators = [
        '<'  => self::OP_LESS_THAN,
        '<=' => self::OP_LESS_THAN_OR_EQUAL,
        '>'  => self::OP_GREATER_THAN,
        '>=' => self::OP_GREATER_THAN_OR_EQUAL,
        '='  => self::OP_EQUAL
    ];

    private $allowedDirections = [
        self::DIR_ASCENDING,
        self::DIR_DESCENDING
    ];

    private $shortDirections = [
        'ASC' => self::DIR_ASCENDING,
        'ASCENDING' => self::DIR_ASCENDING,
        'DESC' => self::DIR_DESCENDING,
        'DESCENDING' => self::DIR_DESCENDING
    ];

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
     * A list of properties to exclude from the print_r and var_dump output.
     * @var array
     */
    private $__excludeFromDebug = [
        'allowedOperators',
        'shortOperators',
        'allowedDirections',
        'shortDirections',
    ];

    /**
     * @param ConnectionInterface $connection
     * @param ValueMapper $valueMapper
     * @param string $name
     * @param array $info
     */
    public function __construct(ConnectionInterface $connection, ValueMapper $valueMapper, $name, array $info = [])
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->name = $name;
        $this->query = isset($info['query'])
            ? $info['query']
            : [];
    }

    /**
     * Get the collection name
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
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
     * Query the current collection.
     *
     * @codingStandardsIgnoreStart
     * @param array $query [StructuredQuery](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#structuredquery)
     * @return Query
     * @codingStandardsIgnoreEnd
     */
    public function query(array $query = [])
    {
        return new Query($this->connection, $this->valueMapper, [
            'from' => [
                [
                    'collectionId' => $this->pathId($this->name())
                ]
            ] + $query
        ]);
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
