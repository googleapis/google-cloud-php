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

namespace Google\Cloud\Datastore\Tests\System;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Aggregation;

/**
 * @group datastore
 * @group datastore-query
 */
class RunQueryTest extends DatastoreMultipleDbTestCase
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

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$ancestor = self::$restClient->key(self::$kind, 'Grandpa Frank');
        $key1 = self::$restClient->key(self::$kind, 'Frank');
        $key1->ancestorKey(self::$ancestor);
        $key2 = self::$restClient->key(self::$kind, 'Dave');
        $key2->ancestorKey(self::$ancestor);
        $key3 = self::$restClient->key(self::$kind, 'Greg');

        self::$restClient->insertBatch([
            self::$restClient->entity(self::$ancestor, self::$data[0]),
            self::$restClient->entity($key1, self::$data[1]),
            self::$restClient->entity($key2, self::$data[2]),
            self::$restClient->entity($key3, self::$data[3])
        ]);

        // on rare occasions the queries below are returning no results when
        // triggered immediately after an insert operation. the sleep here
        // is intended to help alleviate this issue.
        sleep(1);

        self::$localDeletionQueue->add(self::$ancestor);
        self::$localDeletionQueue->add($key1);
        self::$localDeletionQueue->add($key2);
        self::$localDeletionQueue->add($key3);
    }

    public static function tearDownAfterClass(): void
    {
        self::tearDownFixtures();
    }

    /**
     * @dataProvider multiDbClientProvider
     */
    public function testQueryMultipleDbClients(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->order('knownDances');

        $results = iterator_to_array($client->runQuery($query));

        $this->assertCount(0, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryDefaultDbClients(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->order('knownDances');

        $results = iterator_to_array($client->runQuery($query));

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[1], $results[1]->get());
        $this->assertEquals(self::$data[2], $results[2]->get());
        $this->assertEquals(self::$data[3], $results[3]->get());
        $this->assertCount(4, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithOrder(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->order('knownDances');

        $results = iterator_to_array($client->runQuery($query));

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[1], $results[1]->get());
        $this->assertEquals(self::$data[2], $results[2]->get());
        $this->assertEquals(self::$data[3], $results[3]->get());
        $this->assertCount(4, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithFilter(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->filter('lastName', '=', 'Smith');

        $results = $this->runQueryAndSortResults($client, $query);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[1], $results[1]->get());
        $this->assertEquals(self::$data[3], $results[2]->get());
        $this->assertCount(3, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithAncestor(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->hasAncestor(self::$ancestor);

        $results = $this->runQueryAndSortResults($client, $query);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[1], $results[1]->get());
        $this->assertEquals(self::$data[2], $results[2]->get());
        $this->assertCount(3, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithProjection(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->projection('knownDances');

        $results = $this->runQueryAndSortResults($client, $query);

        $data = self::$data;

        foreach ($data as &$d) {
            unset($d['middleName']);
            unset($d['lastName']);
        }

        $this->assertEquals($data[0], $results[0]->get());
        $this->assertEquals($data[1], $results[1]->get());
        $this->assertEquals($data[2], $results[2]->get());
        $this->assertEquals($data[3], $results[3]->get());
        $this->assertCount(4, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithDistinctOn(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->distinctOn('lastName');

        $results = $this->runQueryAndSortResults($client, $query);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[2], $results[1]->get());
        $this->assertCount(2, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithKeysOnly(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->keysOnly();

        $results = $this->runQueryAndSortResults($client, $query);

        $this->assertCount(4, $results);
        foreach ($results as $result) {
            $this->assertEmpty($result->get());
        }
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithOffset(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->offset(3);

        $results = $this->runQueryAndSortResults($client, $query);

        $this->assertEquals(self::$data[3], $results[0]->get());
        $this->assertCount(1, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithStartCursor(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->limit(1);

        $results = iterator_to_array($client->runQuery($query));

        $cursorQuery = $client->query()
            ->kind(self::$kind)
            ->start($results[0]->cursor());

        $results = $this->runQueryAndSortResults($client, $cursorQuery);

        $this->assertEquals(self::$data[1], $results[0]->get());
        $this->assertEquals(self::$data[2], $results[1]->get());
        $this->assertEquals(self::$data[3], $results[2]->get());
        $this->assertCount(3, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithEndCursor(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->limit(1);

        $results = iterator_to_array($client->runQuery($query));

        $cursorQuery = $client->query()
            ->kind(self::$kind)
            ->end($results[0]->cursor());

        $results = $this->runQueryAndSortResults($client, $cursorQuery);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertCount(1, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithLimit(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->limit(1);

        $results = $this->runQueryAndSortResults($client, $query);

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertCount(1, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryWithEmptyResult(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->filter('lastName', '=', 'does_not_exist');

        $results = $this->runQueryAndSortResults($client, $query);
        $resultsWithLimit = $this->runQueryAndSortResults($client, $query->limit(1));

        $this->assertCount(0, $results);
        $this->assertCount(0, $resultsWithLimit);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testGqlQueryWithBindings(DatastoreClient $client)
    {
        $query = $client->gqlQuery('SELECT * From Person WHERE lastName = @lastName', [
            'bindings' => [
                'lastName' => 'McAllen'
            ]
        ]);

        $results = $this->runQueryAndSortResults($client, $query);

        $this->assertEquals(self::$data[2], $results[0]->get());
        $this->assertCount(1, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testGqlQueryWithLiteral(DatastoreClient $client)
    {
        $query = $client->gqlQuery("SELECT * From Person WHERE lastName = 'McAllen'", [
            'allowLiterals' => true
        ]);

        $results = $this->runQueryAndSortResults($client, $query);

        $this->assertEquals(self::$data[2], $results[0]->get());
        $this->assertCount(1, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testRunQueryWithReadTime(DatastoreClient $client)
    {
        $this->skipEmulatorTests();
        $kind = 'NewPerson';
        $lastName = 'Geller';
        $newLastName = 'Bing';
        $key = $client->key($kind, time());
        $person = $client->entity($key, [
            'lastName' => $lastName
        ]);
        $client->insert($person);
        self::$localDeletionQueue->add($key);

        sleep(2);

        $time = new Timestamp(new \DateTime());

        sleep(2);

        $person = $client->lookup($key);
        $person['lastName'] = $newLastName;
        $client->update($person);

        sleep(2);

        $query = $client->query()
            ->kind($kind)
            ->filter('__key__', '=', $key);
        $result = $client->runQuery($query);
        $personListEntities = iterator_to_array($result);

        // Person lastName should be the lastName AFTER update
        $this->assertEquals($personListEntities[0]['lastName'], $newLastName);

        // Person lastName should be the lastName BEFORE update
        $result = $client->runQuery($query, ['readTime' => $time]);
        $personListEntities = iterator_to_array($result);
        $this->assertEquals($personListEntities[0]['lastName'], $lastName);
    }

    private function runQueryAndSortResults($client, $query)
    {
        $results = iterator_to_array($client->runQuery($query));
        usort($results, function ($a, $b) {
            return $a['knownDances'] - $b['knownDances'];
        });

        return $results;
    }
}
