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

namespace Google\Cloud\Firestore\Tests\System;

use Google\Cloud\Firestore\Aggregate;
use Google\Cloud\Core\Timestamp;

/**
 * @group firestore
 * @group firestore-transaction
 */
class TransactionTest extends FirestoreTestCase
{
    private $document;

    public function setUp(): void
    {
        $doc = self::$collection->newDocument();
        $this->document = $doc;
    }

    public function testInsert()
    {
        $this->assertFalse($this->document->snapshot()->exists());

        self::$client->runTransaction(function ($t) {
            $t->create($this->document, [
                'foo' => 'bar'
            ]);
        });

        $this->assertTrue($this->document->snapshot()->exists());
    }

    public function testUpdate()
    {
        $this->document->create([
            'foo' => 'bar'
        ]);

        self::$client->runTransaction(function ($t) {
            $t->update($this->document, [
                ['path' => 'bat', 'value' => 'baz']
            ]);
        });

        $this->assertEquals([
            'foo' => 'bar',
            'bat' => 'baz'
        ], $this->document->snapshot()->data());
    }

    public function testSet()
    {
        $this->document->create([
            'foo' => 'bar'
        ]);

        self::$client->runTransaction(function ($t) {
            $t->set($this->document, [
                'bat' => 'baz'
            ]);
        });

        $this->assertEquals([
            'bat' => 'baz'
        ], $this->document->snapshot()->data());
    }

    public function testSetMerge()
    {
        $this->document->create([
            'foo' => 'bar'
        ]);

        self::$client->runTransaction(function ($t) {
            $t->set($this->document, [
                'bat' => 'baz'
            ], ['merge' => true]);
        });

        $this->assertEquals([
            'foo' => 'bar',
            'bat' => 'baz'
        ], $this->document->snapshot()->data());
    }

    public function testDelete()
    {
        $this->document->create([
            'foo' => 'bar'
        ]);

        self::$client->runTransaction(function ($t) {
            $t->delete($this->document);
        });

        $this->assertFalse($this->document->snapshot()->exists());
    }

    public function testSnapshot()
    {
        $this->document->create([
            'foo' => 'bar'
        ]);

        self::$client->runTransaction(function ($t) {
            $s = $t->snapshot($this->document);
            $this->assertTrue($s->exists());
            $this->assertEquals('bar', $s['foo']);
        });
    }

    public function testAggregateQuery()
    {
        $this->document->create([
            'foos' => ['foobar'],
        ]);
        self::$collection->add([
            'foos' => ['foo', 'bar'],
        ]);
        self::$collection->add([
            'foos' => ['foo'],
        ]);

        $aggregateQuery = self::$collection->where('foos', '!=', [])->addAggregation(
            Aggregate::count()->alias('count')
        );

        // without sleep, test fails intermittently
        sleep(1);
        $readTime = new Timestamp(new \DateTimeImmutable('now'));

        self::$client->runTransaction(function ($t) use ($aggregateQuery, $readTime) {
            $snapshot = $t->runAggregateQuery($aggregateQuery, [
                'readTime' => $readTime
            ]);

            $this->assertEquals(3, $snapshot->get('count'));

            $this->assertEqualsWithDelta(
                $readTime->get()->getTimestamp(),
                $snapshot->getReadTime()->get()->getTimestamp(),
                10
            );
        });
    }

    public function testAggregateQueryWithMultipleAggregation()
    {
        $this->document->create([
            'bars' => ['foobar'],
        ]);
        self::$collection->add([
            'bars' => ['foo', 'bar'],
        ]);
        self::$collection->add([
            'bars' => ['foo'],
        ]);

        $aggregateQuery = self::$collection->where('bars', '!=', [])->addAggregation(
            Aggregate::count()->alias('count')
        );
        $aggregateQuery = $aggregateQuery->addAggregation(
            Aggregate::count()->alias('count_with_alias_a')
        );
        $aggregateQuery = $aggregateQuery->addAggregation(
            Aggregate::count()->alias('count_with_alias_b')
        );

        // without sleep, test fails intermittently
        sleep(1);
        $readTime = new Timestamp(new \DateTimeImmutable('now'));

        self::$client->runTransaction(function ($t) use ($aggregateQuery, $readTime) {
            $snapshot = $t->runAggregateQuery($aggregateQuery, [
                'readTime' => $readTime
            ]);

            $this->assertEquals(3, $snapshot->get('count'));
            $this->assertEquals(3, $snapshot->get('count_with_alias_a'));
            $this->assertEquals(3, $snapshot->get('count_with_alias_b'));

            $this->assertEqualsWithDelta(
                $readTime->get()->getTimestamp(),
                $snapshot->getReadTime()->get()->getTimestamp(),
                10
            );
        });
    }

    public function testAbort()
    {
        $this->markTestSkipped();

        $this->document->create([
            'foo' => 'bar'
        ]);

        $didRetry = false;
        $iteration = 0;
        self::$client->runTransaction(function ($t) use (&$didRetry, &$iteration) {
            if ($iteration > 0) {
                $didRetry = true;
            }

            $s = $t->snapshot($this->document);

            if ($iteration === 0) {
                $this->document->update([
                    'foo' => 'baz'
                ]);
            }

            $iteration++;

            $t->update($this->document, [
                'foo' => 'bat'
            ]);
        });

        $this->assertTrue($didRetry);
        $this->assertEquals('bat', $this->document->snapshot()['foo']);
    }
}
