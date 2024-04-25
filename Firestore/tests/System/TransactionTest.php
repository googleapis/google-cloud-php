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

    /**
     * @dataProvider getAggregateCases
     */
    public function testAggregateQuery($type, $arg, $expected, $docsToAdd)
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);
        foreach ($docsToAdd as $docToAdd) {
            $collection->add($docToAdd);
        }

        $query = $collection->where('value', '!=', 'non_existent_value')
        ->addAggregation(
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('res')
        );

        // without sleep, test fails intermittently
        sleep(1);
        $readTime = new Timestamp(new \DateTimeImmutable('now'));

        self::$client->runTransaction(function ($t) use ($query, $readTime, $expected) {
            $snapshot = $t->runAggregateQuery($query, [
                'readTime' => $readTime
            ]);

            $this->assertEquals($expected, $snapshot->get('res'));

            $this->assertEqualsWithDelta(
                $readTime->get()->getTimestamp(),
                $snapshot->getReadTime()->get()->getTimestamp(),
                100
            );
        });
    }

    /**
     * @dataProvider getAggregateCases
     */
    public function testAggregateQueryWithMultipleAggregation($type, $arg, $expected, $docsToAdd)
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);
        foreach ($docsToAdd as $docToAdd) {
            $collection->add($docToAdd);
        }

        $query = $collection->where('value', '!=', 'non_existent_value')
        ->addAggregation(
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('res_1')
        );
        $query = $query->addAggregation(
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('res_2')
        );
        $query = $query->addAggregation(
            ($arg ? Aggregate::$type($arg) : Aggregate::$type())->alias('res_3')
        );

        // without sleep, test fails intermittently
        sleep(1);
        $readTime = new Timestamp(new \DateTimeImmutable('now'));

        self::$client->runTransaction(function ($t) use ($query, $readTime, $expected) {
            $snapshot = $t->runAggregateQuery($query, [
                'readTime' => $readTime
            ]);

            $this->assertEquals($expected, $snapshot->get('res_1'));
            $this->assertEquals($expected, $snapshot->get('res_2'));
            $this->assertEquals($expected, $snapshot->get('res_3'));

            $this->assertEqualsWithDelta(
                $readTime->get()->getTimestamp(),
                $snapshot->getReadTime()->get()->getTimestamp(),
                100
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

    /**
     * This dataProvider returns the test cases to test how
     * aggregations work in a transaction.
     *
     * The values are of the form
     * [
     *     string $aggregationType,
     *     string $targetFieldName,
     *     array $expectedResults,
     *     array $docsToAddBeforeTestRunning
     * ]
     */
    public function getAggregateCases()
    {
        $docsToAdd = [
            ['value' => 'foobar'],
            ['value' => 'bar'],
            ['value' => 'foo']
        ];
        $numsToAdd = [
            ['value' => 1],
            ['value' => 2],
            ['value' => 3]
        ];
        return [
            ['count', null, 3, $docsToAdd],
            ['sum', 'value', 6, $numsToAdd],
            ['avg', 'value', 2, $numsToAdd]
        ];
    }
}
