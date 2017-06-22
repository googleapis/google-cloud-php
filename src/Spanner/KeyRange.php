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
 * Represents a Cloud Spanner KeyRange.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
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
 *
 * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.KeyRange KeyRange
 */
class KeyRange
{
    const TYPE_OPEN = 'open';
    const TYPE_CLOSED = 'closed';

    /**
     * @var string
     */
    private $startType;

    /**
     * @var array
     */
    private $start;

    /**
     * @var string
     */
    private $endType;

    /**
     * @var array
     */
    private $end;

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
     *           guaranteed correctness. **Defaults to** `KeyRange::TYPE_OPEN`.
     *     @type array $start The key with which to start the range.
     *     @type string $endType Either "open" or "closed". Use constants
     *           `KeyRange::TYPE_OPEN` and `KeyRange::TYPE_CLOSED` for
     *           guaranteed correctness. **Defaults to** `KeyRange::TYPE_OPEN`.
     *     @type array $end The key with which to end the range.
     * }
     */
    public function __construct(array $options = [])
    {
        $options += [
            'startType' => KeyRange::TYPE_OPEN,
            'start' => null,
            'endType' => KeyRange::TYPE_OPEN,
            'end' => null
        ];

        $this->startType = $this->fromDefinition($options['startType'], 'start');
        $this->endType = $this->fromDefinition($options['endType'], 'end');

        $this->start = ($options['start'] === null || is_array($options['start']))
            ? $options['start']
            : [$options['start']];

        $this->end = ($options['end'] === null || is_array($options['end']))
            ? $options['end']
            : [$options['end']];
    }

    /**
     * Returns a key range that covers all keys where the first components match.
     *
     * Equivalent to calling `KeyRange::__construct()` with closed type for start
     * and end, and the same key for the start and end.
     *
     * Example:
     * ```
     * $range = KeyRange::prefixMatch($key);
     * ```
     *
     * @param array $key The key to match against.
     * @return KeyRange
     */
    public static function prefixMatch(array $key)
    {
        return new static([
            'startType' => self::TYPE_CLOSED,
            'endType' => self::TYPE_CLOSED,
            'start' => $key,
            'end' => $key
        ]);
    }

    /**
     * Get the range start.
     *
     * Example:
     * ```
     * $start = $range->start();
     * ```
     *
     * @return array|null
     */
    public function start()
    {
        return $this->start;
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
        $rangeKey = $this->fromDefinition($type, 'start');

        $this->startType = $rangeKey;
        $this->start = $start;
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
        return $this->end;
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

        $rangeKey = $this->fromDefinition($type, 'end');

        $this->endType = $rangeKey;
        $this->end = $end;
    }

    /**
     * Get the start and end types
     *
     * Example:
     * ```
     * $types = $range->types();
     * ```
     *
     * @return array An array containing `start` and `end` keys.
     */
    public function types()
    {
        return [
            'start' => $this->startType,
            'end' => $this->endType
        ];
    }

    /**
     * Returns an API-compliant representation of a KeyRange.
     *
     * @return array
     * @access private
     */
    public function keyRangeObject()
    {
        if (!$this->start || !$this->end) {
            throw new \BadMethodCallException('Key Range must supply a start and an end');
        }

        return [
            $this->startType => $this->start,
            $this->endType => $this->end
        ];
    }

    private function fromDefinition($type, $startOrEnd)
    {
        if (!in_array($type, array_keys($this->definition))) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid KeyRange %s type. Allowed values are %s.',
                $startOrEnd,
                implode(', ', array_keys($this->definition))
            ));
        }

        return $this->definition[$type][$startOrEnd];
    }
}
