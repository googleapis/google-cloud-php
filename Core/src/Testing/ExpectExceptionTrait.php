<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Core\Testing;

/**
 * Provides methods for configuring exception expectations across multiple
 * incompatible versions of PHPUnit.
 */
trait ExpectExceptionTrait
{
    /**
     * Setup exception expectations for PHPUnit across major versions.
     *
     * @param $class string The exception class name. If the class does not
     *        exist, and the name contains "PHPUnit", the method will predict
     *        the counterpart method name. i.e. `\PHPUnit_Framework_Error_Warning`
     *        will be converted to `\PHPUnit\Framework\Error\Warning`, and vice
     *        versa. If neither exists, an error will be thrown.
     * @param string|null $message [optional] The exception message. If given,
     *        the message given must match the thrown exception message.
     * @return void
     * @throws \InvalidArgumentException If the class does not exist.
     */
    private function expectsException($class, $message = null)
    {
        if (!class_exists($class)) {
            $alternative = null;

            if (strpos($class, 'PHPUnit') !== false) {
                $class = trim($class, '_\\');
                if (strpos($class, '\\') !== false) {
                    $alternative = str_replace('\\', '_', $class);
                } else {
                    $alternative = str_replace('_', '\\', $class);
                }
            }

            if ($alternative === null || !class_exists($alternative)) {
                $msg = 'Class `%s`';
                if ($alternative) {
                    $msg .= ' and predicted variant `%s`';
                }
                $msg .= ' do not exist.';

                throw new \InvalidArgumentException(sprintf(
                    $msg,
                    $class,
                    $alternative
                ));
            }

            $class = $alternative;
        }

        if (method_exists($this, 'setExpectedException')) {
            $this->setExpectedException($class, $message);
        } else {
            $this->expectException($class);
            if ($message) {
                $this->expectExceptionMessage($message);
            }
        }
    }
}
