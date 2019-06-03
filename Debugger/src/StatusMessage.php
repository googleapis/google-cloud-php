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

use Google\Cloud\Debugger\V2\StatusMessage\Reference;

/**
 * Represents a contextual status message. The message can indicate an error or
 * informational status, and refer to specific parts of the containing object.
 * For example, the Breakpoint.status field can indicate an error referring to
 * the BREAKPOINT_SOURCE_LOCATION with the message Location not found.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\FormatMessage;
 * use Google\Cloud\Debugger\StatusMessage;
 *
 * $format = new FormatMessage('message with placeholders', ['additional parameter']);
 * $message = new StatusMessage(true, StatusMessage::REFERENCE_UNSPECIFIED, $format);
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees.breakpoints#statusmessage StatusMessage model documentation
 * @codingStandardsIgnoreEnd
 */
class StatusMessage
{
    const REFERENCE_UNSPECIFIED = Reference::UNSPECIFIED;
    const REFERENCE_BREAKPOINT_SOURCE_LOCATION = Reference::BREAKPOINT_SOURCE_LOCATION;
    const REFERENCE_BREAKPOINT_CONDITION = Reference::BREAKPOINT_CONDITION;
    const REFERENCE_BREAKPOINT_EXPRESSION = Reference::BREAKPOINT_EXPRESSION;
    const REFERENCE_BREAKPOINT_AGE = Reference::BREAKPOINT_AGE;
    const REFERENCE_VARIABLE_NAME = Reference::VARIABLE_NAME;
    const REFERENCE_VARIABLE_VALUE = Reference::VARIABLE_VALUE;

    /**
     * @var bool Distinguishes errors from informational messages.
     */
    private $isError;

    /**
     * @var string Reference to which the message applies.
     */
    private $refersTo;

    /**
     * @var FormatMessage Status message text.
     */
    private $description;

    /**
     * Instantiate a new StatusMessage
     *
     * @access private
     * @param bool $isError Distinguishes errors from informational messages.
     * @param string $refersTo Reference to which the message applies.
     * @param FormatMessage $description Status message text.
     */
    public function __construct($isError, $refersTo, FormatMessage $description)
    {
        $this->isError = $isError;
        $this->refersTo = $refersTo;
        $this->description = $description;
    }

    /**
     * Load a StatusMessage from JSON form
     *
     * Example:
     * ```
     * $message = StatusMessage::fromJson([
     *     'isError' => true,
     *     'refersTo' => StatusMessage::REFERENCE_UNSPECIFIED,
     *     'description' => [
     *         'format' => 'message with placeholders',
     *         'parameters' => []
     *     ]
     * ]);
     * ```
     *
     * @access private
     * @param array $data {
     *      StatusMessage data
     *
     *      @type bool $isError Distinguishes errors from informational messages.
     *      @type Reference $refersTo Reference to which the message applies.
     *      @type FormatMessage $description Status message text.
     * }
     * @return StatusMessage|null
     */
    public static function fromJson(array $data)
    {
        if (!$data) {
            return null;
        }

        $data += [
            'isError' => false,
            'refersTo' => null,
            'description' => null
        ];
        return new static($data['isError'], $data['refersTo'], FormatMessage::fromJson($data['description']));
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
            'isError' => $this->isError,
            'refersTo' => $this->refersTo,
            'description' => $this->description->info()
        ];
    }
}
