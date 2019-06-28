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
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class ModelTest extends TestCase
{
    private $connection;
    const PROJECT_ID = 'myProjectId';
    const DATASET_ID = 'myDatasetId';
    const MODEL_ID = 'myModelId';

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getModel($connection, array $info = [])
    {
        return new Model(
            $connection->reveal(),
            self::MODEL_ID,
            self::DATASET_ID,
            self::PROJECT_ID
        );
    }

    public function testDoesExistTrue()
    {
        $this->connection->getModel(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $model = $this->getModel($this->connection);
        $this->assertTrue($model->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getModel(Argument::any())
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);

        $model = $this->getModel($this->connection);
        $this->assertFalse($model->exists());
    }

    public function testGetsId()
    {
        $model = $this->getModel($this->connection);
        $this->assertEquals('myModelId', $model->id());
    }

    public function testIdentity()
    {
        $model = $this->getModel($this->connection);
        $this->assertEquals([
            'modelId' => self::MODEL_ID,
            'datasetId' => self::DATASET_ID,
            'projectId' => self::PROJECT_ID,
        ], $model->identity());
    }

    public function testGetsInfo()
    {
        $info = ['foo' => 'bar'];
        $this->connection->getModel(Argument::any())
            ->willReturn($info)
            ->shouldBeCalledTimes(1);

        $model = $this->getModel($this->connection);

        $this->assertEquals($info, $model->info());
    }

    public function testReload()
    {
        $info = ['foo' => 'bar'];
        $this->connection->getModel(Argument::any())
            ->willReturn($info)
            ->shouldBeCalledTimes(1);

        $model = $this->getModel($this->connection);

        $this->assertEquals($info, $model->reload());
    }

    public function testDelete()
    {
        $this->connection->deleteModel(Argument::any())
            ->shouldBeCalledTimes(1);
        $model = $this->getModel($this->connection);
        $this->assertNull($model->delete());
    }

    public function testUpdatesData()
    {
        $data = ['friendlyName' => 'Updated Name'];

        $this->connection->patchModel(Argument::any())
            ->willReturn($data)
            ->shouldBeCalledTimes(1);
        $dataset = $this->getModel($this->connection, ['friendlyName' => 'Original Name']);
        $dataset->update($data);

        $this->assertEquals('Updated Name', $dataset->info()['friendlyName']);
    }
}
