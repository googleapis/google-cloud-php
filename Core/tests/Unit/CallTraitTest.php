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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\CallTrait;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException;

/**
 * @group core
 */
class CallTraitTest extends TestCase
{
    use ExpectException;
    use ExpectPHPException;

    public function testCall()
    {
        $t = new CallTraitStub(['foo' => 'bar']);

        $this->assertEquals('bar', $t->foo());
    }

    public function testErr()
    {
        $this->expectError();

        $t = new CallTraitStub(['foo' => 'bar']);

        $t->bar();
    }
}

//@codingStandardsIgnoreStart
class CallTraitStub
{
    use CallTrait;

    public function __construct(array $data)
    {
        $this->info = $data;
    }

    public function info()
    {
        return $this->info;
    }
}
//@codingStandardsIgnoreEnd
