<?php
/**
 * Copyright 2025 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Spanner;

use Google\Protobuf\Internal\DescriptorPool;
use Google\Protobuf\Internal\Message;
use RuntimeException;

/**
 * Represents a value with a data type of
 * [proto](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TypeCode).
 *
 * @phpstan-template T of Message
 */
class Proto implements ValueInterface
{
    /**
     * @param string $value The proto data, base64-encoded.
     * @param string $protoTypeFqn The fully qualified name of the proto type.
     */
    public function __construct(
        private string $value,
        private string $protoTypeFqn
    ) {
    }

    /**
     * Get the proto column as a protobuf Message.
     *
     * Example:
     * ```
     * $message = $proto->get();
     * var_dump($message->serializeToJsonString());
     * ```
     *
     * @return T
     * @throws RuntimeException If the proto type is not found.
     */
    public function get(): Message
    {
        /** @var \Google\Protobuf\Internal\DescriptorPool $pool */
        $pool = DescriptorPool::getGeneratedPool();
        /** @var \Google\Protobuf\Internal\Descriptor|null $descriptor */
        $descriptor = $pool->getDescriptorByProtoName($this->protoTypeFqn);
        if (!$descriptor) {
            throw new RuntimeException(sprintf(
                'Unable to decode proto value. Descriptor not found for %s.',
                $this->protoTypeFqn
            ));
        }
        /** @var Message $message */
        $message = new ($descriptor->getClass())();
        $message->mergeFromString(base64_decode($this->value));
        return $message;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getProtoTypeFqn(): string
    {
        return $this->protoTypeFqn;
    }

    /**
     * Get the type.
     *
     * Example:
     * ```
     * echo $proto->type();
     * ```
     *
     * @return int
     */
    public function type(): int
    {
        return Database::TYPE_PROTO;
    }

    /**
     * Format the value as a string.
     *
     * Example:
     * ```
     * echo $proto->formatAsString();
     * ```
     *
     * @return string
     */
    public function formatAsString(): string
    {
        return $this->value;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     * @access private
     */
    public function __toString()
    {
        return $this->formatAsString();
    }
}
