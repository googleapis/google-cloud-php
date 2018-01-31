<?php

/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Core\Testing;

/**
 * Class TestHelpers is used to hold static functions required for testing
 *
 * @experimental
 * @internal
 */
class TestHelpers
{
    /**
     * Create a test stub which extends a real class and allows overriding of private properties.
     *
     * @param string $extends The fully-qualified name of the class to extend.
     * @param array $args An array of constructor arguments to use when creating the stub.
     * @param array $props A list of private properties on which to enable overrriding.
     * @return mixed
     *
     * @experimental
     * @internal
     */
    public static function stub($extends, array $args = [], array $props = [])
    {
        if (empty($props)) {
            $props = ['connection'];
        }

        $tpl = 'class %s extends %s {private $___props = \'%s\'; use \Google\Cloud\Core\Testing\StubTrait; }';

        $props = json_encode($props);

        $name = 'Stub' . sha1($extends . $props);

        if (!class_exists($name)) {
            eval(sprintf($tpl, $name, $extends, $props));
        }

        $reflection = new \ReflectionClass($name);
        return $reflection->newInstanceArgs($args);
    }

    /**
     * Get a trait implementation.
     *
     * @param string $trait The fully-qualified name of the trait to implement.
     * @return mixed
     *
     * @experimental
     * @internal
     */
    public static function impl($trait, array $props = [])
    {
        $properties = [];
        foreach ($props as $prop) {
            $properties[] = 'private $' . $prop . ';';
        }

        $tpl = 'class %s {
            use %s;
            use \Google\Cloud\Core\Testing\StubTrait;
            private $___props = \'%s\';
            %s
            public function call($fn, array $args = []) { return call_user_func_array([$this, $fn], $args); }
        }';

        $name = 'Trait' . sha1($trait . json_encode($props));

        if (!class_exists($name)) {
            eval(sprintf($tpl, $name, $trait, json_encode($props), implode("\n", $properties)));
        }

        return new $name;
    }
}
