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

namespace Google\Cloud\Tests\System\BigQuery;

/**
 * @group bigquery
 */
class ManageDatasetsTest extends BigQueryTestCase
{
    public function testListDatasets()
    {
        $foundDatasets = [];
        $datasetsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($datasetsToCreate as $datasetToCreate) {
            self::$deletionQueue[] = self::$client->createDataset($datasetToCreate);
        }

        $datasets = self::$client->datasets();

        foreach ($datasets as $dataset) {
            foreach ($datasetsToCreate as $key => $datasetToCreate) {
                if ($dataset->id() === $datasetToCreate) {
                    $foundDatasets[$key] = $dataset->id();
                }
            }
        }

        $this->assertEquals($datasetsToCreate, $foundDatasets);
    }

    public function testCreatesDataset()
    {
        $id = uniqid(self::TESTING_PREFIX);
        $options = [
            'friendlyName' => 'Test',
            'description' => 'Test'
        ];
        $this->assertFalse(self::$client->dataset($id)->exists());

        $dataset = self::$client->createDataset($id, $options);
        self::$deletionQueue[] = $dataset;

        $this->assertTrue(self::$client->dataset($id)->exists());
        $this->assertEquals($id, $dataset->id());
        $this->assertEquals($options['friendlyName'], $dataset->info()['friendlyName']);
        $this->assertEquals($options['description'], $dataset->info()['description']);
    }

    public function testUpdateDataset()
    {
        $metadata = [
            'friendlyName' => 'Test'
        ];
        $info = self::$dataset->update($metadata);

        $this->assertEquals($metadata['friendlyName'], $info['friendlyName']);
    }

    public function testReloadsDataset()
    {
        $this->assertEquals('bigquery#dataset', self::$dataset->reload()['kind']);
    }
}
