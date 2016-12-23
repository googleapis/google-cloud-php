<?php

namespace Google\Cloud\Dev;

function stub($extends, array $args = [])
{
    $tpl = 'class %s extends %s {use \Google\Cloud\Dev\SetStubConnectionTrait; }';

    $name = 'Stub'. sha1($extends);

    if (!class_exists($name)) {
        eval(sprintf($tpl, $name, $extends));
    }

    $reflection = new \ReflectionClass($name);
    return $reflection->newInstanceArgs($args);
}
