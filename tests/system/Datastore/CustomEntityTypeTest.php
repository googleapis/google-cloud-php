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

namespace Google\Cloud\Tests\System\Datastore;

use Google\Cloud\Tests\System\Datastore\Entities\Kingdom;
use Google\Cloud\Tests\System\Datastore\Entities\Person;
use Google\Cloud\Tests\System\Datastore\Entities\Pet;
use Google\Cloud\Tests\System\Datastore\Entities\Species;

/**
 * @group datastore
 * @group datastore-customentitytype
 */
class CustomEntityTypeTest extends DatastoreTestCase
{
    public function testCustomEntity()
    {
        $datastore = self::$client;
        $id = uniqid('MyDog');
        $key = $datastore->key('Pet', $id);

        $myDog = $datastore->entity($key, [
            'name' => 'Scout',
            'age' => 10,
            'owner' => $datastore->entity(null, [
                'name' => 'Kate'
            ], ['className' => Person::class]),
            'species' => $datastore->entity(null, [
                'name' => 'C. lupus',
                'kingdom' => $datastore->entity(null, [
                    'name' => 'Animalia'
                ], ['className' => Kingdom::class])
            ], ['className' => Species::class])
        ], ['className' => Pet::class]);

        $datastore->insert($myDog);
        self::$localDeletionQueue->add($key);

        $lookup = $datastore->lookup($key, ['className' => Pet::class]);
        $this->assertInstanceOf(Pet::class, $lookup);
        $this->assertInstanceOf(Person::class, $lookup->get()['owner']);
        $this->assertInstanceOf(Species::class, $lookup->get()['species']);
        $this->assertInstanceOf(Kingdom::class, $lookup->get()['species']->get()['kingdom']);
    }
}
