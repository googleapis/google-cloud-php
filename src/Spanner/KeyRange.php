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

/**
 * Represents a Google Cloud Spanner KeyRange.
 *
 * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.KeyRange KeyRange
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $spanner = $cloud->spanner();
 *
 * // Create a KeyRange for all people named Bob, born in 1969.
 * $start = $spanner->date(new \DateTime('1969-01-01'));
 * $end = $spanner->date(new \DateTime('1969-12-31'));
 *
 * $range = $spanner->keyRange([
 *     'startType' => KeyRange::TYPE_CLOSED,
 *     'start' => ['Bob', $start],
 *     'endType' => KeyRange::TYPE_CLOSED,
 *     'end' => ['Bob', $end]
 * ]);
 * ```
 */
class KeyRange
{
    const TYPE_OPEN = 'open';
    const TYPE_CLOSED = 'closed';

    /**
     * @var array
     */
    private $types = [];

    /**
     * @var array
     */
    private $range = [];

    /**
     * @var array
     */
    private $definition = [
        self::TYPE_OPEN => [
            'start' => 'startOpen',
            'end' => 'endOpen'
        ],
        self::TYPE_CLOSED => [
            'start' => 'startClosed',
            'end' => 'endClosed'
        ]
    ];

    /**
     * Create a KeyRange.
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $startType Either "open" or "closed". Use constants
     *           `KeyRange::TYPE_OPEN` and `KeyRange::TYPE_CLOSED` for
     *           guaranteed correctness.
     *     @type array $start The key with which to start the range.
     *     @type string $endType Either "open" or "closed". Use constants
     *           `KeyRange::TYPE_OPEN` and `KeyRange::TYPE_CLOSED` for
     *           guaranteed correctness.
     *     @type array $end The key with which to end the range.
     * }
     */
    public function __construct(array $options = [])
    {
        $options = array_filter($options + [
            'startType' => null,
            'start' => [],
            'endType' => null,
            'end' => []
        ]);

        if (isset($options['startType']) && isset($options['start'])) {
            $this->setStart($options['startType'], $options['start']);
        }

        if (isset($options['endType']) && isset($options['end'])) {
            $this->setEnd($options['endType'], $options['end']);
        }
    }

    /**
     * Get the range start.
     *
     * Example:
     * ```
     * $start = $range->start();
     * ```
     *
     * @return array
     */
    public function start()
    {
        $type = $this->types['start'];
        return $this->range[$this->definition[$type]['start']];
    }

    /**
     * Set the range start.
     *
     * Example:
     * ```
     * $range->setStart(KeyRange::TYPE_OPEN, ['Bob']);
     * ```
     *
     * @param string $type Either "open" or "closed". Use constants
     *        `KeyRange::TYPE_OPEN` and `KeyRange::TYPE_CLOSED` for guaranteed
     *        correctness.
     * @param array $start The start of the key range.
     * @return void
     */
    public function setStart($type, array $start)
    {
        if (!in_array($type, array_keys($this->definition))) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid KeyRange type. Allowed values are %s',
                implode(', ', array_keys($this->definition))
            ));
        }

        $rangeKey = $this->definition[$type]['start'];

        $this->types['start'] = $type;
        $this->range[$rangeKey] = $start;
    }

    /**
     * Get the range end.
     *
     * Example:
     * ```
     * $end = $range->end();
     * ```
     *
     * @return array
     */
    public function end()
    {
        $type = $this->types['end'];
        return $this->range[$this->definition[$type]['end']];
    }

    /**
     * Set the range end.
     *
     * Example:
     * ```
     * $range->setEnd(KeyRange::TYPE_CLOSED, ['Jill']);
     * ```
     *
     * @param string $type Either "open" or "closed". Use constants
     *        `KeyRange::TYPE_OPEN` and `KeyRange::TYPE_CLOSED` for guaranteed
     *        correctness.
     * @param array $end The end of the key range.
     * @return void
     */
    public function setEnd($type, array $end)
    {
        if (!in_array($type, array_keys($this->definition))) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid KeyRange type. Allowed values are %s',
                implode(', ', array_keys($this->definition))
            ));
        }

        $rangeKey = $this->definition[$type]['end'];

        $this->types['end'] = $type;
        $this->range[$rangeKey] = $end;
    }

    /**
     * Get the start and end types
     *
     * Example:
     * ```
     * $types = $range->types();
     * ```
     *
     * @return array
     */
    public function types()
    {
        return $this->types;
    }

    /**
     * Returns an API-compliant representation of a KeyRange.
     *
     * @return array
     * @access private
     */
    public function keyRangeObject()
    {
        if (count($this->range) !== 2) {
            throw new \BadMethodCallException('Key Range must supply a start and an end');
        }

        return $this->range;
    }
}
