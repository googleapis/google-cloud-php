<?php

/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Datastore;

use Google\Cloud\Datastore\Query\Query;

/**
 * Represents interface to create composite and property filters for
 * Google\Cloud\Datastore\Query\Query via static methods.
 *
 * Each method returns an array representation of respective filter which is
 * consumed by other filters or Query object.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 *
 * $filter = Filter::where('CompanyName', '=', 'Google');
 * $query = $datastore->query()
 * $query->kind('Companies')
 * $query->filter($filter);
 * $results = $datastore->runQuery($query);
 * foreach ($results as $result) {
 *     echo $result['CompanyName']; // Google
 * }
 * ```
 *
 * Similary composite filters can be created by using other composite/property
 * filters.
 * ```
 * // Or filter
 * $filterOr = Filter::or([$filter1, ...$filters]);
 *
 * // And Filter
 * $filterAnd = Filter::and([$filter1, ...$filters]);
 * ```
 *
 * Property Filters can be created by using the following shorthand operators:
 *     `$operator = One of ['=', '<', '<=', '>', '>=', '!=', 'IN', 'NOT IN']`
 * ```
 * $filter = Filter::where($property, $operator, $value);
 * ```
 */
class Filter
{
    /**
     * Creates a property filter in array format.
     *
     * @param string $property Property name
     * @param string $operator Operator, one of ('=', '<', '<=', '>', '>=',
     *        '!=', 'IN', 'NOT IN')
     * @param mixed $value Value for operation on property
     * @return array
     */
    public static function where($property, $operator, $value)
    {
        return self::propertyFilter($property, $operator, $value);
    }

    /**
     * Creates an AND composite filter in array format.
     *
     * @param array $filters An array of filters to AND upon.
     * @return array
     */
    public static function and(array $filters)
    {
        return self::compositeFilter('AND', $filters);
    }

    /**
     * Creates a OR composite filter in array format.
     *
     * @param array $filters An array of filters to OR upon.
     * @return array
     */
    public static function or(array $filters)
    {
        return self::compositeFilter('OR', $filters);
    }

    private static function propertyFilter($property, $operator, $value)
    {
        $filter = [
            'propertyFilter' => [
                'property' => $property,
                'value' => $value,
                'op' => $operator
            ]
        ];
        return $filter;
    }

    /**
     * @param string $type Type of Composite Filter, i.e. `AND` / `OR`.
     *        There values are checked in `Query::filter()` method.
     * @param array $filters Filter array to operator on.
     */
    private static function compositeFilter($type, $filters)
    {
        $filter = [
            'compositeFilter' => [
                'op' => $type,
                'filters' => $filters
            ]
        ];
        return $filter;
    }
}
