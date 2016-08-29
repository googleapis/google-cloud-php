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

namespace Google\Cloud\Tests\Datastore;

use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\Transaction;
use Prophecy\Argument;

/**
 * @group datastore
 */
class TransactionTest extends \PHPUnit_Framework_TestCase
{
    private $connection;
    private $transaction;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->transaction = new Transaction($this->connection->reveal(), 'foo', 'bar');
    }

    public function testId()
    {
        $this->assertEquals('bar', $this->transaction->id());
    }

    public function testRollback()
    {
        $this->connection->rollback(Argument::type('array'))->shouldBeCalledTimes(1);
        $t = new Transaction($this->connection->reveal(), 'foo', 'bar');

        $t->rollback();
    }
}
