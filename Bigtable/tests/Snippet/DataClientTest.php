<?php
/*
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
use Google\Cloud\Bigtable\DataClient;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation_SetCell;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Rpc\Code;
use Google\Rpc\Status;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtabledata
 */
class DataClientTest extends SnippetTestCase
{

    const PROJECT_ID = 'my-project';
    const INSTANCE_ID = 'my-instance';
    const TABLE_ID = 'my-table';
    const TABLE_NAME = 'projects/my-project/instances/my-instance/tables/my-table';

    private $bigtableClient;

    private $dataClient;

    private $mutateRowsResponses = [];

    private $serverStream;

    private $entries = [];

    public function setUp()
    {
        $this->bigtableClient = $this->prophesize(BigtableClient::class);
        $this->serverStream = $this->prophesize(ServerStream::class);

        $mutateRowsRequestEntry = new MutateRowsRequest_Entry;
        $mutation = new Mutation;
        $mutationSetCell = new Mutation_SetCell;
        $mutationSetCell->setFamilyName('cf1')->setColumnQualifier('cq1')
            ->setValue('value1');
        $mutation->setSetCell($mutationSetCell);
        $mutateRowsRequestEntry->setRowKey('r1');
        $mutateRowsRequestEntry->setMutations([$mutation]);
        $this->entries[] = $mutateRowsRequestEntry;
        $mutateRowsResponse = new MutateRowsResponse;
        $mutateRowsResponseEntry = new MutateRowsResponse_Entry;
        $status = new Status;
        $status->setCode(Code::OK);
        $mutateRowsResponseEntry->setIndex(0);
        $mutateRowsResponseEntry->setStatus($status);
        $mutateRowsResponse->setEntries([$mutateRowsResponseEntry]);
        $this->mutateRowsResponses[] = $mutateRowsResponse;
        $this->dataClient = TestHelpers::stub(
            DataClient::class,
            [
                self::PROJECT_ID,
                self::INSTANCE_ID,
                self::TABLE_ID,
                [ 'bigtableClient' => $this->bigtableClient->reveal() ]
            ]
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(DataClient::class);
        $res = $snippet->invoke('dataClient');

        $this->assertInstanceOf(DataClient::class, $res->returnVal());
    }

    public function testMutateRows()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($this->mutateRowsResponses)
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet = $this->snippetFromMethod(DataClient::class, 'mutateRows');
        $snippet->addLocal('dataClient', $this->dataClient);
        $res = $snippet->invoke();
    }

    public function testUpsert()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($this->mutateRowsResponses)
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet = $this->snippetFromMethod(DataClient::class, 'upsert');
        $snippet->addLocal('dataClient', $this->dataClient);
        $res = $snippet->invoke();
    }

    private function arrayAsGenerator(array $array)
    {
        foreach ($array as $item) {
            yield $item;
        }
    }
}
