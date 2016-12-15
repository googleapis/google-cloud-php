<?php
/**
 * Copyright 2016 Google Inc.
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

use Google\Cloud\ValidateTrait;

/**
 * Represents a Google Cloud Spanner KeySet.
 *
 * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#keyset KeySet
 */
class KeySet
{
    use ValidateTrait;

    /**
     * @var array
     */
    private $keys;

    /**
     * @var KeyRange[]
     */
    private $ranges;

    /**
     * @var bool
     */
    private $all;

    public function __construct(array $options = [])
    {
        $options += [
            'keys' => [],
            'ranges' => [],
            'all' => false
        ];

        $this->validateBatch($options['ranges'], KeyRange::class);

        $this->keys = $options['keys'];
        $this->ranges = $options['ranges'];
        $this->all = (bool) $options['all'];
    }

    public function addRange(KeyRange $range)
    {
        $this->ranges[] = $range;
    }

    public function setRanges(array $ranges)
    {
        $this->validateBatch($ranges, KeyRange::class);

        $this->ranges = $ranges;
    }

    public function addKey($key)
    {
        $this->keys[] = $key;
    }

    public function setKeys(array $keys)
    {
        $this->keys = $keys;
    }

    public function setAll($all)
    {
        $this->all = (bool) $all;
    }

    public function keySetObject()
    {
        $ranges = [];
        foreach ($this->ranges as $range) {
            $ranges[] = $range->keyRangeObject();
        }

        return [
            'keys' => $this->keys,
            'ranges' => $ranges,
            'all' => $this->all
        ];
    }
}
