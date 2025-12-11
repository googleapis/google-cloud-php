<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Dev\Tests\Snippet;

use Google\ApiCore\BidiStream;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\ServerStream;
use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\QueryJobConfiguration;
use Google\Cloud\BigQuery\QueryResults;
use Google\Cloud\BigQuery\Storage\V1\AvroRows;
use Google\Cloud\BigQuery\Storage\V1\Client\BigQueryReadClient;
use Google\Cloud\BigQuery\Storage\V1\ReadRowsRequest;
use Google\Cloud\BigQuery\Storage\V1\ReadRowsResponse;
use Google\Cloud\BigQuery\Storage\V1\RowBlock;
use Google\Cloud\Compute\V1\Client\InstancesClient;
use Google\Cloud\Compute\V1\InsertInstanceRequest;
use Google\Cloud\Compute\V1\Instance;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\ListSecretsRequest;
use Google\Cloud\SecretManager\V1\Secret;
use Google\Cloud\SecretManager\V1\UpdateSecretRequest;
use Google\Cloud\Speech\V2\Client\SpeechClient;
use Google\Cloud\Speech\V2\RecognitionConfig;
use Google\Cloud\Speech\V2\SpeechRecognitionAlternative;
use Google\Cloud\Speech\V2\StreamingRecognitionConfig;
use Google\Cloud\Speech\V2\StreamingRecognitionResult;
use Google\Cloud\Speech\V2\StreamingRecognizeRequest;
use Google\Cloud\Speech\V2\StreamingRecognizeResponse;
use Google\Protobuf\FieldMask;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group docs
 */
class CoreConceptsTest extends SnippetTestCase
{
    private const CORE_CONCEPTS_FILE = __DIR__ . '/../../../../CORE_CONCEPTS.md';
    use ProphecyTrait;

