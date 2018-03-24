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
 * This plain PHP class represents an MessageEvent resource. An event describing
 * a message sent/received between Spans.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\MessageEvent;
 *
 * $messageEvent = new MessageEvent('some-event-id');
 * $span->addTimeEvent($messageEvent);
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/trace/docs/reference/v2/rest/v2/TimeEvents#messageevent MessageEvent model documentation
 * @codingStandardsIgnoreEnd
 */
class MessageEvent extends TimeEvent
{
    const TYPE_UNSPECIFIED = 'TYPE_UNSPECIFIED';
    const TYPE_SENT = 'SENT';
    const TYPE_RECEIVED = 'RECEIVED';

    /**
     * @var string Type of MessageEvent. Indicates whether the message was sent
     *      or received.
     */
    private $type;

    /**
     * @var int An identifier for the MessageEvent's message that can be used to
     *      match SENT and RECEIVED MessageEvents. It is recommended to be
     *      unique within a Span.
     */
    private $id;

    /**
     * @var int The number of uncompressed bytes sent or received.
     */
    private $uncompressedSizeBytes;

    /**
     * @var int The number of compressed bytes sent or received. If missing,
     *      assumed to be the same size as uncompressed.
     */
    private $compressedSizeBytes;

    /**
     * Create a new MessageEvent.
     *
     * @param $id An identifier for the MessageEvent's message that can be used
     *        to match SENT and RECEIVED MessageEvents. It is recommended to be
     *        unique within a Span.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $type Type of MessageEvent. Indicates whether the
     *           message was sent or received. **Defaults to**
     *           `TYPE_UNSPECIFIED`.
     *     @type int $uncompressedSizeBytes The number of uncompressed bytes
     *           sent or received.
     *     @type int $compressedSizeBytes The number of compressed bytes sent or
     *           received. If missing assumed to be the same size as
     *           uncompressed.
     * }
     */
    public function __construct($id, array $options = [])
    {
        parent::__construct($options);
        $options += [
            'type' => self::TYPE_UNSPECIFIED,
            'uncompressedSizeBytes' => null,
            'compressedSizeBytes' => null
        ];
        $this->id = $id;
        $this->type = $options['type'];
        $this->uncompressedSizeBytes = $options['uncompressedSizeBytes'];
        $this->compressedSizeBytes = $options['compressedSizeBytes'];
    }

    /**
     * Returns a serializable array representing this MessageEvent.
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type
        ];

        if ($this->uncompressedSizeBytes) {
            $data['uncompressedSizeBytes'] = $this->uncompressedSizeBytes;
        }
        if ($this->compressedSizeBytes) {
            $data['compressedSizeBytes'] = $this->compressedSizeBytes;
        }

        return [
            'time' => $this->time,
            'messageEvent' => $data
        ];
    }
}
