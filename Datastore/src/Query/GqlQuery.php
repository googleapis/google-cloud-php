<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore\Query;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Datastore\Cursor;
use Google\Cloud\Datastore\DatastoreTrait;
use Google\Cloud\Datastore\EntityMapper;
use InvalidArgumentException;

/**
 * Query Google Cloud Datastore using [GQL](https://cloud.google.com/datastore/docs/apis/gql/gql_reference).
 *
 * By default, parameters MUST be bound using named or positional bindings.
 * Literals are disabled by default, and must be enabled by setting
 * `$options['allowLiterals']` to `true`. As with any SQL dialect, using
 * parameter binding is highly recommended.
 *
 * Idiomatic usage is via {@see Google\Cloud\Datastore\DatastoreClient::gqlQuery()}.
 *
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 *
 * $query = $datastore->gqlQuery('SELECT * FROM Companies');
 * $res = $datastore->runQuery($query);
 *
 * foreach ($res as $company) {
 *     echo $company['companyName'] . PHP_EOL;
 * }
 * ```
 *
 * ```
 * //[snippet=bindings]
 * // Literals must be provided as bound parameters by default:
 * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = @companyName', [
 *     'bindings' => [
 *         'companyName' => 'Google'
 *     ]
 * ]);
 * ```
 *
 * ```
 * //[snippet=pos_bindings]
 * // Positional binding is also supported:
 * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = @1 LIMIT 1', [
 *     'bindings' => [
 *         'Google'
 *     ]
 * ]);
 * ```
 *
 * ```
 * //[snippet=literals]
 * // While not recommended, you can use literals in your query string:
 * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = \'Google\'', [
 *     'allowLiterals' => true
 * ]);
 * ```
 *
 * ```
 * //[snippet=cursor]
 * // Using cursors as query bindings:
 * $cursor = $datastore->cursor($cursorValue);
 *
 * $query = $datastore->gqlQuery('SELECT * FROM Companies OFFSET @offset', [
 *     'bindings' => [
 *         'offset' => $cursor
 *     ]
 * ]);
 * ```
 *
 * @see https://cloud.google.com/datastore/docs/apis/gql/gql_reference GQL Reference
 */
class GqlQuery implements QueryInterface
{
    use ArrayTrait;
    use DatastoreTrait;

    const BINDING_NAMED = 'namedBindings';
    const BINDING_POSITIONAL = 'positionalBindings';

    /**
     * @var EntityMapper
     */
    private $entityMapper;

    /**
     * @var string
     */
    private $query;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $allowedBindingTypes = [
        self::BINDING_NAMED,
        self::BINDING_POSITIONAL,
    ];

    /**
     * @param EntityMapper $entityMapper An instance of EntityMapper
     * @param string $query The GQL Query string.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type bool $allowLiterals Whether literal values will be allowed in
     *           the query string. Parameter binding is strongly encouraged over
     *           literals. **Defaults to** `false`.
     *     @type array $bindings An array of values to bind to the query string.
     *           Queries using Named Bindings should provide a key/value set,
     *           while queries using Positional Bindings must provide a simple
     *           array.
     *           Applications with no need for multitenancy should not set this value.
     * }
     */
    public function __construct(EntityMapper $entityMapper, $query, array $options = [])
    {
        $this->entityMapper = $entityMapper;
        $this->query = $query;
        $this->options = $options + [
            'allowLiterals' => false,
            'bindingType' => $this->determineBindingType($options),
            'bindings' => []
        ];
    }

    /**
     * Format the query for use in the API
     *
     * This method is used internally to run queries and is not intended for use
     * outside the internal library API
     *
     * @access private
     * @return array
     */
    public function queryObject()
    {
        $bindingType = $this->options['bindingType'];

        $queryObj = [];
        $queryObj['queryString'] = $this->query;
        $queryObj['allowLiterals'] = (bool) $this->options['allowLiterals'];

        $bindings = $this->mapBindings($bindingType, $this->options['bindings']);
        if (!empty($bindings)) {
            $queryObj[$this->options['bindingType']] = $bindings;
        }

        return $queryObj;
    }

    /**
     * Return the query_type union field name.
     *
     * @return string
     * @access private
     */
    public function queryKey()
    {
        return "gqlQuery";
    }

    /**
     * Indicate that this type does not support automatic pagination.
     *
     * @access private
     * @return bool
     */
    public function canPaginate()
    {
        return true;
    }

    /**
     * Fulfill the interface, but cursors are handled inside the query string.
     *
     * @param string $cursor
     * @return void
     * @access private
     * @codeCoverageIgnore
     */
    public function start($cursor)
    //@codingStandardsIgnoreStart
    {}
    //@codingStandardsIgnoreEnd

    /**
     * Define the json representation of the object.
     *
     * @access private
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->queryObject();
    }

    /**
     * Format bound values for the API
     *
     * @param string $bindingType Either named or positional bindings.
     * @param array $bindings The bindings to map
     * @return array
     */
    private function mapBindings($bindingType, array $bindings)
    {
        $res = [];
        foreach ($bindings as $key => $binding) {
            if ($binding instanceof Cursor) {
                $value = [
                    'cursor' => $binding->cursor()
                ];
            } else {
                $value = [
                    'value' => $this->entityMapper->valueObject($binding)
                ];
            }

            if ($bindingType === self::BINDING_NAMED) {
                $res[$key] = $value;
            } else {
                $res[] = $value;
            }
        }

        return $res;
    }

    /**
     * Determine whether the query should use named or positional bindings.
     *
     * @param array $options
     * @return string
     */
    private function determineBindingType(array $options)
    {
        if (isset($options['bindings']) && !$this->isAssoc($options['bindings'])) {
            return self::BINDING_POSITIONAL;
        }

        return self::BINDING_NAMED;
    }
}
