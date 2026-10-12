<?php
/**
 * Copyright 2022 Google Inc. All Rights Reserved.
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

/**
 * @group datastore
 * @group datastore-save
 */
class LookupTest extends DatastoreMultipleDbTestCase
{
    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testLookupWithReadTime(DatastoreClient $client)
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

        // Person lastName should be the lastName AFTER update
        $person = $client->lookup($key);
        $this->assertEquals($person['lastName'], $newLastName);

        // Person lastName should be the lastName BEFORE update
        $person = $client->lookup($key, ['readTime' => $time]);
        $this->assertEquals($person['lastName'], $lastName);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testLookupBatchWithReadTime(DatastoreClient $client)
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

        // Person lastName should be the lastName AFTER update
        $person = $client->lookupBatch([$key]);
        $this->assertEquals($person['found'][0]['lastName'], $newLastName);

        // Person lastName should be the lastName BEFORE update
        $person = $client->lookupBatch([$key], ['readTime' => $time]);
        $this->assertEquals($person['found'][0]['lastName'], $lastName);
    }

    /**
     * Tests whether double values `INF`, `-INF` and `NAN` are getting parsed
     * properly in rest and grpc clients.
     *
     * @dataProvider clientProvider
     */
    public function testLookupDoubleCases(DatastoreClient $client)
    {
        $kind = uniqid('double');
        $values = [
            ['value' => INF],
            ['value' => -INF],
            ['value' => NAN],
            ['value' => 1.1]
        ];
        $entities = [];
        $keys = $client->keys($kind, ['number' => count($values)]);
        foreach ($keys as $index => $key) {
            $entities[] = $client->entity($key, $values[$index]);
        }

        $client->insertBatch($entities);
        foreach ($entities as $index => $entity) {
            $key = $entity->key();
            self::$localDeletionQueue->add($key);
            $result = $client->lookup($key);
            $this->compareResult($values[$index]['value'], $result['value']);
        }
    }

    private function compareResult($expected, $actual)
    {
        if (is_float($expected)) {
            if (is_nan($expected)) {
                $this->assertNan($actual);
            } else {
                $this->assertEqualsWithDelta($expected, $actual, 0.01);
            }
        } else {
            // Used because assertEquals(null, '') doesn't fails
            $this->assertSame($expected, $actual);
        }
    }
}
