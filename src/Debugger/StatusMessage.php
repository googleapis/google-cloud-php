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
class StatusMessage
{
    /**
     * @var bool
     */
    public $isError;

    /**
     * @var Reference
     */
    public $refersTo;

    /**
     * @var FormatMessage
     */
    public $description;

    public function __construct($data)
    {
        if ($data) {
            $this->isError = $data['isError'];
            $this->refersTo = $data['refersTo'];
            $this->description = $data['description'];
        }
    }
}
