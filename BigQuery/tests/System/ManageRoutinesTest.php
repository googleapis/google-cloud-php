<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\BigQuery\Tests\System;

use Google\Cloud\BigQuery\Routine;

/**
 * @group bigquery
 * @group bigquery-routine
 */
class ManageRoutinesTest extends BigQueryTestCase
{
    private static $routines = [];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        for ($i = 0; $i < 2; $i++) {
            $routineId = uniqid(self::TESTING_PREFIX);
            $sql = 'CREATE FUNCTION %s.%s(x string, y string) as (concat(x, "\n", y))';
            $query = self::$client->query(sprintf(
                $sql,
                self::$dataset->identity()['datasetId'],
                $routineId
            ));

            self::$client->runQuery($query)->waitUntilComplete();
            $routine = self::$dataset->routine($routineId);
            self::$routines[] = $routine;
            self::$deletionQueue->add($routine);
        }
    }

    public function testListRoutinesAndVerifyCreateFunction()
    {
        $routines = iterator_to_array(self::$dataset->routines());
        $this->assertContainsOnlyInstancesOf(Routine::class, $routines);

        $shouldContain = [];
        foreach (self::$routines as $r) {
            $shouldContain[$r->identity()['routineId']] = $r->identity()['routineId'];
        }

        $this->assertNotEmpty($routines);

        foreach ($routines as $routine) {
            if (in_array($routine->identity()['routineId'], $shouldContain)) {
                unset($shouldContain[$routine->identity()['routineId']]);
            } else {
                $this->assertTrue(false, 'Unexpected routine!');
            }

            $this->assertTrue($routine->exists());
        }

        $this->assertEmpty($shouldContain);
    }

    public function testUpdateRoutine()
    {
        $routine = self::$routines[0];

        $patch = [
            'arguments' => [
                ['name' => 'z']
            ],
            'definitionBody' => 'concat(z, "\n", y)'
        ];

        $newInfo = $routine->update($patch);
        $this->assertEquals($patch['arguments'][0]['name'], $newInfo['arguments'][0]['name']);
        $this->assertEquals($patch['definitionBody'], $newInfo['definitionBody']);
    }

    public function testUpdateRoutineUpdateMask()
    {
        $routine = self::$routines[1];

        $patch = [
            'arguments' => [
                ['name' => 'z']
            ],
            'definitionBody' => 'concat(z, "\n", y)',
            'description' => 'This is my routine. there are many like it but this one is mine.'
        ];

        $newInfo = $routine->update($patch, ['updateMask' => ['description']]);
        $this->assertNotEquals($patch['arguments'][0]['name'], $newInfo['arguments'][0]['name']);
        $this->assertNotEquals($patch['definitionBody'], $newInfo['definitionBody']);
        $this->assertEquals($patch['description'], $newInfo['description']);
    }

    public function testCreateAndDeleteRoutine()
    {
        $routine = self::$dataset->createRoutine(uniqid(self::TESTING_PREFIX), [
            'routineType' => 'SCALAR_FUNCTION',
            'definitionBody' => 'concat(x, "\n", y)',
            'arguments' => [
                [
                    'name' => 'x',
                    'dataType' => [
                        'typeKind' => 'STRING'
                    ]
                ], [
                    'name' => 'y',
                    'dataType' => [
                        'typeKind' => 'STRING'
                    ]
                ]
            ]
        ]);

        $routine->delete();

        $this->assertFalse($routine->exists());
    }
}
