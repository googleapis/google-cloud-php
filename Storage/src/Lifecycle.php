<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Storage;

/**
 * Object Lifecycle Management supports common use cases like setting a Time to
 * Live (TTL) for objects, archiving older versions of objects, or "downgrading"
 * storage classes of objects to help manage costs.
 *
 * This builder does not execute any network requests and is intended to be used
 * in combination with either
 * {@see Google\Cloud\Storage\StorageClient::createBucket()}
 * or {@see Google\Cloud\Storage\Bucket::update()}.
 *
 * Example:
 * ```
 * // Access a builder preconfigured with rules already existing on a given
 * // bucket.
 * use Google\Cloud\Storage\StorageClient;
 *
 * $storage = new StorageClient();
 * $bucket = $storage->bucket('my-bucket');
 * $lifecycle = $bucket->currentLifecycle();
 * ```
 *
 * ```
 * // Or get a fresh builder by using the static factory method.
 * use Google\Cloud\Storage\Bucket;
 *
 * $lifecycle = Bucket::lifecycle();
 * ```
 *
 * @see https://cloud.google.com/storage/docs/lifecycle Object Lifecycle Management API Documentation
 */
class Lifecycle implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array
     */
    private $lifecycle;

    /**
     * @param array $lifecycle [optional] A lifecycle configuration. Please see
     *        [here](https://cloud.google.com/storage/docs/json_api/v1/buckets#lifecycle)
     *        for the expected structure.
     */
    public function __construct(array $lifecycle = [])
    {
        $this->lifecycle = $lifecycle;
    }

    /**
     * Adds an Object Lifecycle Delete Rule.
     *
     * Example:
     * ```
     * $lifecycle->addDeleteRule([
     *     'age' => 50,
     *     'isLive' => true
     * ]);
     * ```
     *
     * @param array $condition {
     *     The condition(s) where the rule will apply.
     *
     *     @type int $age Age of an object (in days). This condition is
     *           satisfied when an object reaches the specified age.
     *     @type string $createdBefore A date in RFC 3339 format with only the
     *           date part (for instance, "2013-01-15"). This condition is
     *           satisfied when an object is created before midnight of the
     *           specified date in UTC.
     *     @type bool $isLive Relevant only for versioned objects. If the value
     *           is `true`, this condition matches live objects; if the value is
     *           `false`, it matches archived objects.
     *     @type string[] $matchesStorageClass Objects having any of the storage
     *           classes specified by this condition will be matched. Values
     *           include `"MULTI_REGIONAL"`, `"REGIONAL"`, `"NEARLINE"`,
     *           `"COLDLINE"`, `"STANDARD"`, and `"DURABLE_REDUCED_AVAILABILITY"`.
     *     @type int $numNewerVersions Relevant only for versioned objects. If
     *           the value is N, this condition is satisfied when there are at
     *           least N versions (including the live version) newer than this
     *           version of the object.
     * }
     * @return Lifecycle
     */
    public function addDeleteRule(array $condition)
    {
        $this->lifecycle['rule'][] = [
            'action' => [
                'type' => 'Delete'
            ],
            'condition' => $condition
        ];

        return $this;
    }

    /**
     * Adds an Object Lifecycle Set Storage Class Rule.
     *
     * Example:
     * ```
     * $lifecycle->addSetStorageClassRule('COLDLINE', [
     *     'age' => 50,
     *     'isLive' => true
     * ]);
     * ```
     *
     * @param string $storageClass The target storage class. Values include
     *        `"MULTI_REGIONAL"`, `"REGIONAL"`, `"NEARLINE"`, `"COLDLINE"`,
     *        `"STANDARD"`, and `"DURABLE_REDUCED_AVAILABILITY"`.
     * @param array $condition {
     *     The condition(s) where the rule will apply.
     *
     *     @type int $age Age of an object (in days). This condition is
     *           satisfied when an object reaches the specified age.
     *     @type string $createdBefore A date in RFC 3339 format with only the
     *           date part (for instance, "2013-01-15"). This condition is
     *           satisfied when an object is created before midnight of the
     *           specified date in UTC.
     *     @type bool $isLive Relevant only for versioned objects. If the value
     *           is `true`, this condition matches live objects; if the value is
     *           `false`, it matches archived objects.
     *     @type string[] $matchesStorageClass Objects having any of the storage
     *           classes specified by this condition will be matched. Values
     *           include `"MULTI_REGIONAL"`, `"REGIONAL"`, `"NEARLINE"`,
     *           `"COLDLINE"`, `"STANDARD"`, and `"DURABLE_REDUCED_AVAILABILITY"`.
     *     @type int $numNewerVersions Relevant only for versioned objects. If
     *           the value is N, this condition is satisfied when there are at
     *           least N versions (including the live version) newer than this
     *           version of the object.
     * }
     * @return Lifecycle
     */
    public function addSetStorageClassRule($storageClass, array $condition)
    {
        $this->lifecycle['rule'][] = [
            'action' => [
                'type' => 'SetStorageClass',
                'storageClass' => $storageClass
            ],
            'condition' => $condition
        ];

        return $this;
    }

    /**
     * Clear all Object Lifecycle rules or rules of a certain action type.
     *
     * Example:
     * ```
     * // Remove all rules.
     * $lifecycle->clearRules();
     * ```
     *
     * ```
     * // Remove all "Delete" based rules.
     * $lifecycle->clearRules('Delete');
     * ```
     *
     * ```
     * // Clear any rules which have an age equal to 50.
     * $lifecycle->clearRules(function (array $rule) {
     *     return $rule['condition']['age'] === 50
     *         ? false
     *         : true;
     * });
     * ```
     *
     * @param string|callable $action [optional] If a string is provided, it
     *        must be the name of the type of rule to remove (`SetStorageClass`
     *        or `Delete`). All rules of this type will then be cleared. When
     *        providing a callable you may define a custom route for how you
     *        would like to remove rules. The provided callable will be run
     *        through
     *        [array_filter](http://php.net/manual/en/function.array-filter.php).
     *        The callable's argument will be a single lifecycle rule as an
     *        associative array. When returning true from the callable the rule
     *        will be preserved, and if false it will be removed.
     *        **Defaults to** `null`, clearing all assigned rules.
     * @return Lifecycle
     * @throws \InvalidArgumentException If a type other than a string or
     *         callabe is provided.
     */
    public function clearRules($action = null)
    {
        if (!$action) {
            $this->lifecycle = [];
            return $this;
        }

        if (!is_string($action) && !is_callable($action)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected either a string or callable, instead got \'%s\'.',
                    gettype($action)
                )
            );
        }

        if (isset($this->lifecycle['rule'])) {
            if (is_string($action)) {
                $action = function ($rule) use ($action) {
                    return $rule['action']['type'] !== $action;
                };
            }

            $this->lifecycle['rule'] = array_filter(
                $this->lifecycle['rule'],
                $action
            );

            if (!$this->lifecycle['rule']) {
                $this->lifecycle = [];
            }
        }

        return $this;
    }

    /**
     * @access private
     * @return \Generator
     */
    public function getIterator()
    {
        if (!isset($this->lifecycle['rule'])) {
            return;
        }

        foreach ($this->lifecycle['rule'] as $rule) {
            yield $rule;
        }
    }

    /**
     * @access private
     * @return array
     */
    public function toArray()
    {
        return $this->lifecycle;
    }

    /**
     * @access private
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->lifecycle['rule'][$offset] = $value;
    }

    /**
     * @access private
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->lifecycle['rule'][$offset]);
    }

    /**
     * @access private
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->lifecycle['rule'][$offset]);
    }

    /**
     * @access private
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->lifecycle['rule'][$offset])
            ? $this->lifecycle['rule'][$offset]
            : null;
    }
}
