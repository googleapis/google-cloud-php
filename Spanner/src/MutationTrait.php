<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Spanner;

use Google\Cloud\Core\ArrayTrait;
use Google\ApiCore\ValidationException;

/**
 * Common helper methods used for creating array representation of
 * {@see \Google\Cloud\Spanner\V1\Mutation}
 */
trait MutationTrait
{
    use ArrayTrait;
    /**
     * Create a formatted mutation.
     *
     * @param string $operation The operation type.
     * @param string $table The table name.
     * @param array $mutation The mutation data, represented as a set of
     *        key/value pairs.
     * @return array
     */
    public function mutation($operation, $table, $mutation)
    {
        return [
            $operation => [
                'table' => $table,
                'columns' => array_keys($mutation),
                'values' => $this->getValueMapper()->encodeValuesAsSimpleType(array_values($mutation))
            ]
        ];
    }

    /**
     * Create a formatted delete mutation.
     *
     * @param string $table The table name.
     * @param KeySet $keySet The keys to delete.
     * @return array
     */
    public function deleteMutation($table, KeySet $keySet)
    {
        return [
            'delete' => [
                'table' => $table,
                'keySet' => $this->flattenKeySet($keySet),
            ]
        ];
    }

    private function getValueMapper()
    {
        if (!isset($this->mapper)) {
            throw ValidationException(
                'MutationTrait usage requires `ValueMapper` to be ' .
                'present in the user class in the `$this->mapper` property.'
            );
        }

        return $this->mapper;
    }

    private function flattenKeySet(KeySet $keySet)
    {
        $keys = $keySet->keySetObject();

        if (!empty($keys['ranges'])) {
            foreach ($keys['ranges'] as $index => $range) {
                foreach ($range as $type => $rangeKeys) {
                    $range[$type] = $this->getValueMapper()->encodeValuesAsSimpleType($rangeKeys);
                }

                $keys['ranges'][$index] = $range;
            }
        }

        if (!empty($keys['keys'])) {
            $keys['keys'] = $this->getValueMapper()->encodeValuesAsSimpleType($keys['keys'], true);
        }

        return $this->arrayFilterRemoveNull($keys);
    }
}
