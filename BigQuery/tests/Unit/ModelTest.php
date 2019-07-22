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
use Google\Cloud\BigQuery\Model;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class ModelTest extends TestCase
{
    private $connection;
    private $model;

    const PROJECT_ID = 'myProjectId';
    const DATASET_ID = 'myDatasetId';
    const MODEL_ID = 'myModelId';

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->model = TestHelpers::stub(Model::class, [
            $this->connection->reveal(),
            self::MODEL_ID,
            self::DATASET_ID,
            self::PROJECT_ID
        ], ['connection', 'info']);
    }

    public function testDoesExistTrue()
    {
        $this->connection->getModel(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertTrue($this->model->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getModel(Argument::any())
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
        $this->connection->getModel(Argument::any())
            ->willReturn($info)
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals($info, $this->model->info());
    }

    public function testReload()
    {
        $info = ['foo' => 'bar'];
        $this->connection->getModel(Argument::any())
            ->willReturn($info)
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals($info, $this->model->reload());
    }

    public function testDelete()
    {
        $this->connection->deleteModel(Argument::any())
            ->shouldBeCalledTimes(1);

        $this->model->___setProperty('connection', $this->connection->reveal());
        $this->assertNull($this->model->delete());
    }

    public function testUpdatesData()
    {
        $data = ['friendlyName' => 'Updated Name'];

        $this->connection->patchModel(Argument::any())
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
}
