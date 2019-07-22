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
use Google\Cloud\BigQuery\Model;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
* @group bigquery
*/
class ModelTest extends SnippetTestCase
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
            self::PROJECT_ID,
            $info
        );
    }

    public function testExists()
    {
        $this->connection->getModel(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $model = $this->getModel($this->connection);
        $snippet = $this->snippetFromMethod(Model::class, 'exists');
        $snippet->addLocal('model', $model);
        $res = $snippet->invoke('model');

        $this->assertEquals(true, $res->output());
    }

    public function testDelete()
    {
        $this->connection->deleteModel(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);

        $model = $this->getModel($this->connection);
        $snippet = $this->snippetFromMethod(Model::class, 'delete');
        $snippet->addLocal('model', $model);

        $snippet->invoke();
    }

    public function testInfo()
    {
        $this->connection->getModel(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'modelType' => 'LOGISTIC_REGRESSION'
            ]);

        $model = $this->getModel($this->connection);
        $snippet = $this->snippetFromMethod(Model::class, 'info');
        $snippet->addLocal('model', $model);
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

        $model = $this->getModel($this->connection);
        $snippet = $this->snippetFromMethod(Model::class, 'reload');
        $snippet->addLocal('model', $model);
        $res = $snippet->invoke('model');

        $this->assertEquals('LOGISTIC_REGRESSION', $res->output());
    }

    public function testId()
    {
        $model = $this->getModel($this->connection);
        $snippet = $this->snippetFromMethod(Model::class, 'id');
        $snippet->addLocal('model', $model);
        $res = $snippet->invoke('model');

        $this->assertEquals(self::MODEL_ID, $res->output());
    }

    public function testIdentity()
    {
        $model = $this->getModel($this->connection);
        $snippet = $this->snippetFromMethod(Model::class, 'identity');
        $snippet->addLocal('model', $model);
        $res = $snippet->invoke('model');

        $this->assertEquals(self::MODEL_ID, $res->output());
    }

    public function testUpdate()
    {
        $this->connection->patchModel(Argument::withEntry('friendlyName', 'My ML model'))
             ->shouldBeCalledTimes(1)
             ->willReturn([]);

        $model = $this->getModel($this->connection);
        $snippet = $this->snippetFromMethod(Model::class, 'update');
        $snippet->addLocal('model', $model);
        $snippet->invoke();
    }
}
