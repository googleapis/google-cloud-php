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

use Google\Cloud\Firestore\FieldPath;

/**
 * @group firestore
 * @group firestore-query
 */
class QueryTest extends FirestoreTestCase
{
    private $query;

    public function set_up()
    {
        $this->query = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($this->query);
    }

    public function testSelect()
    {
        $doc = $this->insertDoc([
            'foo' => 'bar',
            'hello' => 'world',
            'good' => 'night'
        ]);

        $expected = ['foo', 'good'];
        $res = $this->getQueryRow($this->query->select($expected));
        $actual = array_keys($res->data());

        $this->assertEmpty(array_merge(
            array_diff($expected, $actual),
            array_diff($actual, $expected)
        ));
    }

    public function testSelectEmpty()
    {
        $doc = $this->insertDoc([
            'foo' => 'bar'
        ]);

        $res = $this->getQueryRow($this->query->select([]));
        $this->assertEmpty($res->data());
    }

    public function testWhere()
    {
        $randomVal = base64_encode(random_bytes(10));
        $doc = $this->insertDoc([
            'foo' => $randomVal
        ]);

        $res = $this->getQueryRow($this->query->where('foo', '=', $randomVal));
        $this->assertEquals($res->name(), $doc->name());
    }

    public function testWhereNull()
    {
        $doc = $this->insertDoc([
            'foo' => null
        ]);

        $res = $this->getQueryRow($this->query->where('foo', '=', null));
        $this->assertEquals($res->name(), $doc->name());
    }

    public function testWhereNan()
    {
        $doc = $this->insertDoc([
            'foo' => NAN
        ]);

        $res = $this->getQueryRow($this->query->where('foo', '=', NAN));
        $this->assertEquals($res->name(), $doc->name());
    }

    public function testWhereInArray()
    {
        $name = $this->query->name();
        $doc1 = $this->insertDoc([
            'foos' => ['foo', 'bar'],
        ]);
        $doc2 = $this->insertDoc([
            'foos' => ['foo'],
        ]);

        $docs = self::$client->collection($name)->where('foos', 'in', [['foo']])->documents()->rows();
        $this->assertCount(1, $docs);
        $this->assertEquals($doc2->name(), $docs[0]->name());

        $docs = self::$client->collection($name)->where('foos', 'in', [['bar']])->documents()->rows();
        $this->assertEmpty($docs);

        $docs = self::$client->collection($name)->where('foos', 'in', [['foo', 'bar']])->documents()->rows();
        $this->assertCount(1, $docs);
        $this->assertEquals($doc1->name(), $docs[0]->name());

        $docs = self::$client->collection($name)->where('foos', 'in', [['bar', 'foo']])->documents()->rows();
        $this->assertEmpty($docs);

        $docs = self::$client->collection($name)
            ->where(FieldPath::documentId(), 'in', [$doc1->id(), $doc2->id()])
            ->documents()
            ->rows();
        $this->assertCount(2, $docs);
        $doc_ids = array_map(function ($doc) {
            return $doc->id();
        }, $docs);
        $this->assertContains($doc1->id(), $doc_ids);
        $this->assertContains($doc2->id(), $doc_ids);
    }

    public function testSnapshotCursors()
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);

        $refs = [];
        for ($i = 0; $i <= 3; $i++) {
            $doc = $collection->document($i);
            $doc->create(['i' => $i]);
            $refs[] = $doc;
        }

        $q = $collection->startAt($refs[0]->snapshot());
        $this->assertCount(count($refs), iterator_to_array($q->documents()));

        $q = $collection->startAfter($refs[0]->snapshot());
        $this->assertCount(count($refs)-1, iterator_to_array($q->documents()));

        $q = $collection->endBefore(end($refs)->snapshot());
        $this->assertCount(count($refs)-1, iterator_to_array($q->documents()));

        $q = $collection->endAt(end($refs)->snapshot());
        $this->assertCount(count($refs), iterator_to_array($q->documents()));
    }

    public function testLimitToLast()
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);
        for ($i = 1; $i <= 5; $i++) {
            $collection->add(['i' => $i]);
        }

        $q = $collection->orderBy('i')
            ->limitToLast(2);

        $docs = iterator_to_array($q->documents());

        $res = [];
        array_walk($docs, function ($doc) use (&$res) {
            $res[] = $doc['i'];
        });

        $this->assertEquals([4, 5], $res);
    }

    public function testLimitToLastWithCursors()
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);
        for ($i = 1; $i <= 5; $i++) {
            $collection->add(['i' => $i]);
        }

        $q = $collection->orderBy('i')
            ->startAt([2])
            ->endAt([4])
            ->limitToLast(5);

        $docs = iterator_to_array($q->documents());

        $res = [];
        array_walk($docs, function ($doc) use (&$res) {
            $res[] = $doc['i'];
        });

        $this->assertEquals([2, 3, 4], $res);
    }

    private function insertDoc(array $fields)
    {
        return $this->query->add($fields);
    }

    private function getQueryRow($query)
    {
        return current(iterator_to_array($query->documents()));
    }
}
