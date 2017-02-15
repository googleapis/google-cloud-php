<?php

namespace Google\Cloud\Dev;

function stub($extends, array $args = [], array $props = [])
{
    if (empty($props)) {
        $props = ['connection'];
    }

    $tpl = 'class %s extends %s {private $___props = \'%s\'; use \Google\Cloud\Dev\StubTrait; }';

    $name = 'Stub'. sha1($extends);

    if (!class_exists($name)) {
        eval(sprintf($tpl, $name, $extends, json_encode($props)));
    }

    $reflection = new \ReflectionClass($name);
    return $reflection->newInstanceArgs($args);
}
