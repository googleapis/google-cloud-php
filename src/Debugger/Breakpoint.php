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
 * This plain PHP class represents a debugger breakpoint resource. For more information see
 * [Breakpoint](https://cloud.google.com/debugger/api/reference/rest/v2/debugger.debuggees.breakpoints#Breakpoint)
 */
class Breakpoint
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var Action
     */
    private $action;

    /**
     * @var SourceLocation
     */
    public $location;

    /**
     * @var string
     */
    public $condition;

    /**
     * @var string[]
     */
    public $expressions;

    /**
     * @var string
     */
    public $logMessageFormat;

    /**
     * @var LogLevel
     */
    public $logLevel;

    /**
     * @var bool
     */
    public $isFinalState;

    /**
     * @var string
     */
    public $createTime;

    /**
     * @var string
     */
    public $finalTime

    /**
     * @var string
     */
    public $userEmail;

    /**
     * @var StatusMessage
     */
    public $status;

    /**
     * @var StackFrame[]
     */
    public $stackFrames;

    /**
     * @var Variable[]
     */
    public $evaluatedExpressions;

    /**
     * @var Variable[]
     */
    public $variableTable;

    /**
     * @var array
     */
    public $labels;
}
