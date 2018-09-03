<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Tests\Snippet;

use \Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\ChunkFormatter;
use Google\Cloud\Bigtable\DataClient;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ChunkFormatterTest extends SnippetTestCase
{
    const PROJECT_ID = 'my-project';
    const INSTANCE_ID = 'my-instance';
    const TABLE_ID = 'my-table';
    const TABLE_NAME = 'projects/my-project/instances/my-instance/tables/my-table';

    private $bigtableClient;
    private $dataClient;
    private $serverStream;

    public function setUp()
    {
        $this->bigtableClient = $this->prophesize(TableClient::class);
        $this->serverStream = $this->prophesize(ServerStream::class);
        $this->dataClient = TestHelpers::stub(
            DataClient::class,
            [
                self::INSTANCE_ID,
                self::TABLE_ID,
                [
                    'bigtableClient' => $this->bigtableClient->reveal(),
                    'projectId' => self::PROJECT_ID
                ]
            ]
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(ChunkFormatter::class);
        $snippet->replace('$dataClient = new DataClient(\'my-instance\', \'my-table\');', '');
        $this->bigtableClient->readRows(self::TABLE_NAME, [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet->addLocal('dataClient', $this->dataClient);
        $res = $snippet->invoke('formatter');
        $this->assertInstanceOf(ChunkFormatter::class, $res->returnVal());
    }

    public function testReadAll()
    {
        $snippet = $this->snippetFromMethod(ChunkFormatter::class, 'readAll');
        $formatter = $this->prophesize(ChunkFormatter::class);
        $formatter->readAll()
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator());
        $snippet->addLocal('formatter', $formatter->reveal());
        $res = $snippet->invoke('rows');
        $this->assertInstanceOf(\Generator::class, $res->returnVal());
    }

    private function resultGenerator()
    {
        yield [];
    }
}
