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

use Google\Firestore\V1beta1\StructuredQuery_FieldFilter_Operator;
use Google\Firestore\V1beta1\StructuredQuery_CompositeFilter_Operator;

/**
 * Build a Firestore Query
 */
abstract class Query
{
    use PathTrait;
    
    const OP_LESS_THAN = StructuredQuery_FieldFilter_Operator::LESS_THAN;
    const OP_LESS_THAN_OR_EQUAL = StructuredQuery_FieldFilter_Operator::LESS_THAN_OR_EQUAL;
    const OP_GREATER_THAN = StructuredQuery_FieldFilter_Operator::GREATER_THAN;
    const OP_GREATER_THAN_OR_EQUAL = StructuredQuery_FieldFilter_Operator::GREATER_THAN_OR_EQUAL;
    const OP_EQUAL = StructuredQuery_FieldFilter_Operator::EQUAL;

    protected $query = [];

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

    protected abstract function valueMapper();

    /**
     * Add a WHERE clause to the Query.
     *
     * @param string $fieldPath
     * @param string $operator
     * @param mixed $value
     * @return Query
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
                                'value' => $this->valueMapper()->encodeValue($value)
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->newQuery($query);
    }

    public function orderBy($fieldPath, $direction)
    {
        return $this->newQuery([]);
    }

    public function limit($number)
    {
        return $this->newQuery([]);
    }

    public function offset($number)
    {
        return $this->newQuery([]);
    }

    public function startAt($fieldValues)
    {
        return $this->newQuery([]);
    }

    public function startAfter($fieldValues)
    {
        return $this->newQuery([]);
    }

    public function endBefore($fieldValues)
    {
        return $this->newQuery([]);
    }

    public function endAt($fieldValues)
    {
        return $this->newQuery([]);
    }

    /**
     * Create a new Query instance
     *
     * @param array $additionalConfig
     * @return Query
     */
    protected function newQuery(array $additionalConfig)
    {
        $copy = clone $this;
        $copy->setQuery(array_merge_recursive($this->query, $additionalConfig));

        return $copy;
    }

    /**
     * Update the stored query array
     *
     * @param array $query
     * @return void
     * @access private
     */
    public function setQuery(array $query)
    {
        $this->query = $query;
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
}
