<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Trace;

/**
 * This plain PHP class represents a Link resource. A pointer from the current
 * span to another span in the same trace or in a different trace. For example,
 * this can be used in batching operations, where a single batch handler
 * processes multiple requests from different traces or when the handler
 * receives a request from a different project.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\Link;
 *
 * $link = new Link('abcd1234', 'abcd2345');
 * $span->addLink($link);
 * ```
 *
 * @see https://cloud.google.com/trace/docs/reference/v2/rest/v2/Links#link Link model documentation
 */
class Link implements \JsonSerializable
{
    use AttributeTrait;

    const TYPE_UNSPECIFIED = 'TYPE_UNSPECIFIED';
    const TYPE_CHILD_LINKED_SPAN = 'CHILD_LINKED_SPAN';
    const TYPE_PARENT_LINKED_SPAN = 'PARENT_LINKED_SPAN';

    /**
     * @var string The [TRACE_ID] for a trace within a project.
     */
    private $traceId;

    /**
     * @var string The [SPAN_ID] for a span within a trace.
     */
    private $spanId;

    /**
     * @var string The relationship of the current span relative to the linked
     *      span.
     */
    private $type;

    /**
     * Create a new Link.
     *
     * @param string $traceId
     * @param string $spanId
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $type The relationship of the current span relative to
     *           the linked span. **Defaults to** `TYPE_UNSPECIFIED`.
     *     @type int $uncompressedSizeBytes The number of uncompressed bytes
     *           sent or received.
     *     @type int $compressedSizeBytes The number of compressed bytes sent or
     *           received. If missing assumed to be the same size as
     *           uncompressed.
     * }
     */
    public function __construct($traceId, $spanId, array $options = [])
    {
        $options += [
            'type' => self::TYPE_UNSPECIFIED
        ];
        $this->traceId = $traceId;
        $this->spanId = $spanId;
        $this->type = $options['type'];
        if (array_key_exists('attributes', $options)) {
            $this->addAttributes($options['attributes']);
        }
    }

    /**
     * Returns a serializable array representing this Link.
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'traceId' => $this->traceId,
            'spanId' => $this->spanId,
            'type' => $this->type
        ];
        if ($this->attributes) {
            $data['attributes'] = $this->attributes;
        }

        return $data;
    }
}
