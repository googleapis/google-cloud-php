<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\ApiCore\Testing;

use Google\ApiCore\Serializer;
use Google\Protobuf\DescriptorPool;
use Google\Protobuf\Internal\MapField;
use Google\Protobuf\Internal\Message;
use Google\Protobuf\Internal\RepeatedField;
use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Exporter\Exporter;

/**
 * @internal
 */
class ProtobufMessageComparator extends Comparator
{
    /** @var Exporter */
    protected $exporter;

    public function __construct()
    {
        parent::__construct();
        $this->exporter = new MessageAwareExporter();
    }

    /**
     * Returns whether the comparator can compare two values.
     *
     * @param mixed $expected The first value to compare
     * @param mixed $actual The second value to compare
     * @return boolean
     */
    public function accepts($expected, $actual)
    {
        return $expected instanceof Message && $actual instanceof Message;
    }

    /**
     * Asserts that two values are equal.
     *
     * @param Message $expected The first value to compare
     * @param Message $actual The second value to compare
     * @param float|int $delta The allowed numerical distance between two values to
     *                      consider them equal
     * @param  bool $canonicalize If set to TRUE, arrays are sorted before
     *                             comparison
     * @param  bool $ignoreCase If set to TRUE, upper- and lowercasing is
     *                           ignored when comparing string values
     * @throws ComparisonFailure Thrown when the comparison
     *                           fails. Contains information about the
     *                           specific errors that lead to the failure.
     */
    public function assertEquals($expected, $actual, $delta = 0, $canonicalize = false, $ignoreCase = false)
    {
        if (!self::isProtobufEquals($expected, $actual)) {
            throw new ComparisonFailure(
                $expected,
                $actual,
                $this->exporter->shortenedExport($expected),
                $this->exporter->shortenedExport($actual),
                false,
                'Given 2 Message objects are not the same'
            );
        }
    }

    /**
     * Checks if two protobuf messages or values are equal.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @return bool
     */
    public static function isProtobufEquals($expected, $actual): bool
    {
        if ($expected === $actual) {
            return true;
        }

        if (gettype($expected) !== gettype($actual)) {
            return false;
        }

        if (is_object($expected)) {
            if (get_class($expected) !== get_class($actual)) {
                return false;
            }

            if ($expected instanceof Message) {
                if ($expected->serializeToString() === $actual->serializeToString()) {
                    return true;
                }

                $pool = DescriptorPool::getGeneratedPool();
                $descriptor = $pool->getDescriptorByClassName(get_class($expected));
                if (!$descriptor) {
                    return false;
                }

                $oneofCount = $descriptor->getOneofDeclCount();
                for ($i = 0; $i < $oneofCount; $i++) {
                    $oneof = $descriptor->getOneofDecl($i);
                    $getter = Serializer::getGetter($oneof->getName());
                    if ($expected->$getter() !== $actual->$getter()) {
                        return false;
                    }
                }

                $fieldCount = $descriptor->getFieldCount();
                for ($i = 0; $i < $fieldCount; $i++) {
                    $field = $descriptor->getField($i);
                    $getter = Serializer::getGetter($field->getName());
                    $expectedVal = $expected->$getter();
                    $actualVal = $actual->$getter();

                    if (!self::isProtobufEquals($expectedVal, $actualVal)) {
                        return false;
                    }
                }

                return true;
            }

            if ($expected instanceof MapField) {
                if (count($expected) !== count($actual)) {
                    return false;
                }
                foreach ($expected as $k => $v) {
                    if (!isset($actual[$k])) {
                        return false;
                    }
                    if (!self::isProtobufEquals($v, $actual[$k])) {
                        return false;
                    }
                }
                return true;
            }

            if ($expected instanceof RepeatedField) {
                if (count($expected) !== count($actual)) {
                    return false;
                }
                $count = count($expected);
                for ($i = 0; $i < $count; $i++) {
                    if (!self::isProtobufEquals($expected[$i], $actual[$i])) {
                        return false;
                    }
                }
                return true;
            }
        }

        if (is_array($expected)) {
            if (count($expected) !== count($actual)) {
                return false;
            }
            foreach ($expected as $k => $v) {
                if (!array_key_exists($k, $actual)) {
                    return false;
                }
                if (!self::isProtobufEquals($v, $actual[$k])) {
                    return false;
                }
            }
            return true;
        }

        return $expected === $actual;
    }
}
