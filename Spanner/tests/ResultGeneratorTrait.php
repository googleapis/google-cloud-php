<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Tests;

use Google\Cloud\Spanner\Database;

/**
 * Provide a Spanner Read/Query result
 */
trait ResultGeneratorTrait
{
    /**
     * Yield a ResultSet response.
     *
     * @param bool $withStats If true, statistics will be included.
     *        **Defaults to** `false`.
     * @param string|null $transaction If set, the value will be included as the
     *        transaction ID. **Defaults to** `null`.
     * @return \Generator
     */
    private function resultGenerator($withStats = false, $transaction = null)
    {
        return $this->yieldRows([
            [
                'name' => 'ID',
                'type' => Database::TYPE_INT64,
                'value' => '10'
            ]
        ], $withStats, $transaction);
    }

    /**
     * Yield rows with user-specified data.
     *
     * @param array[] $rows A list of arrays containing `name`, `type` and `value` keys.
     * @param bool $withStats If true, statistics will be included.
     *        **Defaults to** `false`.
     * @param string|null $transaction If set, the value will be included as the
     *        transaction ID. **Defaults to** `null`.
     * @return \Generator
     */
    private function yieldRows(array $rows, $withStats = false, $transaction = null)
    {
        $fields = [];
        $values = [];
        foreach ($rows as $row) {
            $fields[] = [
                'name' => $row['name'],
                'type' => [
                    'code' => $row['type']
                ]
            ];

            $values[] = $row['value'];
        }

        $result = [
            'metadata' => [
                'rowType' => [
                    'fields' => $fields
                ]
            ],
            'values' => $values
        ];

        if ($withStats) {
            $result['stats'] = [
                'rowCountExact' => 1,
                'rowCountLowerBound' => 1
            ];
        }

        if ($transaction) {
            $result['metadata']['transaction'] = [
                'id' => $transaction
            ];
        }

        yield $result;
    }

    /**
     * Yield the given array as a generator.
     *
     * @param array $data The input data
     * @return \Generator
     */
    private function resultGeneratorData(array $data)
    {
        yield $data;
    }
}
