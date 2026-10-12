<?php
/**
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the 'License');
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\BigQuery\Tests\Unit;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\ExtractJobConfiguration;
use Google\Cloud\BigQuery\Model;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Storage\Connection\ConnectionInterface as StorageConnectionInterface;
use Google\Cloud\Storage\StorageObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class ModelTest extends TestCase
{
    use ProphecyTrait;

    private $connection;
    private $storageConnection;
    private $model;

    const JOB_ID = 'myJobId';
    const PROJECT_ID = 'myProjectId';
    const DATASET_ID = 'myDatasetId';
    const MODEL_ID = 'myModelId';
    const BUCKET_NAME = 'myBucket';
    const FILE_NAME = 'myfile';

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->storageConnection = $this->prophesize(StorageConnectionInterface::class);
        $this->model = TestHelpers::stub(Model::class, [
            $this->connection->reveal(),
            self::MODEL_ID,
            self::DATASET_ID,
            self::PROJECT_ID
        ], ['connection', 'info']);
    }

    public function testDoesExistTrue()
    {
        $this->connection->getModel(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('modelId', self::MODEL_ID)
        ))
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertTrue($this->model->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getModel(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('modelId', self::MODEL_ID)
        ))
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertFalse($this->model->exists());
    }

    public function testGetsId()
    {
        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals('myModelId', $this->model->id());
    }

    public function testIdentity()
    {
        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals([
            'modelId' => self::MODEL_ID,
            'datasetId' => self::DATASET_ID,
            'projectId' => self::PROJECT_ID,
        ], $this->model->identity());
    }

    public function testGetsInfo()
    {
        $info = ['foo' => 'bar'];
        $this->connection->getModel(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('modelId', self::MODEL_ID)
        ))
            ->willReturn($info)
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals($info, $this->model->info());
    }

    public function testReload()
    {
        $info = ['foo' => 'bar'];
        $this->connection->getModel(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('modelId', self::MODEL_ID)
        ))
            ->willReturn($info)
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals($info, $this->model->reload());
    }

    public function testDelete()
    {
        $this->connection->deleteModel(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('modelId', self::MODEL_ID),
            Argument::withEntry('retries', 0)
        ))
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertNull($this->model->delete());
    }

    public function testUpdatesData()
    {
        $data = ['friendlyName' => 'Updated Name'];

        $this->connection->patchModel(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('modelId', self::MODEL_ID),
            Argument::withEntry('friendlyName', 'Updated Name')
        ))
            ->willReturn($data)
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->model->___setProperty('info', ['friendlyName' => 'Original Name']);

        $this->model->update($data);
        $this->assertEquals('Updated Name', $this->model->info()['friendlyName']);
    }

    public function testUpdatesDataWithEtag()
    {
        $updateData = ['friendlyName' => 'wow a name', 'etag' => 'foo'];
        $this->connection->patchModel(Argument::that(function ($args) {
            return $args['restOptions']['headers']['If-Match'] === 'foo';
        }))->willReturn($updateData)->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->model->___setProperty('info', ['friendlyName' => 'another name']);

        $this->model->update($updateData);

        $this->assertEquals($updateData['friendlyName'], $this->model->info()['friendlyName']);
    }

    /**
     * @dataProvider destinationProvider
     */
    public function testGetsExtractJobConfiguration($destinationObject)
    {
        $this->connection->getModel(Argument::any())
            ->willReturn([
                'location' => 'foo'
            ]);

        $this->model->___setProperty('connection', $this->connection->reveal());

        $expected = [
            'projectId' => self::PROJECT_ID,
            'configuration' => [
                'extract' => [
                    'destinationUris' => [
                        'gs://' . self::BUCKET_NAME . '/' . self::FILE_NAME
                    ],
                    'sourceModel' => [
                        'datasetId' => self::DATASET_ID,
                        'modelId' => self::MODEL_ID,
                        'projectId' => self::PROJECT_ID
                    ]
                ]
            ],
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ];
        $config = $this->model->extract($destinationObject, [
            'jobReference' => ['jobId' => self::JOB_ID]
        ]);

        $this->assertInstanceOf(ExtractJobConfiguration::class, $config);
        $this->assertEquals($expected, $config->toArray());
    }

    public function destinationProvider()
    {
        $this->setUp();

        return [
            [$this->getObject()],
            [sprintf(
                'gs://%s/%s',
                self::BUCKET_NAME,
                self::FILE_NAME
            )]
        ];
    }

    private function getObject()
    {
        return new StorageObject(
            $this->storageConnection->reveal(),
            self::FILE_NAME,
            self::BUCKET_NAME
        );
    }
}
