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
     * @param array $data {
     *      FormatMessage params
     *
     *      @type string $format Format template for the message. The format
     *            uses placeholders $0, $1, etc. to reference parameters. $$ can
     *            be used to denote the $ character.
     *      @type string[] Optional parameters to be embedded into the message.
     * }
     */
    public function __construct(array $data = [])
    {
        $this->format = $data['format'];
        $this->parameters = $data['parameters'];
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'format' => $this->format,
            'parameters' => $this->parameters
        ];
    }
}
