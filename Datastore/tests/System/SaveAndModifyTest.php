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

use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Int64;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;

/**
 * @group datastore
 * @group datastore-save
 */
class SaveAndModifyTest extends DatastoreTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testEntityLifeCycle(DatastoreClient $client)
    {
        $key = $client->key('Person', rand(0, 99999));
        $data = [
            'description' => 'A great chef.',
            'birthDate' => new \DateTimeImmutable(),
            'birthPlace' => $client->geoPoint(37.4220, -122.0841),
            'favoriteFloat' => (float) 5.25,
            'favoriteInt' => (int) 5,
            'favoriteDishes' => [
                'Hamburgers',
                'Hot Dogs'
            ],
            'isNamedAlton' => true,
            'labels' => [
                'location' => 'at home'
            ],
            'nothingSpecial' => null,
            'blob' => $client->blob('blob!')
        ];
        $upsertData = [
            'labels' => [
                'location' => 'someplace else'
            ]
        ];
        $updateData = [
            'labels' => [
                'location' => 'yet another location'
            ]
        ];
        $entity = $client->entity($key, $data);

        $client->insert($entity);
        self::$localDeletionQueue->add($key);
        $entity = $client->lookup($key);

        $blobValue = (string) $data['blob'];
        $actualData = $entity->get();
        $actualBlobValue = (string) $actualData['blob'];
        unset($data['blob']);
        unset($actualData['blob']);

        $this->assertEquals($data, $actualData);
        $this->assertEquals($blobValue, $actualBlobValue);

        $entity = $client->entity($key, $upsertData);
        $client->upsert($entity);
        $entity = $client->lookup($key);

        $this->assertEquals($upsertData, $entity->get());

        $entity = $client->entity($key, $updateData);
        $client->update($entity, [
            'allowOverwrite' => true
        ]);
        $entity = $client->lookup($key);

        $this->assertEquals($updateData, $entity->get());
    }

    /**
     * @dataProvider clientProvider
     */
    public function testInsertWithKindAndArrayAccess(DatastoreClient $client)
    {
        $entityDataKey = 'test';
        $entityDataValue = 'hello';
        $entity = $client->entity('Person');
        $entity[$entityDataKey] = $entityDataValue;

        $client->insert($entity);
        $key = $entity->key();
        self::$localDeletionQueue->add($key);
        $entity = $client->lookup($key);

        $this->assertEquals([$entityDataKey => $entityDataValue], $entity->get());
    }

    /**
     * @dataProvider clientProvider
     */
    public function testInsertInt64AsObject(DatastoreClient $client)
    {
        $entityDataKey = 'int64';
        $intValue = '9223372036854775807';
        $int64Object = new Int64($intValue);
        $entity = self::$returnInt64AsObjectClient->entity('Int64');
        $entity[$entityDataKey] = $int64Object;

        self::$returnInt64AsObjectClient->insert($entity);
        $key = $entity->key();
        self::$localDeletionQueue->add($key);
        $entity = self::$returnInt64AsObjectClient->lookup($key);

        $this->assertInstanceOf(Int64::class, $entity[$entityDataKey]);
        $this->assertEquals($intValue, (string) $entity[$entityDataKey]);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testExcludeEmbeddedEntityPropertyFromIndexes(DatastoreClient $client)
    {
        $entity = $client->entity('Person', [
            'foo' => [
                'hello' => 'world',
                Entity::EXCLUDE_FROM_INDEXES => ['hello']
            ]
        ]);
        $client->insert($entity);

        $key = $entity->key();
        self::$localDeletionQueue->add($key);
        $e = $client->lookup($key);
        $this->assertEquals(['hello'], $e['foo'][Entity::EXCLUDE_FROM_INDEXES]);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testEmptyArraySemantics(DatastoreClient $client)
    {
        $entity = $client->entity('Person', [
            'listVal' => [],
            'entityVal' => (object) [],
            'n' => [
                'foo',
                []
            ]
        ]);
        $client->insert($entity);

        $key = $entity->key();
        self::$localDeletionQueue->add($key);

        $e = $client->lookup($key);
        $this->assertEquals([], $e['listVal']);
        $this->assertEquals([], $e['entityVal']);
        $this->assertEquals([], $e['n'][1]);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testEmptyGeoPoint(DatastoreClient $client)
    {
        $entity = $client->entity('GeoPoint', [
            'geo' => new GeoPoint(null, null, true)
        ]);
        $client->insert($entity);

        $key = $entity->key();
        self::$localDeletionQueue->add($key);

        $e = $client->lookup($key);
        $this->assertInstanceOf(GeoPoint::class, $e['geo']);
        $this->assertTrue(
            $e['geo']->latitude() === null || $e['geo']->latitude() === 0.0
        );
        $this->assertTrue(
            $e['geo']->longitude() === null || $e['geo']->longitude() === 0.0
        );

        $client->upsert($e);

        $e = $client->lookup($key);
        $this->assertInstanceOf(GeoPoint::class, $e['geo']);
        $this->assertTrue(
            $e['geo']->latitude() === null || $e['geo']->latitude() === 0.0
        );
        $this->assertTrue(
            $e['geo']->longitude() === null || $e['geo']->longitude() === 0.0
        );
    }
}
