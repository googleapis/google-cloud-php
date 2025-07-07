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

use Google\Protobuf\Internal\Message;
use RuntimeException;
use TypeError;

/**
 * Typed Options
 *
 * Validate an untyped array of options
 */
class TypedOptions
{
    /**
     * Executes the retry process.
     *
     * @param array<string, mixed> $optionsAndTypes associative array of options keys with their
     *        corresponding types.
     * @param Message|null         $message         Protobuf message which can also be created from
     *        the options keys
     */
    public function __construct(
        private array $optionsAndTypes,
        private Message|null $message = null,
    ) {
    }

    /**
     * Validates the types of the expected options and removes all unrecognized options.
     *
     * @param array<string, mixed> $options user provided option array to validate
     * @return array
     * @throws TypeError when options provided do not validate types
     * @throws RuntimeException when an invalid type is provided
     */
    public function validate(array $options): array
    {
        $validatedOptions = [];
        foreach ($options as $optionName => $optionValue) {
            if (array_key_exists($optionName, $this->optionsAndTypes)) {
                $validatedOptions[$optionName] =
                    $this->verifyType($optionValue, $optionName);
            } elseif ($this->message && $this->messageHasSetter($optionName)) {
                $validatedOptions[$optionName] = $optionValue;
            } else {
                // ignore unknown options but remove them from our options array
            }
        }

        return $validatedOptions;
    }

    private function verifyType(mixed $optionValue, string $optionName)
    {
        $optionType = $this->optionsAndTypes[$optionName];
        return match ($optionType) {
            'bool' => $this->checkBool($optionValue),
            'int' => $this->checkInt($optionValue),
            'float'  => $this->checkFloat($optionValue),
            'string' => $this->checkString($optionValue),
            'array'   => $this->checkArray($optionValue),
            default   => class_exists($optionType)
                ? $this->checkInstanceOf($optionValue, $optionType, $optionName)
                : throw new RuntimeException(sprintf(
                    'invalid option type "%s" for option "%s"',
                    $optionType,
                    $optionName
                )),
        };
    }

    private function checkBool(bool $bool): bool
    {
        return $bool;
    }

    private function checkInt(int $int): int
    {
        return $int;
    }

    private function checkString(string $string): string
    {
        return $string;
    }

    private function checkFloat(float $float): float
    {
        return $float;
    }

    private function checkArray(array $array): array
    {
        return $array;
    }

    private function checkInstanceOf(
        mixed $optionValue,
        string $expectedClass,
        string $optionName
    ): object {
        if (!$optionValue instanceof $expectedClass) {
            throw new TypeError(sprintf(
                'Option %s must be of type %s, %s given',
                $optionName,
                $expectedClass,
                is_object($optionValue) ? get_class($optionValue) : gettype($optionValue)
            ));
        }
        return $optionValue;
    }

    private function messageHasSetter(string $optionName): bool
    {
        $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $optionName)));
        return method_exists($this->message, $setter);
    }
}
