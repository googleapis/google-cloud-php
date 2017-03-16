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

namespace Google\Cloud\Tests\System\Datastore;

/**
 * @group datastore
 */
class RunQueryTest extends DatastoreTestCase
{
    private static $ancestor;
    private static $kind = 'Person';
    private static $data = [
        [
            'knownDances' => 1,
            'middleName' => 'Wesley',
            'lastName' => 'Smith'
        ],
        [
            'knownDances' => 2,
            'middleName' => 'Alexander',
            'lastName' => 'Smith'
        ],
        [
            'knownDances' => 5,
            'middleName' => 'Alexander',
            'lastName' => 'McAllen'
        ],
        [
            'knownDances' => 10,
            'middleName' => 'Aye',
            'lastName' => 'Smith'
        ]
    ];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$ancestor = self::$client->key(self::$kind, 'Grandpa Frank');
        $key1 = self::$client->key(self::$kind, 'Frank');
        $key1->ancestorKey(self::$ancestor);
        $key2 = self::$client->key(self::$kind, 'Dave');
        $key2->ancestorKey(self::$ancestor);
        $key3 = self::$client->key(self::$kind, 'Greg');

        self::$client->insertBatch([
            self::$client->entity(self::$ancestor, self::$data[0]),
            self::$client->entity($key1, self::$data[1]),
            self::$client->entity($key2, self::$data[2]),
            self::$client->entity($key3, self::$data[3])
        ]);

        // on rare occasions the queries below are returning no results when
        // triggered immediately after an insert operation. the sleep here
        // is intended to help alleviate this issue.
        sleep(1);

        self::$deletionQueue[] = self::$ancestor;
        self::$deletionQueue[] = $key1;
        self::$deletionQueue[] = $key2;
        self::$deletionQueue[] = $key3;
    }

    public function testQueryWithOrder()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->order('knownDances');

        $results = iterator_to_array(self::$client->runQuery($query));

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[1], $results[1]->get());
        $this->assertEquals(self::$data[2], $results[2]->get());
        $this->assertEquals(self::$data[3], $results[3]->get());
        $this->assertEquals(4, count($results));
    }

    public function testQueryWithFilter()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->filter('lastName', '=', 'Smith');

        $results = $this->runQueryAndSortResults($query);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[1], $results[1]->get());
        $this->assertEquals(self::$data[3], $results[2]->get());
        $this->assertEquals(3, count($results));
    }

    public function testQueryWithAncestor()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->hasAncestor(self::$ancestor);

        $results = $this->runQueryAndSortResults($query);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[1], $results[1]->get());
        $this->assertEquals(self::$data[2], $results[2]->get());
        $this->assertEquals(3, count($results));
    }

    public function testQueryWithProjection()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->projection('knownDances');

        $results = $this->runQueryAndSortResults($query);

        $data = self::$data;

        foreach ($data as &$d) {
            unset($d['middleName']);
            unset($d['lastName']);
        }

        $this->assertEquals($data[0], $results[0]->get());
        $this->assertEquals($data[1], $results[1]->get());
        $this->assertEquals($data[2], $results[2]->get());
        $this->assertEquals($data[3], $results[3]->get());
        $this->assertEquals(4, count($results));
    }

    public function testQueryWithDistinctOn()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->distinctOn('lastName');

        $results = $this->runQueryAndSortResults($query);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[2], $results[1]->get());
        $this->assertEquals(2, count($results));
    }

    public function testQueryWithKeysOnly()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->keysOnly();

        $results = $this->runQueryAndSortResults($query);

        $this->assertEquals(4, count($results));
        foreach ($results as $result) {
            $this->assertEmpty($result->get());
        }
    }

    public function testQueryWithOffset()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->offset(3);

        $results = $this->runQueryAndSortResults($query);

        $this->assertEquals(self::$data[3], $results[0]->get());
        $this->assertEquals(1, count($results));
    }

    public function testQueryWithStartCursor()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->limit(1);

        $results = iterator_to_array(self::$client->runQuery($query));

        $cursorQuery = self::$client->query()
            ->kind(self::$kind)
            ->start($results[0]->cursor());

        $results = $this->runQueryAndSortResults($cursorQuery);

        $this->assertEquals(self::$data[1], $results[0]->get());
        $this->assertEquals(self::$data[2], $results[1]->get());
        $this->assertEquals(self::$data[3], $results[2]->get());
        $this->assertEquals(3, count($results));
    }

    public function testQueryWithEndCursor()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->limit(1);

        $results = iterator_to_array(self::$client->runQuery($query));

        $cursorQuery = self::$client->query()
            ->kind(self::$kind)
            ->end($results[0]->cursor());

        $results = $this->runQueryAndSortResults($cursorQuery);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(1, count($results));
    }

    public function testQueryWithLimit()
    {
        $query = self::$client->query()
            ->kind(self::$kind)
            ->limit(1);

        $results = $this->runQueryAndSortResults($query);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(1, count($results));
    }

    public function testGqlQueryWithBindings()
    {
        $query = self::$client->gqlQuery('SELECT * From Person WHERE lastName = @lastName', [
            'bindings' => [
                'lastName' => 'McAllen'
            ]
        ]);

        $results = $this->runQueryAndSortResults($query);

        $this->assertEquals(self::$data[2], $results[0]->get());
        $this->assertEquals(1, count($results));
    }

    public function testGqlQueryWithLiteral()
    {
        $query = self::$client->gqlQuery("SELECT * From Person WHERE lastName = 'McAllen'", [
            'allowLiterals' => true
        ]);

        $results = $this->runQueryAndSortResults($query);

        $this->assertEquals(self::$data[2], $results[0]->get());
        $this->assertEquals(1, count($results));
    }

    private function runQueryAndSortResults($query)
    {
        $results = iterator_to_array(self::$client->runQuery($query));
        usort($results, function($a, $b) {
            return $a['knownDances'] - $b['knownDances'];
        });

        return $results;
    }
}
