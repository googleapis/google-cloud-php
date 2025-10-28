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
namespace Google\Cloud\Core;

use Google\ApiCore\ArrayTrait;
use Google\ApiCore\Options\CallOptions;
use Google\ApiCore\Serializer;
use Google\Protobuf\Internal\Message;
use LogicException;

/**
 * Helper used to validate options
 *
 * @internal
 */
class OptionsValidator
{
    use ArrayTrait;

    /**
     * @param ?Serializer $serializer use a serializer to decode protobuf messages
     *        instead of calling {@see Message::mergeFromJsonString()}.
     */
    public function __construct(
        private ?Serializer $serializer = null
    ) {
    }

    /**
     * Validate an array of options based on the supplied `$optionTypes`.
     * $optionTypes can be an array of string keys, a protobuf Message classname, or a
     * the CallOptions classname. Parameters are split and returned in the order
     * that the options types are provided.
     *
     *  - If the option type is an array, any keys in $options matching the string values
     *    of the array are returned.
     *  - If the option type is {@see Message}, any keys matching getters will be set on the message.
     *  - If the option type is string, and that string is a valid {@see CallOptions} option, those
     *    options will be returned in an array
     *
     * ```
     * [$customOps, $commitRequest, $callOptions] = $optionsValidator->vaidateOptions(
     *     $options,
     *     ['customOp1', 'customOp2'],
     *     new CommitRequest(),
     *     CallOptions::class,
     * );
     * ```
     *
     * @param array $options
     * @param array|Message|string ...$optionTypes
     * @return array
     * @throws LogicException when a value exists which is not supported by any of the `$optionTypes`.
     */
    public function validateOptions(array $options, array|Message|string ...$optionTypes): array
    {
        $splitOptions = [];
        foreach ($optionTypes as $optionType) {
            if (is_array($optionType)) {
                $splitOptions[] = $this->pluckArray($optionType, $options);
            } elseif ($optionType === CallOptions::class) {
                $callOptionKeys = array_keys((new CallOptions([]))->toArray());
                $splitOptions[] = $this->pluckArray($callOptionKeys, $options);
            } elseif ($optionType instanceof Message) {
                $messageKeys = array_map(
                    fn ($method) => lcfirst(substr($method, 3)),
                    array_filter(
                        get_class_methods($optionType),
                        fn ($m) => 0 === strpos($m, 'get')
                    )
                );
                $messageOptions = $this->pluckArray($messageKeys, $options);
                if ($this->serializer) {
                    $optionType = $this->serializer->decodeMessage($optionType, $messageOptions);
                } else {
                    $optionType->mergeFromJsonString(json_encode($messageOptions, JSON_FORCE_OBJECT));
                }
                $splitOptions[] = $optionType;
            } elseif (is_string($optionType)) {
                $splitOptions[] = $this->pluck($optionType, $options, false);
            } else {
                throw new LogicException(sprintf('Invalid option type: %s', $optionType));
            }
        }

        if (!empty($options)) {
            throw new LogicException(
                'Unexpected option(s) provided: ' . implode(', ', array_keys($options))
            );
        }

        return $splitOptions;
    }
}
