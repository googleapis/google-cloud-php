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
 */
class Reference
{
    const UNSPECIFIED = 'UNSPECIFIED';
    const BREAKPOINT_SOURCE_LOCATION = 'BREAKPOINT_SOURCE_LOCATION';
    const BREAKPOINT_CONDITION = 'BREAKPOINT_CONDITION';
    const BREAKPOINT_EXPRESSION = 'BREAKPOINT_EXPRESSION';
    const BREAKPOINT_AGE = 'BREAKPOINT_AGE';
    const VARIABLE_NAME = 'VARIABLE_NAME';
    const VARIABLE_VALUE = 'VARIABLE_VALUE';
}
