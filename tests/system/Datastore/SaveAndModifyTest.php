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

use Google\Cloud\Core\Int64;

/**
 * @group datastore
 */
class SaveAndModifyTest extends DatastoreTestCase
{
    public function testEntityLifeCycle()
    {
        $key = self::$client->key('Person', 'Alton');
        $data = [
            'description' => 'A great chef.',
            'birthDate' => new \DateTimeImmutable(),
            'birthPlace' => self::$client->geoPoint(37.4220, -122.0841),
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
            'blob' => self::$client->blob('blob!')
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
        $entity = self::$client->entity($key, $data);

        self::$client->insert($entity);
        self::$deletionQueue[] = $key;
        $entity = self::$client->lookup($key);

        $blobValue = (string) $data['blob'];
        $actualData = $entity->get();
        $actualBlobValue = (string) $actualData['blob'];
        unset($data['blob']);
        unset($actualData['blob']);

        $this->assertEquals($data, $actualData);
        $this->assertEquals($blobValue, $actualBlobValue);

        $entity = self::$client->entity($key, $upsertData);
        self::$client->upsert($entity);
        $entity = self::$client->lookup($key);

        $this->assertEquals($upsertData, $entity->get());

        $entity = self::$client->entity($key, $updateData);
        self::$client->update($entity, [
            'allowOverwrite' => true
        ]);
        $entity = self::$client->lookup($key);

        $this->assertEquals($updateData, $entity->get());
    }

    public function testInsertWithKindAndArrayAccess()
    {
        $entityDataKey = 'test';
        $entityDataValue = 'hello';
        $entity = self::$client->entity('Person');
        $entity[$entityDataKey] = $entityDataValue;

        self::$client->insert($entity);
        $key = $entity->key();
        self::$deletionQueue[] = $key;
        $entity = self::$client->lookup($key);

        $this->assertEquals([$entityDataKey => $entityDataValue], $entity->get());
    }

    public function testInsertInt64AsObject()
    {
        $entityDataKey = 'int64';
        $intValue = '9223372036854775807';
        $int64Object = new Int64($intValue);
        $entity = self::$returnInt64AsObjectClient->entity('Int64');
        $entity[$entityDataKey] = $int64Object;

        self::$returnInt64AsObjectClient->insert($entity);
        $key = $entity->key();
        self::$deletionQueue[] = $key;
        $entity = self::$returnInt64AsObjectClient->lookup($key);

        $this->assertInstanceOf(Int64::class, $entity[$entityDataKey]);
        $this->assertEquals($intValue, (string) $entity[$entityDataKey]);
    }
}
