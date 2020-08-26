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
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Core\Testing\System\KeyManager;

/**
 * @group bigquery
 * @group bigquery-model
 */
class ManageModelsTest extends BigQueryTestCase
{
    const KEY_RING_ID = 'bq-kms-kr';
    const CRYPTO_KEY_ID1 = 'bq-model-key1';
    const CRYPTO_KEY_ID2 = 'bq-model-key2';

    private static $model;
    private static $modelId;

    private static $keyName1;
    private static $keyName2;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$modelId = uniqid(self::TESTING_PREFIX);

        $encryption = new KeyManager(
            json_decode(file_get_contents(getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')), true)
        );

        $project = $encryption->getProject();
        $encryption->setServiceAccountEmail(sprintf(
            self::ENCRYPTION_SERVICE_ACCOUNT_EMAIL_TEMPLATE,
            $project['projectNumber']
        ));

        list(self::$keyName1, self::$keyName2) = $encryption->getKeyNames(
            self::KEY_RING_ID,
            [self::CRYPTO_KEY_ID1, self::CRYPTO_KEY_ID2]
        );

        $queryTpl = "CREATE MODEL `%s.%s`" .
            " OPTIONS (" .
            "  model_type='linear_reg'," .
            "  max_iterations=1, " .
            "  learn_rate=0.4," .
            "  learn_rate_strategy='constant'," .
            "  kms_key_name='%s'" .
            ") AS (" .
              " SELECT 'a' AS f1, 2.0 AS label" .
              " UNION ALL" .
              " SELECT 'b' AS f2, 3.8 AS label " .
            ")";

        $query = sprintf(
            $queryTpl,
            self::$dataset->id(),
            self::$modelId,
            self::$keyName1
        );
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

    public function testSetsModelCmekKeyName()
    {
        $this->assertKeyName(self::$keyName1, self::$model->info());

        $info = self::$model->update([
            'friendlyName' => 'whatever',
            'encryptionConfiguration' => [
                'kmsKeyName' => self::$keyName2
            ]
        ]);

        $this->assertKeyName(self::$keyName2, $info);
    }

    public function testExtractsModel()
    {
        $object = self::$bucket->object(
            uniqid(self::TESTING_PREFIX)
        );
        self::$deletionQueue->add($object);

        $extractJobConfig = self::$model->extract($object);
        $job = self::$client->startJob($extractJobConfig);

        $backoff = new ExponentialBackoff(8);
        $backoff->execute(function () use ($job) {
            $job->reload();

            if (!$job->isComplete()) {
                throw new \Exception();
            }
        });

        if (!$job->isComplete()) {
            $this->fail('Job failed to complete within the allotted time.');
        }

        $this->assertArrayNotHasKey('errorResult', $job->info()['status']);
    }

    private function assertKeyName($expected, array $info)
    {
        $this->assertEquals(
            $expected,
            $info['encryptionConfiguration']['kmsKeyName']
        );
    }
}
