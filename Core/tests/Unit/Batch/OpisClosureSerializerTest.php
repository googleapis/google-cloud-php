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
use Opis\Closure\SerializableClosure;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 * @group batch
 */
class OpisClosureSerializerTest extends TestCase
{
    private $serialzer;

    public function set_up()
    {
        $this->serializer = new OpisClosureSerializer();
    }

    public function testWrapAndUnwrapClosures()
    {
        $data['closure'] = function () {
            return true;
        };

        $this->serializer
            ->wrapClosures($data);

        $this->assertInstanceOf(SerializableClosure::class, $data['closure']);
        $this->serializer
            ->unwrapClosures($data);
        $this->assertTrue($data['closure']());
    }
}
