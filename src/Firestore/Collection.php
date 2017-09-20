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
     * @var array
     */
    private $query = [];

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
     * Get all documents belonging to this collection.
     *
     * If query filters have been provided, they will be applied.
     *
     * @param array $options
     * @return QuerySnapshot<Document>
     */
    public function documents(array $options = [])
    {
        $call = function () {
            $res = $this->connection->runQuery([
                'parent' => $this->name,
                'structuredQuery' => $this->query
            ]);
        };

        return new QuerySnapshot($query, $call);
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
     * Add a SELECT to the Query.
     * 
     * @param array $fieldPaths
     * @return Collection
     */
    public function select(array $fieldPaths)
    {
        $fields = [];
        foreach ($fieldPaths as $field) {
            $fields[] = [
                'fieldPath' => $field
            ];
        }
        
        return $this->newQuery([
            'select' => [
                'fields' => $fields
            ]
        ]);
    }

    /**
     * Add a WHERE clause to the Query.
     *
     * @param string $fieldPath
     * @param string $operator
     * @param mixed $value
     * @return Collection
     */
    public function where($fieldPath, $operator, $value)
    {
        $operator = array_key_exists($operator, $this->shortOperators)
            ? $this->shortOperators[$operator]
            : $operator;

        if (!in_array($operator, $this->allowedOperators)) {
            throw new \BadMethodCallException(sprintf(
                'Operator %s is not a valid operator',
                $operator
            ));
        }

        $query = [
            'where' => [
                'compositeFilter' => [
                    'op' => StructuredQuery_CompositeFilter_Operator::AND,
                    'filters' => [
                        [
                            'fieldFilter' => [
                                'field' => [
                                    'fieldPath' => $fieldPath,
                                ],
                                'op' => $operator,
                                'value' => $this->valueMapper->encodeValue($value)
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->newQuery($query);
    }

    /**
     * Add an ORDER BY clause to the Query
     * 
     * @param string $fieldPath
     * @param string $direction
     * @return Collection
     */
    public function orderBy($fieldPath, $direction)
    {
        $direction = strtoupper($direction);

        $direction = array_key_exists($direction, $this->shortDirections)
            ? $this->shortDirections[$direction]
            : $direction;

        if (!in_array($direction, $this->allowedDirections)) {
            throw new \BadMethodCallException(sprintf(
                'Direction %s is not a valid direction',
                $direction
            ));
        }

        return $this->newQuery([
            'order' => [
                'field' => [
                    'fieldPath' => $fieldPath
                ],
                'direction' => $direction
            ]
        ]);
    }

    public function limit($number)
    {
        return $this->newQuery([
            'limit' => [
                'value' => $number
            ]
        ]);
    }

    public function offset($number)
    {
        return $this->newQuery([
            'offset' => $number
        ]);
    }

    public function startAt(array $fieldValues)
    {
        return $this->newQuery([
            'startAt' => [
                'before' => true,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ]
        ]);
    }

    public function startAfter(array $fieldValues)
    {
        return $this->newQuery([
            'startAt' => [
                'before' => false,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ]
        ]);
    }

    public function endBefore(array $fieldValues)
    {
        return $this->newQuery([
            'endAt' => [
                'before' => true,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ]
        ]);
    }

    public function endAt(array $fieldValues)
    {
        return $this->newQuery([
            'endAt' => [
                'before' => false,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ]
        ]);
    }

    public function clearQuery()
    {
        return $this->newQuery([], true);
    }

    /**
     * Create a new Query instance
     *
     * @param array $additionalConfig
     * @return Query
     */
    private function newQuery(array $additionalConfig, $reset = false)
    {
        $info = [
            'query' => !$reset
                ? array_merge_recursive($this->query, $additionalConfig)
                : []
        ];

        return new Collection($this->connection, $this->valueMapper, $this->name, $info);
    }

    public function query()
    {
        return $this->query + [
            'from' => [
                [
                    'collectionId' => $this->pathId($this->name())
                ]
            ]
        ];
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
