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

namespace Google\Cloud\Tests\System\Firestore;

/**
 * @group firestore
 * @group firestore-transaction
 */
class TransactionTest extends FirestoreTestCase
{
    private $document;

    public function setUp()
    {
        $doc = self::$collection->newDocument();
        self::$deletionQueue->add($doc);
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
        ], $this->document->snapshot()->fields());
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
        ], $this->document->snapshot()->fields());
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
        ], $this->document->snapshot()->fields());
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
