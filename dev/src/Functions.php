<?php

namespace Google\Cloud\Dev;

/**
 * Create a test stub which extends a real class and allows overriding of private properties.
 *
 * @param string $extends The fully-qualified name of the class to extend.
 * @param array $args An array of constructor arguments to use when creating the stub.
 * @param array $props A list of private properties on which to enable overrriding.
 * @return mixed
 */
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
