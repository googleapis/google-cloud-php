<?php
/*
 * Copyright 2016, Google Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Jison;

use ArrayObject;

// define constants so they can be access from JisonParser.php
define('GAX_PATH_TEMPLATE_BINDING', 1);
define('GAX_PATH_TEMPLATE_END_BINDING', 2);
define('GAX_PATH_TEMPLATE_TERMINAL', 3);

/**
 * This class represents a segment in a path template.
 * We extend ArrayObject to allow property access from
 * JisonParser
 */
class Segment extends ArrayObject
{
    const BINDING = GAX_PATH_TEMPLATE_BINDING;
    const END_BINDING = GAX_PATH_TEMPLATE_END_BINDING;
    const TERMINAL = GAX_PATH_TEMPLATE_TERMINAL;

    public $kind;
    public $literal;

    public function __construct($kind, $literal)
    {
        $this->kind = $kind;
        $this->literal = $literal;
        $this['kind'] = $kind;
        $this['literal'] = $literal;
    }
}
