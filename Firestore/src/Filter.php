<?php
/**
 * Copyright 2023 Google Inc.
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

use Google\Cloud\Firestore\V1\StructuredQuery\CompositeFilter\Operator;

/**
 * A Query Filter class.
 *
 * This class helps the user to create filters for complex queries.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\Filter;
 *
 * // Filtering with Filter::or and Filter::field
 * $result = $query->where(Filter::or([
 *     Filter::field('firstName', '=', 'John'),
 *     Filter::field('firstName', '=', 'Monica')
 * ]));
 * ```
 */
class Filter
{
    /**
     * Helper function for `and` filter.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\Filter;
     *
     * $result = $query->where(Filter::and([
     *     Filter::field('firstName', '=', 'John'),
     *     Filter::field('age', '>', '25')
     * ]));
     * ```
     *
     * @param array $filters A filter array.
     * @return array A composite filter array.
     */
    public static function and(array $filters)
    {
        return self::compositeFilter(Operator::PBAND, $filters);
    }

    /**
     * Helper function for `or` filter.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\Filter;
     *
     * $result = $query->where(Filter::or([
     *     Filter::field('firstName', '=', 'John'),
     *     Filter::field('firstName', '=', 'Monica')
     * ]));
     * ```
     *
     * @param array $filters A filter array.
     * @return array A composite Filter array.
     */
    public static function or(array $filters)
    {
        return self::compositeFilter(Operator::PBOR, $filters);
    }

    /**
     * Helper function for field filter.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\Filter;
     *
     * $result = $query->where(Filter::field('firstName', '=', 'John'));
     * ```
     *
     * @param string|FieldPath $fieldPath A field to filter by.
     * @param string|int $operator An operator to filter by.
     * @param mixed $value A value to compare to.
     * @return array A field Filter array.
     */
    public static function field($fieldPath, $operator, $value)
    {
        $filter = [
            'fieldFilter' => [
                'field' => $fieldPath,
                'op' => $operator,
                'value' => $value
            ]
        ];
        return $filter;
    }

    /**
     * Helper function for composite filter.
     *
     * @param int $operator An operator enum (Operator::PBAND | Operator::PBOR).
     * @param array $filters A filter array.
     * @return array A composite filter array.
     */
    private static function compositeFilter($operator, $filters)
    {
        $filter = [
            'compositeFilter' => [
                'op' => $operator,
                'filters' => $filters
            ]
        ];
        return $filter;
    }
}
