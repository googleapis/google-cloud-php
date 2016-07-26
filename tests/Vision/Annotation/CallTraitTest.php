<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Tests\Vision\Annotation;

use Google\Cloud\Vision\Annotation\AbstractFeature;
use Google\Cloud\Vision\Annotation\CallTrait;

/**
 * @group vision
 */
class CallTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCall()
    {
        $t = new CallTraitStub(['foo' => 'bar']);

        $this->assertEquals('bar', $t->foo());
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testErr()
    {
        $t = new CallTraitStub(['foo' => 'bar']);

        $t->bar();
    }
}

class CallTraitStub extends AbstractFeature
{
    use CallTrait;

    public function __construct(array $data)
    {
        $this->info = $data;
    }
}
