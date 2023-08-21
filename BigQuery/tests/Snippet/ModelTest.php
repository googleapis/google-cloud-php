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

namespace Google\Cloud\BigQuery\Tests\Snippet;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\ExtractJobConfiguration;
use Google\Cloud\BigQuery\JobConfigurationInterface;
use Google\Cloud\BigQuery\Model;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Storage\Connection\Rest as StorageConnection;
use Google\Cloud\Storage\StorageClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
* @group bigquery
*/
class ModelTest extends SnippetTestCase
{
    use ProphecyTrait;

    private $connection;
    private $model;

    const PROJECT_ID = 'myProjectId';
    const DATASET_ID = 'myDatasetId';
    const MODEL_ID = 'myModelId';
    const JOB_ID = 'myJob';

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->model = TestHelpers::stub(Model::class, [
            $this->connection->reveal(),
            self::MODEL_ID,
            self::DATASET_ID,
            self::PROJECT_ID,
        ], ['connection', 'info']);
    }

    public function testExists()
    {
        $this->connection->getModel(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $this->model->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Model::class, 'exists');
        $snippet->addLocal('model', $this->model);
        $res = $snippet->invoke('model');

        $this->assertEquals(true, $res->output());
    }

    public function testDelete()
    {
        $this->connection->deleteModel(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $this->model->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Model::class, 'delete');
        $snippet->addLocal('model', $this->model);

        $snippet->invoke();
    }

    public function testInfo()
    {
        $this->connection->getModel(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'modelType' => 'LOGISTIC_REGRESSION'
            ]);
        $this->model->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Model::class, 'info');
        $snippet->addLocal('model', $this->model);
        $res = $snippet->invoke('model');

        $this->assertEquals('LOGISTIC_REGRESSION', $res->output());
    }

    public function testReload()
    {
        $this->connection->getModel(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'modelType' => 'LOGISTIC_REGRESSION'
            ]);
        $this->model->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Model::class, 'reload');
        $snippet->addLocal('model', $this->model);
        $res = $snippet->invoke('model');

        $this->assertEquals('LOGISTIC_REGRESSION', $res->output());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(Model::class, 'id');
        $snippet->addLocal('model', $this->model);
        $res = $snippet->invoke('model');

        $this->assertEquals(self::MODEL_ID, $res->output());
    }

    public function testIdentity()
    {
        $snippet = $this->snippetFromMethod(Model::class, 'identity');
        $snippet->addLocal('model', $this->model);
        $res = $snippet->invoke('model');

        $this->assertEquals(self::MODEL_ID, $res->output());
    }

    public function testUpdate()
    {
        $this->connection->patchModel(Argument::withEntry('friendlyName', 'My ML model'))
             ->shouldBeCalledTimes(1)
             ->willReturn([]);
        $this->model->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Model::class, 'update');
        $snippet->addLocal('model', $this->model);
        $snippet->invoke();
    }

    public function testExtract()
    {
        $storage = TestHelpers::stub(StorageClient::class);
        $storageConnection = $this->prophesize(StorageConnection::class);
        $storageConnection->projectId()->willReturn(self::PROJECT_ID);
        $storage->___setProperty('connection', $storageConnection->reveal());

        $snippet = $this->snippetFromMethod(Model::class, 'extract');
        $snippet->addLocal('storage', $storage);
        $snippet->addLocal('model', $this->model);
        $config = $snippet->invoke('extractJobConfig')
            ->returnVal();

        $this->assertInstanceOf(ExtractJobConfiguration::class, $config);
        $this->assertEquals(
            [
                'destinationUris' => ['gs://myBucket/modelOutput'],
                'sourceModel' => [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => self::DATASET_ID,
                    'modelId' => self::MODEL_ID
                ]
            ],
            $config->toArray()['configuration']['extract']
        );
    }
}
