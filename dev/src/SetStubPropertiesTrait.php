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

namespace Google\Cloud\Dev;

trait SetStubPropertiesTrait
{
    public function __call($method, $args)
    {
        $matches = [];
        if (!preg_match('/set([a-zA-z0-9]{0,})/', $method, $matches)) {
            throw new \BadMethodCallException("Method $method does not exist");
        }

        $prop = lcfirst($matches[1]);

        if (!in_array($prop, json_decode($this->___props))) {
            throw new \BadMethodCallException(sprintf('Property %s cannot be overloaded', $prop));
        }

        $trait = new \ReflectionClass($this);
        $ref = $trait->getParentClass();

        try {
            $property = $ref->getProperty($prop);
        } catch (\ReflectionException $e) {
            throw new \BadMethodCallException($e->getMessage());
        }

        $property->setAccessible(true);
        $property->setValue($this, $args[0]);
    }
}
