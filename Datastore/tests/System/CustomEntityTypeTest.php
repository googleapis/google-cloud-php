<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Datastore\Tests\System;

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Tests\System\Entities\Kingdom;
use Google\Cloud\Datastore\Tests\System\Entities\Person;
use Google\Cloud\Datastore\Tests\System\Entities\Pet;
use Google\Cloud\Datastore\Tests\System\Entities\Species;

/**
 * @group datastore
 * @group datastore-customentitytype
 */
class CustomEntityTypeTest extends DatastoreTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testCustomEntity(DatastoreClient $client)
    {
        $id = uniqid('MyDog');
        $key = $client->key('Pet', $id);

        $owner = $client->entity(null, [
            'name' => 'Kate'
        ], ['className' => Person::class]);

        $kingdom = $client->entity(null, [
            'name' => 'Animalia'
        ], ['className' => Kingdom::class]);

        $species = $client->entity(null, [
            'name' => 'C. lupus',
            'kingdom' => $kingdom
        ], ['className' => Species::class]);

        $myDog = $client->entity($key, [
            'name' => 'Scout',
            'age' => 10,
            'owner' => $owner,
            'species' => $species
        ], ['className' => Pet::class]);

        $client->insert($myDog);
        self::$localDeletionQueue->add($key);

        $lookup = $client->lookup($key, ['className' => Pet::class]);
        $this->assertInstanceOf(Pet::class, $lookup);
        $this->assertInstanceOf(Person::class, $lookup->get()['owner']);
        $this->assertInstanceOf(Species::class, $lookup->get()['species']);
        $this->assertInstanceOf(Kingdom::class, $lookup->get()['species']->get()['kingdom']);
    }
}
