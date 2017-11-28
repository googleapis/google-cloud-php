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

use Google\Cloud\Core\ArrayTrait;

/**
 * This plain PHP class represents a Link resource.
 */
class Link implements \JsonSerializable
{
    use ArrayTrait;
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
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->traceId = $this->pluck('traceId', $options, false);
        $this->spanId = $this->pluck('spanId', $options, false);
        $this->type = $this->pluck('type', $options, false) ?: self::TYPE_UNSPECIFIED;
        if (array_key_exists('attributes', $options)) {
            $this->addAttributes($options['attributes']);
        }
    }

    /**
     * Returns a serializable array representing this Link.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [];
        if ($this->traceId) {
            $data['traceId'] = $this->traceId;
        }
        if ($this->spanId) {
            $data['spanId'] = $this->spanId;
        }
        if ($this->type) {
            $data['type'] = $this->type;
        }
        if ($this->attributes) {
            $data['attributes'] = $this->attributes;
        }

        return $data;
    }
}
