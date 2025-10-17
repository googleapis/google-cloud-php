<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\BatchDmlResult;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse;
use Google\Cloud\Spanner\V1\Transaction as TransactionProto;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 */
class BatchDmlResultTest extends SnippetTestCase
{
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    use GrpcTestTrait;
    use ProphecyTrait;
    use TimeTrait;

    private $spannerClient;
    private $serializer;
    private $result;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer();
        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->result = new BatchDmlResult([
            'resultSets' => [
                [
                    'stats' => [
                        'rowCountExact' => 1
                    ]
                ], [
                    'stats' => [
                        'rowCountExact' => 2
                    ]
                ]
            ],
            'status' => [
                'code' => 1
            ]
        ], [
            'sql' => 'SELECT 1'
        ]);
    }

    public function testClass()
    {
        $this->spannerClient->executeBatchDml(
            Argument::type(ExecuteBatchDmlRequest::class),
            Argument::type('array')
        )->willReturn(new ExecuteBatchDmlResponse(['result_sets' => []]));

        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto(['id' => 'id']));

        $this->spannerClient->commit(
            Argument::type(CommitRequest::class),
            Argument::type('array')
        )->willReturn(new CommitResponse());

        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn('projects/test-project/instances/my-instance');
        $instance->directedReadOptions()->willReturn([]);
        $session = $this->prophesize(SessionCache::class);
        $session->name()->willReturn(self::SESSION);

        $databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $database = new Database(
            $this->spannerClient->reveal(),
            $databaseAdminClient->reveal(),
            $this->serializer,
            $instance->reveal(),
            'test-project',
            'projects/test-project/instances/my-instance/databases/my-database',
            $session->reveal(),
        );

        $snippet = $this->snippetFromClass(BatchDmlResult::class);
        $snippet->replace('$database = $spanner->connect(\'my-instance\', \'my-database\');', '');
        $snippet->addLocal('database', $database);

        $res = $snippet->invoke('batchDmlResult');

        $this->assertInstanceOf(BatchDmlResult::class, $res->returnVal());
    }

    public function testRowCounts()
    {
        $snippet = $this->snippetFromMethod(BatchDmlResult::class, 'rowCounts');
        $snippet->addLocal('batchDmlResult', $this->result);
        $res = $snippet->invoke('counts');
        $this->assertEquals([1, 2], $res->returnVal());
    }

    public function testError()
    {
        $snippet = $this->snippetFromMethod(BatchDmlResult::class, 'error');
        $snippet->addLocal('batchDmlResult', $this->result);
        $res = $snippet->invoke('error');

        $this->assertEquals(1, $res->returnVal()['status']['code']);
        $this->assertEquals([
            'sql' => 'SELECT 1'
        ], $res->returnVal()['statement']);
    }
}
