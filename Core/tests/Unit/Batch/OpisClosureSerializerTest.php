<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\Batch;

use Google\Cloud\Core\Batch\OpisClosureSerializer;
use Google\Cloud\Core\Batch\OpisClosureSerializerV4;
use Opis\Closure\SerializableClosure;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group batch
 * @runTestsInSeparateProcesses
 */
class OpisClosureSerializerTest extends TestCase
{
    public function testWrapAndUnwrapClosures()
    {
        if (!@method_exists(SerializableClosure::class, 'enterContext')) {
            $this->markTestSkipped('Requires ops/serializer:v3');
        }

        $data['closure'] = function () {
            return true;
        };

        $serializer = new OpisClosureSerializer();

        $serializer->wrapClosures($data);
        $this->assertInstanceOf(SerializableClosure::class, $data['closure']);

        $serializer->unwrapClosures($data);
        $this->assertTrue($data['closure']());
    }

    public function testWrapAndUnwrapClosuresV4()
    {
        if (@method_exists(SerializableClosure::class, 'enterContext')) {
            $this->markTestSkipped('Requires ops/serializer:v4');
        }

        $data['closure'] = function () {
            return true;
        };

        $serializer = new OpisClosureSerializerV4();
        $serializer->wrapClosures($data);
        $this->assertIsString($data);

        $serializer->unwrapClosures($data);
        $this->assertTrue($data['closure']());
    }
}
