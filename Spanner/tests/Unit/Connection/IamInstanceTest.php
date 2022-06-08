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

namespace Google\Cloud\Spanner\Tests\Unit\Connection;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Connection\IamInstance;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group spanner-admin
 * @group spanner
 */
class IamInstanceTest extends TestCase
{
    use StubCreationTrait;

    private $connection;

    private $iam;

    public function set_up()
    {
        $this->connection = $this->getConnStub();

        $this->iam = TestHelpers::stub(IamInstance::class, [$this->connection->reveal()]);
    }

    /**
     * @dataProvider methodProvider
     */
    public function testMethods($methodName, $proxyName, $args)
    {
        $this->connection->$proxyName($args)
            ->shouldBeCalled()
            ->willReturn($args);

        $this->iam->___setProperty('connection', $this->connection->reveal());

        $res = $this->iam->$methodName($args);
        $this->assertEquals($args, $res);
    }

    public function methodProvider()
    {
        $args = ['foo' => 'bar'];

        return [
            ['getPolicy', 'getInstanceIamPolicy', $args],
            ['setPolicy', 'setInstanceIamPolicy', $args],
            ['testPermissions', 'testInstanceIamPermissions', $args]
        ];
    }
}