    public function testUsageInClient()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('requires grpc extension to be enabled');
        }

        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            'Usage in Client'
        );

        $res = $snippet->invoke('publisher');
        $publisherClient = $res->returnVal();
        $this->assertInstanceOf(PublisherClient::class, $publisherClient);
    }

    public function testPagination()
    {
        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            '1. Pagination'
        );

        $mockSecrets = [
            (new Secret())->setName('projects/my-project/secrets/secret1'),
            (new Secret())->setName('projects/my-project/secrets/secret2'),
        ];
        // var_dump($mockSecrets);exit;

        // Prophesize the SecretManagerServiceClient
        $secretManagerClient = $this->prophesize(SecretManagerServiceClient::class);

        // Prophesize a PagedListResponse that implements IteratorAggregate
        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->willImplement(\IteratorAggregate::class);
        // $pagedListResponse->iterateAllElements()->willReturn(new \ArrayIterator($mockSecrets));
        $pagedListResponse->getIterator()->willReturn(new \ArrayIterator($mockSecrets));

        $secretManagerClient->listSecrets(
            Argument::type(ListSecretsRequest::class)
            // Argument::that(function ($args) { return })
        )
            ->shouldBeCalledOnce()
            ->willReturn($pagedListResponse->reveal());

        // Replace the client instantiation in the snippet with the mock
        $snippet->replace('$secretManager = new SecretManagerServiceClient();', '');
        $snippet->addLocal('secretManager', $secretManagerClient->reveal());

        $result = $snippet->invoke();
        $output = $result->output();

        $this->assertEquals(<<<'EOF'
Secret: projects/my-project/secrets/secret1
Secret: projects/my-project/secrets/secret2

EOF
, $output);
    }

    public function testManualPagination()
    {
        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            'Manual Pagination (Accessing Tokens)'
        );

        $mockSecrets = [
            (new Secret())->setName('projects/my-project/secrets/secret1'),
        ];

        // Set the $_GET['page_token'] for the snippet
        $_GET['page_token'] = 'first-page-token';

        // Prophesize a PagedListResponse that implements IteratorAggregate
        $page = $this->prophesize(Page::class);
        $page->getNextPageToken()->willReturn('next-page-token');

        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->willImplement(\IteratorAggregate::class);
        $pagedListResponse->getIterator()->willReturn(new \ArrayIterator($mockSecrets));
        $pagedListResponse->getPage()->willReturn($page->reveal());

        // Prophesize the SecretManagerServiceClient
        $secretManagerClient = $this->prophesize(SecretManagerServiceClient::class);
        $secretManagerClient->listSecrets(Argument::that(function (ListSecretsRequest $request) {
            return $request->getPageToken() === 'first-page-token';
        }))
            ->shouldBeCalledOnce()
            ->willReturn($pagedListResponse->reveal());

        $snippet->addUse(ListSecretsRequest::class);
        $snippet->addLocal('secretManager', $secretManagerClient->reveal());

        $res = $snippet->invoke('nextToken');
        $nextToken = $res->returnVal();

        $this->assertEquals('next-page-token', $nextToken);
    }

    public function testLROPollingForCompletion()
    {
        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            'Polling for Completion'
        );

        // Define variables for the snippet
        $project = 'my-project';
        $zone = 'us-central1-a';
        $instance = new Instance();
        $request = new InsertInstanceRequest([
            'project' => $project,
            'zone' => $zone,
            'instance_resource' => $instance
        ]);

        // Prophesize the InstancesClient
        $instancesClient = $this->prophesize(InstancesClient::class);
        $operation = $this->prophesize(OperationResponse::class);

        $operation->pollUntilComplete()->shouldBeCalledOnce();
        $operation->operationSucceeded()->willReturn(true);
        $operation->getResult()->willReturn($instance);

        $instancesClient->insert($request)
            ->shouldBeCalledOnce()
            ->willReturn($operation->reveal());

        $snippet->replace('$instancesClient = new InstancesClient();', '');
        $snippet->addLocals([
            'project' => $project,
            'zone' => $zone,
            'instanceResource' => $instance,
            'instancesClient' => $instancesClient->reveal()
        ]);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Instance::class, $res->returnVal());
    }

    public function testLROAsyncNonBreakingCheck()
    {
        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            'Async / Non-Blocking Check'
        );
        $snippet->replace(
            '$operation = $client->longRunningMethod(...);',
            '$operation = $client->insert(new InsertInstanceRequest());'
        );

        $client = $this->prophesize(InstancesClient::class);
        $operation = $this->prophesize(OperationResponse::class);
        $operation->getName()->willReturn('my-operation');
        $operation->isDone()->willReturn(true);

        $client->insert(Argument::type(InsertInstanceRequest::class))
            ->shouldBeCalled()
            ->willReturn($operation->reveal());
        $client->resumeOperation('my-operation', 'insert')->shouldBeCalled()->willReturn($operation->reveal());

        $snippet->addLocal('client', $client->reveal());
        $snippet->addLocal('methodName', 'insert');
        $snippet->addUse(InsertInstanceRequest::class);

        $snippet->invoke();
    }

    public function testConstructingFieldMasks()
    {
        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            'Constructing a FieldMask'
        );

        $client = $this->prophesize(SecretManagerServiceClient::class);

        $client->updateSecret(Argument::that(function (UpdateSecretRequest $request) {
            $secret = $request->getSecret();
            $this->assertEquals('projects/my-project/secrets/my-secret', $secret->getName());
            $this->assertEquals(['env' => 'production'], iterator_to_array($secret->getLabels()));
            $updateMask = $request->getUpdateMask();
            $this->assertEquals(['labels'], iterator_to_array($updateMask->getPaths()));
            return true;
        }))
            ->shouldBeCalledOnce()
            ->willReturn(new Secret());

        $snippet->replace(
            '$client = new SecretManagerServiceClient();',
            ''
        );
        $snippet->addLocal('client', $client->reveal());

        $snippet->invoke();
    }

    public function testServerStreamingHighLevel()
    {
        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            'Server-Side Streaming Example (High-Level)'
        );

        $config = $this->prophesize(QueryJobConfiguration::class);
        $results = $this->prophesize(QueryResults::class);
        $words = [['word' => 'hello'], ['word' => 'world']];
        $results->getIterator()->willReturn(new \ArrayIterator($words));

        $client = $this->prophesize(BigQueryClient::class);
        $client->query('SELECT * FROM `bigquery-public-data.samples.shakespeare`')
            ->shouldBeCalledOnce()
            ->willReturn($config->reveal());
        $client->runQuery($config->reveal())
            ->shouldBeCalledOnce()
            ->willReturn($results->reveal());

        $snippet->replace(
            '$bigQuery = new BigQueryClient();',
            ''
        );
        $snippet->addLocal('bigQuery', $client->reveal());

        $res = $snippet->invoke();

        $this->assertEquals(
            implode('', array_map(fn ($w) => print_r($w, true), $words)),
            $res->output()
        );
    }

    public function testServerStreamingLowLevel()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('requires grpc extension to be enabled');
        }

        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            'Server-Side Streaming Example (Low-Level)'
        );

        $stream = $this->prophesize(ServerStream::class);
        $response = new ReadRowsResponse([
            'avro_rows' => new AvroRows([
                'serialized_binary_rows' => 'serializedbinaryrowstring'
            ])
        ]);
        $stream->readAll()->willReturn(new \ArrayIterator([$response]));

        $client = $this->prophesize(BigQueryReadClient::class);
        $client->readRows(Argument::type(ReadRowsRequest::class))
            ->shouldBeCalledOnce()
            ->willReturn($stream->reveal());

        $snippet->replace(
            '$readClient = new BigQueryReadClient();',
            ''
        );
        $snippet->addLocal('readClient', $client->reveal());
        $snippet->addUse(ReadRowsResponse::class);
        $snippet->addUse(RowBlock::class);

        $res = $snippet->invoke();

        $this->assertEquals('Row size: 25 bytes' . PHP_EOL, $res->output());
    }

    public function testBidiStreaming()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('requires grpc extension to be enabled');
        }

        $snippet = $this->snippetFromMarkdown(
            self::CORE_CONCEPTS_FILE,
            'gRPC Bidirectional Streaming',
            1
        );

        $result = new StreamingRecognitionResult([
            'alternatives' => [
                new SpeechRecognitionAlternative(['transcript' => 'hello world'])
            ]
        ]);
        $response = new StreamingRecognizeResponse(['results' => [$result]]);

        $stream = $this->prophesize(BidiStream::class);
        $stream->write(Argument::that(function (StreamingRecognizeRequest $request) {
            return $request->getStreamingConfig() || $request->getAudio();
        }))->shouldBeCalledTimes(2);

        $stream->closeWriteAndReadAll()
            ->shouldBeCalledOnce()
            ->willReturn(new \ArrayIterator([$response]));

        $client = $this->prophesize(SpeechClient::class);
        $client->streamingRecognize(Argument::any())
            ->shouldBeCalledOnce()
            ->willReturn($stream->reveal());

        $snippet->replace(
            '$client = new SpeechClient();',
            ''
        );
        $snippet->replace(
            "file_get_contents('audio.raw')",
            "'fake audio content'"
        );

        $snippet->addLocal('client', $client->reveal());
        $snippet->addLocal('recognizerName', 'my-recognizer');

        $res = $snippet->invoke();
        $this->assertEquals('Transcript: hello world' . PHP_EOL, $res->output());
    }
}
