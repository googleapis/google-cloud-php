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

namespace Google\Cloud\Tests\System\Logging;

/**
 * @group logging
 */
class ManageMetricsTest extends LoggingTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testListsMetrics($client)
    {
        $found = true;
        $name = uniqid(self::TESTING_PREFIX);
        $metric = $client->createMetric($name, 'severity >= DEBUG', [
            'description' => 'A description.'
        ]);
        self::$deletionQueue[] = $metric;

        $metrics = iterator_to_array($client->metrics());

        foreach ($metrics as $metric) {
            if ($metric->name() === $name) {
                $found = true;
            }
        }

        $this->assertTrue($found);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testCreateMetric($client)
    {
        $name = uniqid(self::TESTING_PREFIX);
        $filter = 'severity >= DEBUG';
        $options = [
            'description' => 'A description.',
        ];
        $this->assertFalse($client->metric($name)->exists());

        $metric = $client->createMetric($name, $filter, $options);
        self::$deletionQueue[] = $metric;

        $this->assertTrue($client->metric($name)->exists());
        $this->assertEquals($filter, $metric->info()['filter']);
        $this->assertEquals($options['description'], $metric->info()['description']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testUpdateMetric($client)
    {
        $name = uniqid(self::TESTING_PREFIX);
        $updateOptions = [
            'description' => 'A new description',
            'filter' => 'severity >= INFO'
        ];
        $metric = $client->createMetric($name, 'severity >= DEBUG', [
            'description' => 'A description.',
        ]);
        self::$deletionQueue[] = $metric;

        $info = $metric->update($updateOptions);

        $this->assertEquals($name, $metric->name());
        $this->assertEquals($updateOptions['filter'], $info['filter']);
        $this->assertEquals($updateOptions['description'], $info['description']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testReloadMetric($client)
    {
        $name = uniqid(self::TESTING_PREFIX);
        $filter = 'severity >= ERROR';
        $metric = $client->createMetric($name, $filter, [
            'description' => 'A description.'
        ]);

        $this->assertEquals($filter, $metric->reload()['filter']);
    }
}
