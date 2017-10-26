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

namespace Google\Cloud\Tests\Unit\Datastore;

use Prophecy\Argument;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Datastore\Query\QueryInterface;

/**
 * @group datastore
 * @group datastore-readonlytransaction
 */
class ReadOnlyTransactionTest extends \PHPUnit_Framework_TestCase
{
    private $operation;
    private $transaction;

    private $transactionId = 'transaction';

    public function setUp()
    {
        $this->operation = $this->prophesize(Operation::class);
        $this->transaction = \Google\Cloud\Dev\stub(Transaction::class, [
            $this->operation->reveal(),
            'foo',
            $this->transactionId
        ], ['operation']);
    }

    public function testLookup()
    {
        $this->operation->lookup(Argument::type('array'), Argument::that(function ($arg) {
            if ($arg['transaction'] !== $this->transactionId) return false;

            return true;
        }))->willReturn(['found' => ['foo']]);

        $this->transaction->___setProperty('operation', $this->operation->reveal());

        $k = $this->prophesize(Key::class);

        $res = $this->transaction->lookup($k->reveal());

        $this->assertEquals($res, 'foo');
    }

    public function testLookupBatch()
    {
        $this->operation->lookup(Argument::type('array'), Argument::that(function ($arg) {
            if ($arg['transaction'] !== $this->transactionId) return false;

            return true;
        }))->willReturn([]);

        $this->transaction->___setProperty('operation', $this->operation->reveal());

        $k = $this->prophesize(Key::class);

        $this->transaction->lookupBatch([$k->reveal()]);
    }

    public function testRunQuery()
    {
        $this->operation->runQuery(Argument::type(QueryInterface::class), Argument::that(function ($arg) {
            if ($arg['transaction'] !== $this->transactionId) return false;

            return true;
        }))->willReturn('test');

        $this->transaction->___setProperty('operation', $this->operation->reveal());

        $q = $this->prophesize(QueryInterface::class);

        $res = $this->transaction->runQuery($q->reveal());

        $this->assertEquals($res, 'test');
    }
}
