<?php

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
