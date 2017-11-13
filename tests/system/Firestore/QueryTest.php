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
 * @group firestore-query
 */
class QueryTest extends FirestoreTestCase
{
    const QUERY_COLLECTION = 'system-test-query';

    private $query;

    public function setUp()
    {
        $this->query = self::$client->collection(self::QUERY_COLLECTION);
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
        $actual = array_keys($res->fields());

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
        $this->assertEmpty($res->fields());
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

    private function insertDoc(array $fields)
    {
        $doc = $this->query->add($fields);
        self::$deletionQueue->add($doc);

        return $doc;
    }

    private function getQueryRow($query)
    {
        return current(iterator_to_array($query->documents()));
    }
}
