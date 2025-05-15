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

namespace Google\Cloud\Bigtable\Tests\Unit;

use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\Table;
use Google\Cloud\Bigtable\V2\Client\BigtableClient as BigtableGapicClient;
use Google\Cloud\Bigtable\V2\PingAndWarmRequest;
use Google\Cloud\Bigtable\V2\PingAndWarmResponse;
use Google\Cloud\Core\InsecureCredentialsWrapper;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigtable
 * @group bigtabledata
 */
class BigtableClientTest extends TestCase
{
    use ProphecyTrait;

    private $client;

    public function setUp(): void
    {
        $this->client = TestHelpers::stub(BigtableClient::class, [
            ['projectId' => 'my-project', 'credentials' => new InsecureCredentialsWrapper()]
        ]);
    }

    public function testTable()
    {
        $table = $this->client->table('my-instance', 'my-table');

        $this->assertInstanceOf(Table::class, $table);
    }

    public function testPingAndWarm()
    {
        $gapicClient = $this->prophesize(BigtableGapicClient::class);
        $gapicClient->pingAndWarm(Argument::any())
            ->shouldNotBeCalled();

        $bigtable = new BigtableClient([
            'projectId' => 'my-project',
            'credentials' => new InsecureCredentialsWrapper(),
        ]);
        (fn() => $this->gapicClient = $gapicClient->reveal())->call($bigtable);

        // calling "::table" without the option does not pingandwarm
        $bigtable->table('my-instance', 'my-table');

        // creating the client with the option does not pingandwarm
        $bigtable = new BigtableClient([
            'projectId' => 'my-project',
            'credentials' => new InsecureCredentialsWrapper(),
            'pingAndWarm' => true, // this would throw an auth error if it was called
        ]);

        $pingAndWarmResponse = new PingAndWarmResponse();
        $gapicClient = $this->prophesize(BigtableGapicClient::class);
        $gapicClient->pingAndWarm(
            Argument::that(function (PingAndWarmRequest $request) {
                return $request->getName() === 'projects/my-project/instances/my-instance';
            }),
            []
        )
            ->shouldBeCalledOnce()
            ->willReturn($pingAndWarmResponse);
        $gapicClient->pingAndWarm(
            Argument::that(function (PingAndWarmRequest $request) {
                return $request->getName() === 'projects/my-project/instances/my-instance-2';
            }),
            []
        )
            ->shouldBeCalledOnce()
            ->willReturn($pingAndWarmResponse);

        // calling "::table" with the option should call pingandwarm
        $bigtable = new BigtableClient([
            'projectId' => 'my-project',
            'credentials' => new InsecureCredentialsWrapper(),
            'gapicClient' => $gapicClient->reveal(),
            'pingAndWarm' => true,
        ]);
        (fn() => $this->gapicClient = $gapicClient->reveal())->call($bigtable);
        $bigtable->table('my-instance', 'my-table');

        // "PingAndWarm" will only be called once per instance
        $bigtable->table('my-instance', 'my-table'); // not called
        $bigtable->table('my-instance', 'my-table-2'); // still not called
        $bigtable->table('my-instance-2', 'my-table'); // called
    }
}
