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

use Google\Cloud\Core\ValidateTrait;

/**
 * Represents a Cloud Spanner KeySet.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $keySet = $spanner->keySet();
 * ```
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

    /**
     * Create a KeySet.
     *
     * @param array $options [optional] {
     *     @type array $keys A list of specific keys. Entries in keys should
     *           have exactly as many elements as there are columns in the
     *           primary or index key with which this KeySet is used.
     *     @type KeyRange[] $ranges A list of Key Ranges.
     *     @type bool $all If true, KeySet will match all keys in a table.
     *           **Defaults to** `false`.
     * }
     */
    public function __construct(array $options = [])
    {
        $options += [
            'keys' => [],
            'ranges' => [],
            'all' => false
        ];

        $this->validateBatch($options['ranges'], KeyRange::class);

        if (!is_array($options['keys'])) {
            throw new \InvalidArgumentException('$options.keys must be an array.');
        }

        if (!is_bool($options['all'])) {
            throw new \InvalidArgumentException('$options.all must be a boolean.');
        }

        $this->keys = $options['keys'];
        $this->ranges = $options['ranges'];
        $this->all = (bool) $options['all'];
    }

    /**
     * Fetch the KeyRanges
     *
     * Example:
     * ```
     * $ranges = $keySet->ranges();
     * ```
     *
     * @return KeyRange[]
     */
    public function ranges()
    {
        return $this->ranges;
    }


    /**
     * Add a single KeyRange.
     *
     * Example:
     * ```
     * $range = new KeyRange();
     * $keySet->addRange($range);
     * ```
     *
     * @param KeyRange $range A KeyRange instance.
     * @return void
     */
    public function addRange(KeyRange $range)
    {
        $this->ranges[] = $range;
    }

    /**
     * Set the KeySet's KeyRanges.
     *
     * Any existing KeyRanges will be overridden.
     *
     * Example:
     * ```
     * $range = new KeyRange();
     * $keySet->setRanges([$range]);
     * ```
     *
     * @param KeyRange[] $ranges An array of KeyRange objects.
     * @return void
     */
    public function setRanges(array $ranges)
    {
        $this->validateBatch($ranges, KeyRange::class);

        $this->ranges = $ranges;
    }

    /**
     * Fetch the keys.
     *
     * Example:
     * ```
     * $keys = $keySet->keys();
     * ```
     *
     * @return mixed[]
     */
    public function keys()
    {
        return $this->keys;
    }

    /**
     * Add a single key.
     *
     * A Key should have exactly as many elements as there are columns in the
     * primary or index key with which this KeySet is used.
     *
     * Example:
     * ```
     * $keySet->addKey('Bob');
     * ```
     *
     * @param mixed $key The Key to add.
     * @return void
     */
    public function addKey($key)
    {
        $this->keys[] = $key;
    }

    /**
     * Set the KeySet keys.
     *
     * Any existing keys will be overridden.
     *
     * Example:
     * ```
     * $keySet->setKeys(['Bob', 'Jill']);
     * ```
     *
     * @param mixed[] $keys
     * @return void
     */
    public function setKeys(array $keys)
    {
        $this->keys = $keys;
    }

    /**
     * Get the value of Match All.
     *
     * Example:
     * ```
     * if ($keySet->matchAll()) {
     *     echo "All keys will match";
     * }
     * ```
     *
     * @return bool
     */
    public function matchAll()
    {
        return $this->all;
    }

    /**
     * Choose whether the KeySet should match all keys in a table.
     *
     * Example:
     * ```
     * $keySet->setMatchAll(true);
     * ```
     *
     * @param bool $all If true, all keys in a table will be matched.
     * @return void
     */
    public function setMatchAll($all)
    {
        $this->all = (bool) $all;
    }

    /**
     * Format a KeySet object for use in the Spanner API.
     *
     * @access private
     */
    public function keySetObject()
    {
        $ranges = [];
        foreach ($this->ranges as $range) {
            $ranges[] = $range->keyRangeObject();
        }

        $set = [];

        if ($this->all) {
            $set['all'] = true;
        }

        if ($this->keys) {
            $set['keys'] = $this->keys;
        }

        if ($ranges) {
            $set['ranges'] = $ranges;
        }

        return $set;
    }
}
