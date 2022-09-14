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
use Google\Cloud\Bigtable\Table;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ChunkFormatterTest extends SnippetTestCase
{
    const TABLE_NAME = 'projects/my-project/instances/my-instance/tables/my-table';

    private $bigtableClient;
    private $table;
    private $serverStream;

    public function set_up()
    {
        $this->bigtableClient = $this->prophesize(TableClient::class);
        $this->serverStream = $this->prophesize(ServerStream::class);
        $this->table = TestHelpers::stub(
            Table::class,
            [
                $this->bigtableClient->reveal(),
                self::TABLE_NAME
            ]
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(ChunkFormatter::class);
        $snippet->replace(
            '$bigtable = new BigtableClient();',
            '$bigtable = new BigtableClient(["projectId" => "my-project"]);'
        );
        $snippet->replace('$table = $bigtable->table(\'my-instance\', \'my-table\');', '');
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn([]);
        $this->bigtableClient->readRows(self::TABLE_NAME, [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet->addLocal('table', $this->table);
        $res = $snippet->invoke('formatter');
        $this->assertInstanceOf(ChunkFormatter::class, $res->returnVal());
        $res->returnVal()->getIterator()->current();
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
