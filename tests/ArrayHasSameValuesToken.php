<?php

namespace Google\Cloud\Tests;

use Prophecy\Argument\Token\TokenInterface;
use Prophecy\Util\StringUtil;

class ArrayHasSameValuesToken implements TokenInterface
{
    private $value;
    private $string;
    private $util;

    public function __construct($value, StringUtil $util = null)
    {
        $this->value = $value;
        $this->util = $util ?: new StringUtil();
    }

    public function scoreArgument($argument)
    {
        return $this->compare($this->value, $argument) ? 11 : false;
    }

    private function compare(array $value, array $argument)
    {
        array_multisort($value);
        array_multisort($argument);

        return $value == $argument;
    }

    public function isLast()
    {
        return false;
    }

    public function __toString()
    {
        if ($this->string) {
            $string = $this->string .': (%s)';
        } else {
            $string = 'same(%s)';
        }

        return sprintf($string, $this->util->stringify($this->value));
    }
}
