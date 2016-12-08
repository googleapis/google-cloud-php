<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Dev\Snippet\Parser;

class InvokeResult
{
    private $return;
    private $output;

    public function __construct($return, $output)
    {
        $this->return = $return;
        $this->output = $output;
    }

    public function return()
    {
        return $this->return;
    }

    public function output()
    {
        return $this->output;
    }
}
