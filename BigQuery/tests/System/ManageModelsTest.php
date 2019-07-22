<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\BigQuery\Tests\System;

use Google\Cloud\BigQuery\Model;

/**
 * @group bigquery
 * @group bigquery-model
 */
class ManageModelsTest extends BigQueryTestCase
{
    private static $model;
    private static $modelId;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$modelId = uniqid(self::TESTING_PREFIX);

        $queryTpl = "CREATE MODEL `%s.%s`" .
            " OPTIONS (" .
            "  model_type='linear_reg'," .
            "  max_iterations=1, " .
            "  learn_rate=0.4," .
            "  learn_rate_strategy='constant'" .
            ") AS (" .
              " SELECT 'a' AS f1, 2.0 AS label" .
              " UNION ALL" .
              " SELECT 'b' AS f2, 3.8 AS label " .
            ")";

        $query = sprintf($queryTpl, self::$dataset->id(), self::$modelId);
        $config = self::$client->query($query);
        self::$client->runQuery($config);

        $model = self::$dataset->model(self::$modelId);

        $model->reload();
        if (!$model->exists()) {
            throw new \Exception();
        }

        self::$deletionQueue->add($model);

        self::$model = $model;
    }

    public function testCreatesAndLoadsModelForDataset()
    {
        $model = self::$model;
        $this->assertTrue($model->exists());
        $this->assertEquals('LINEAR_REGRESSION', $model->info()['modelType']);
    }

    public function testUpdatesModel()
    {
        $model = self::$model;
        $model->update([
            'friendlyName' => 'update model test name'
        ]);

        $info = $model->info();
        $this->assertEquals('update model test name', $info['friendlyName']);
    }

    public function testListModels()
    {
        $models = iterator_to_array(self::$dataset->models());
        $this->assertContainsOnlyInstancesOf(Model::class, $models);
        $this->assertNotEmpty(array_filter($models, function ($model) {
            return $model->id() === self::$modelId;
        }));
    }
}
