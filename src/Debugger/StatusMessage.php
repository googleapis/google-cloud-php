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
 * Represents a contextual status message. The message can indicate an error or
 * informational status, and refer to specific parts of the containing object.
 * For example, the Breakpoint.status field can indicate an error referring to
 * the BREAKPOINT_SOURCE_LOCATION with the message Location not found.
 */
class StatusMessage implements \JsonSerializable
{
    /**
     * @var bool Distinguishes errors from informational messages.
     */
    private $isError;

    /**
     * @var Reference Reference to which the message applies.
     */
    private $refersTo;

    /**
     * @var FormatMessage Status message text.
     */
    private $description;

    /**
     * Instantiate a new StatusMessage
     *
     * @param array $data {
     *      StatusMessage data
     *
     *      @type bool $isError Distinguishes errors from informational messages.
     *      @type Reference $refersTo Reference to which the message applies.
     *      @type FormatMessage $description Status message text.
     * }
     */
    public function __construct($data)
    {
        if ($data) {
            $this->isError = $data['isError'];
            $this->refersTo = $data['refersTo'];
            $this->description = $data['description'];
        }
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'isError' => $this->isError,
            'refersTo' => $this->refersTo,
            'description' => $this->description
        ];
    }
}
