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

use Google\Cloud\Firestore\V1\StructuredQuery\Direction;

/**
 * Methods common to Structured query and Aggregate Query.
 */
trait QueryTrait
{
    /**
     * Clean up the Structured query array before sending.
     *
     * Some optimizations cannot be performed ahead of time and must be done
     * at execution.
     *
     * @param array $query
     * @return array The final query data
     */
    private function structuredQueryPrepare(array $query)
    {
        $limitToLast = isset($query['limitToLast']) ? $query['limitToLast'] : false;
        $query = $query['query'];
        if ($limitToLast) {
            if (!isset($query['orderBy']) || !$query['orderBy']) {
                throw new \RuntimeException(
                    'Limit-to-last queries require specifying at least one orderBy clause.'
                );
            }

            // reverse the direction of orderBy clauses.
            foreach (array_keys($query['orderBy']) as $i) {
                $query['orderBy'][$i]['direction'] = $query['orderBy'][$i]['direction'] === Direction::ASCENDING
                    ? Direction::DESCENDING
                    : Direction::ASCENDING;
            }

            // Swap the cursors to match the now-flipped query ordering.
            // endAt becomes startAt and vice versa, and `before` is switched.
            $q = $query;

            // unset the values on the final query object so we start fresh.
            unset($query['startAt'], $query['endAt']);

            if (isset($q['startAt'])) {
                // first, copy the old startAt value to endAt.
                $query['endAt'] = $q['startAt'];

                // if `before` exists, swap it. if not set, infer value of `false` and set to `true`.
                $query['endAt']['before'] = !($query['endAt']['before'] ?? false);
            }

            if (isset($q['endAt'])) {
                // first, copy the old endAt value to startAt.
                $query['startAt'] = $q['endAt'];

                // if `before` exists, swap it. if not set, infer value of `false` and set to `true`.
                $query['startAt']['before'] = !($query['startAt']['before'] ?? false);
            }
        }

        if (isset($query['where']['compositeFilter']) && count($query['where']['compositeFilter']['filters']) === 1) {
            $filter = $query['where']['compositeFilter']['filters'][0];
            $query['where'] = $filter;
        }

        return $query;
    }
}
