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

namespace Google\Cloud\Debugger;

/**
 * Represents a message with parameters.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\FormatMessage;
 *
 * $message = new FormatMessage('message with placeholders', ['additional parameter']);
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees.breakpoints#formatmessage FormatMessage model documentation
 * @codingStandardsIgnoreEnd
 */
class FormatMessage
{
    /**
     * @var string Format template for the message. The format uses placeholders
     *      $0, $1, etc. to reference parameters. $$ can be used to denote the
     *      $ character.
     */
    private $format;

    /**
     * @var string[] Optional parameters to be embedded into the message.
     */
    private $parameters;

    /**
     * Instantiate a new FormatMessage
     *
     * @access private
     * @param string $format Format template for the message. The format
     *        uses placeholders $0, $1, etc. to reference parameters. $$ can
     *        be used to denote the $ character.
     * @param string[] $parameters Optional parameters to be embedded into the message.
     */
    public function __construct($format, array $parameters = [])
    {
        $this->format = $format;
        $this->parameters = $parameters;
    }

    /**
     * Load a new FormatMessage from JSON form
     *
     * Example:
     * ```
     * $message = FormatMessage::fromJson([
     *     'format' => 'message with placeholders',
     *     'parameters' => ['additional parameter']
     * ]);
     * ```
     *
     * @access private
     * @param array $data {
     *      FormatMessage params
     *
     *      @type string $format Format template for the message. The format
     *            uses placeholders $0, $1, etc. to reference parameters. $$ can
     *            be used to denote the $ character.
     *      @type string[] $parameters Optional parameters to be embedded into the message.
     * }
     * @return FormatMessage
     */
    public static function fromJson(array $data)
    {
        $data += [
            'format' => null,
            'parameters' => []
        ];
        return new static($data['format'], $data['parameters']);
    }

    /**
     * Return a serializable version of this object
     *
     * @access private
     * @return array
     */
    public function info()
    {
        return [
            'format' => $this->format,
            'parameters' => $this->parameters
        ];
    }
}
