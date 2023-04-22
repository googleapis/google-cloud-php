<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Filter;

/**
 * @group datastore
 * @group datastore-query
 */
class FilterTest extends DatastoreMultipleDbTestCase
{
    private static $kind = 'People';
    public static function setUpBeforeClass(): void
    {
        parent::setUpMultiDbBeforeClass();
        $data = self::getInitialData();
        $entities = [];
        foreach ($data as $element) {
            $key = self::$restClient->key(self::$kind, $element['Name']);
            $entities[] = self::$restClient->entity($key, $element);
        }
        self::$restClient->insertBatch($entities);

        // on rare occasions the queries below are returning no results when
        // triggered immediately after an insert operation. the sleep here
        // is intended to help alleviate this issue.
        sleep(1);

        foreach ($entities as $entity) {
            self::$localDeletionQueue->add($entity->key());
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::tearDownFixtures();
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testOrRunQuery(DatastoreClient $client)
    {
        $this->skipEmulatorTests();
        $filter = Filter::or([
            Filter::where('Name', '=', 'Hersch'),
            Filter::where('Name', '=', 'Davy')
        ]);
        $query = $client->query()
            ->kind(self::$kind)
            ->filter($filter);

        $results = $this->runQueryAndSortResults($client, $query);
        $this->assertEquals(count($results), 2);
        $this->assertEquals($results[0]['Name'], 'Hersch');
        $this->assertEquals($results[1]['Name'], 'Davy');
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testMixOfOrAndRunQuery(DatastoreClient $client)
    {
        $this->skipEmulatorTests();
        $filter = Filter::and([
            Filter::where('Age', '<', 26),
            Filter::or([
                Filter::and([
                    Filter::where('Age', '>', 23),
                    Filter::where('Age', '<', 30)
                ]),
                Filter::and([
                    Filter::where('Age', '>', 25),
                    Filter::where('Age', '<', 31)
                ]),
            ])
        ]);
        $query = $client->query()
            ->kind(self::$kind)
            ->filter($filter);

        $results = $this->runQueryAndSortResults($client, $query);
        $this->assertEquals(count($results), 1);
        $this->assertEquals($results[0]['Name'], 'Eldredge');
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testOrQueryViaTransaction(DatastoreClient $client)
    {
        $this->skipEmulatorTests();
        $filter = Filter::or([
            Filter::where('Name', '=', 'Hersch'),
            Filter::where('Name', '=', 'Davy')
        ]);
        $query = $client->query()
            ->kind(self::$kind)
            ->filter($filter);

        $transaction = $client->transaction();
        $results = $this->runQueryAndSortResults($transaction, $query);
        $this->assertEquals(count($results), 2);
        $this->assertEquals($results[0]['Name'], 'Hersch');
        $this->assertEquals($results[1]['Name'], 'Davy');
        $transaction->commit();
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testMixOfOrAndViaTransaction(DatastoreClient $client)
    {
        $this->skipEmulatorTests();
        $filter = Filter::and([
            Filter::where('Age', '<', 26),
            Filter::or([
                Filter::and([
                    Filter::where('Age', '>', 23),
                    Filter::where('Age', '<', 30)
                ]),
                Filter::and([
                    Filter::where('Age', '>', 25),
                    Filter::where('Age', '<', 31)
                ]),
            ])
        ]);
        $query = $client->query()
            ->kind(self::$kind)
            ->filter($filter);

        $transaction = $client->transaction();
        $results = $this->runQueryAndSortResults($transaction, $query);
        $this->assertEquals(count($results), 1);
        $this->assertEquals($results[0]['Name'], 'Eldredge');
        $transaction->commit();
    }

    private static function getInitialData()
    {
        return [[
            "Name" => "Hersch",
            "Age" => 21,
            "FavouriteColor" => "Purple",
            "Gender" => "Male"
        ], [
            "Name" => "Davy",
            "Age" => 23,
            "FavouriteColor" => "Turquoise",
            "Gender" => "Male"
        ], [
            "Name" => "Eldredge",
            "Age" => 25,
            "FavouriteColor" => "Violet",
            "Gender" => "Male"
        ], [
            "Name" => "Rickey",
            "Age" => 26,
            "FavouriteColor" => "Crimson",
            "Gender" => "Bigender"
        ], [
            "Name" => "Arron",
            "Age" => 30,
            "FavouriteColor" => "Red",
            "Gender" => "Male"
        ], [
            "Name" => "Hi",
            "Age" => 31,
            "FavouriteColor" => "Teal",
            "Gender" => "Male"
        ], [
            "Name" => "Chandler",
            "Age" => 33,
            "FavouriteColor" => "Turquoise",
            "Gender" => "Male"
        ], [
            "Name" => "Juliette",
            "Age" => 36,
            "FavouriteColor" => "Purple",
            "Gender" => "Female"
        ], [
            "Name" => "Mufi",
            "Age" => 36,
            "FavouriteColor" => "Fuscia",
            "Gender" => "Female"
        ], [
            "Name" => "Karrah",
            "Age" => 39,
            "FavouriteColor" => "Violet",
            "Gender" => "Female"
        ]];
    }

    private function runQueryAndSortResults($client, $query)
    {
        $results = iterator_to_array($client->runQuery($query));
        usort($results, function ($a, $b) {
            return $a['Name'] < $b['Name'];
        });

        return $results;
    }
}
