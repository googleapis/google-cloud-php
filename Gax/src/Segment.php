<?php

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
