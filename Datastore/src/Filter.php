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

class Filter
{
    public static function equalTo($property, $value)
    {
        return self::propertyFilter($property, Query::OP_EQUALS, $value);
    }
    public static function lessThan($property, $value)
    {
        return self::propertyFilter($property, Query::OP_LESS_THAN, $value);
    }
    public static function greaterThan($property, $value)
    {
        return self::propertyFilter($property, Query::OP_GREATER_THAN, $value);
    }
    public static function lessThanOrEqualTo($property, $value)
    {
        return self::propertyFilter($property, Query::OP_LESS_THAN_OR_EQUAL, $value);
    }
    public static function greaterThanOrEqualTo($property, $value)
    {
        return self::propertyFilter($property, Query::OP_GREATER_THAN_OR_EQUAL, $value);
    }
    public static function inArray($property, array $values)
    {
        return self::propertyFilter($property, Query::OP_IN, $values);
    }
    public static function notEqualTo($property, $value)
    {
        return self::propertyFilter($property, Query::OP_NOT_EQUALS, $value);
    }
    public static function notInArray($property, array $values)
    {
        return self::propertyFilter($property, Query::OP_NOT_IN, $values);
    }
    /**
     * Would allow users create property filters using shorthand $operator values
     * like =, <, >, <=, >=, != apart from the below specific property filters
     */
    public static function where($property, $operator, $value)
    {
        return self::propertyFilter($property, $operator, $value);
    }
    public static function and(array $filters)
    {
        return self::compositeFilter('AND', $filters);
    }
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
