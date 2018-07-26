<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Datastore\Tests\Unit;

use Google\Cloud\Datastore\EntityInterface;
use Google\Cloud\Datastore\EntityTrait;

class SampleEntity implements EntityInterface, \arrayaccess
{
    use EntityTrait;

    public static function mappings()
    {
        return [
            'foo' => SampleEntity::class,
            'nest' => SampleEntity::class
        ];
    }

    public function offsetSet($key, $val)
    {
        $this->entity[$key] = $val;
    }

    public function offsetExists($key)
    {
        return isset($this->entity[$key]);
    }

    public function offsetUnset($key)
    {
        unset($this->entity[$key]);
    }

    public function offsetGet($key)
    {
        return isset($this->entity[$key])
            ? $this->entity[$key]
            : null;
    }
}
