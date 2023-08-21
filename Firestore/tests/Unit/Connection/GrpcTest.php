<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore\Tests\Unit\Connection;

use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Connection\Grpc;
use Google\Cloud\Firestore\V1\Document;
use Google\Cloud\Firestore\V1\DocumentMask;
use Google\Cloud\Firestore\V1\Precondition;
use Google\Cloud\Firestore\V1\StructuredQuery;
use Google\Cloud\Firestore\V1\StructuredQuery\CollectionSelector;
use Google\Cloud\Firestore\V1\TransactionOptions;
use Google\Cloud\Firestore\V1\TransactionOptions\ReadWrite;
use Google\Cloud\Firestore\V1\Value;
use Google\Cloud\Firestore\V1\Write;
use Google\Protobuf\Timestamp as ProtobufTimestamp;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-grpc
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';

    private $successMessage;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
    }

    public function testApiEndpoint()
    {
        $expected = 'foobar.com';

        $grpc = new GrpcStub([
            'apiEndpoint' => $expected,
            'projectId' => 'test',
            'database' => 'test'
        ]);

        $this->assertEquals($expected, $grpc->config['apiEndpoint']);
    }

    public function testBatchGetDocuments()
    {
        $documents = [
            sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, 'a/b'),
            sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, 'a/c')
        ];

        $args = [
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'documents' => $documents
        ];

        $expected = [$args['database'], $args['documents'], $this->header()];

        $this->sendAndAssert('batchGetDocuments', $args, $expected);
    }

    public function testBatchGetDocumentsWithReadTime()
    {
        $documents = [
            sprintf(
                'projects/%s/databases/%s/documents/%s',
                self::PROJECT,
                self::DATABASE,
                'a/b'
            ),
            sprintf(
                'projects/%s/databases/%s/documents/%s',
                self::PROJECT,
                self::DATABASE,
                'a/c'
            )
        ];

        $args = [
            'database' => sprintf(
                'projects/%s/databases/%s',
                self::PROJECT,
                self::DATABASE
            ),
            'documents' => $documents,
            'readTime' => [
                'seconds' => 202320232,
                'nanos' => 0
            ]
        ];

        $protobufTimestamp = new ProtobufTimestamp();
        $protobufTimestamp->setSeconds($args['readTime']['seconds']);
        $expected = [
            $args['database'],
            $args['documents'],
            $this->header() + ['readTime' => $protobufTimestamp]
        ];

        $this->sendAndAssert('batchGetDocuments', $args, $expected);
    }

    public function testBeginTransaction()
    {
        $args = [
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
        ];

        $rw = new ReadWrite();

        $options = new TransactionOptions;
        $options->setReadWrite($rw);

        $expected = [
            $args['database'],
            ['options' => $options] + $this->header()
        ];

        $this->sendAndAssert('beginTransaction', $args, $expected);
    }

    public function testBeginTransactionWithPreviousTransactionId()
    {
        $args = [
            'retryTransaction' => 'foo',
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
        ];

        $rw = new ReadWrite();
        $rw->setRetryTransaction($args['retryTransaction']);

        $options = new TransactionOptions;
        $options->setReadWrite($rw);

        $expected = [
            $args['database'],
            ['options' => $options] + $this->header()
        ];

        $this->sendAndAssert('beginTransaction', $args, $expected);
    }

    public function testCommit()
    {
        $args = [
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['fieldPaths' => ['foo']],
                    'currentDocument' => ['exists' => true],
                    'update' => [
                        'name' => 'foo',
                        'fields' => [
                            'foo' => [
                                'stringValue' => 'bar'
                            ]
                        ]
                    ]
                ]
            ],
            'transaction' => 'bar'
        ];

        $write = new Write;

        $mask = new DocumentMask;
        $mask->setFieldPaths(['foo']);
        $write->setUpdateMask($mask);

        $precondition = new Precondition;
        $precondition->setExists(true);
        $write->setCurrentDocument($precondition);

        $document = new Document;
        $document->setName('foo');

        $field = new Value;
        $field->setStringValue('bar');

        $document->setFields(['foo' => $field]);
        $write->setUpdate($document);

        $expected = [
            $args['database'],
            [$write],
            [
                'transaction' => $args['transaction']
            ] + $this->header()
        ];

        $this->sendAndAssert('commit', $args, $expected);
    }

    public function testListCollectionIds()
    {
        $args = [
            'parent' => sprintf('projects/%s/databases/%s/documents', self::PROJECT, self::DATABASE)
        ];

        $expected = [$args['parent'], $this->header()];

        $this->sendAndAssert('listCollectionIds', $args, $expected);
    }

    public function testListCollectionIdsWithReadTime()
    {
        $args = [
            'parent' => sprintf(
                'projects/%s/databases/%s/documents',
                self::PROJECT,
                self::DATABASE
            ),
            'readTime' => [
                'seconds' => 123456789,
                'nanos' => 0
            ]
        ];
        $protobufTimestamp = new ProtobufTimestamp();
        $protobufTimestamp->setSeconds($args['readTime']['seconds']);
        $expected = [
            $args['parent'],
            $this->header() + ['readTime' => $protobufTimestamp]
        ];

        $this->sendAndAssert('listCollectionIds', $args, $expected);
    }

    public function testListDocuments()
    {
        $args = [
            'parent' => sprintf('projects/%s/databases/%s/documents', self::PROJECT, self::DATABASE),
            'collectionId' => 'coll1',
            'mask' => [],
        ];

        $expected = [
            $args['parent'],
            $args['collectionId'],
            [
                'showMissing' => true,
                'mask' => new DocumentMask(['field_paths' => []]),
            ] + $this->header()
        ];

        $this->sendAndAssert('listDocuments', $args, $expected);
    }

    public function testListDocumentsWithReadTime()
    {
        $args = [
            'parent' => sprintf('projects/%s/databases/%s/documents', self::PROJECT, self::DATABASE),
            'collectionId' => 'coll1',
            'mask' => [],
            'readTime' => [
                'seconds' => 123456789,
                'nanos' => 0
            ]
        ];

        $protobufTimestamp = new ProtobufTimestamp();
        $protobufTimestamp->setSeconds($args['readTime']['seconds']);
        $expected = [
            $args['parent'],
            $args['collectionId'],
            [
                'showMissing' => true,
                'mask' => new DocumentMask(['field_paths' => []]),
                'readTime' => $protobufTimestamp
            ] + $this->header()
        ];

        $this->sendAndAssert('listDocuments', $args, $expected);
    }

    public function testRollback()
    {
        $args = [
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'transaction' => 'foo'
        ];

        $expected = [$args['database'], $args['transaction'], $this->header()];

        $this->sendAndAssert('rollback', $args, $expected);
    }

    public function testRunQuery()
    {
        $args = [
            'parent' => 'parent!',
            'structuredQuery' => ['from' => [['collectionId' => 'parent']]]
        ];

        $from = new CollectionSelector();
        $from->setCollectionId('parent');
        $q = new StructuredQuery;
        $q->setFrom([$from]);

        $expected = [
            $args['parent'],
            ['structuredQuery' => $q] + $this->header()
        ];

        $this->sendAndAssert('runQuery', $args, $expected);
    }

    public function testRunQueryWithReadTime()
    {
        $args = [
            'parent' => 'parent!',
            'structuredQuery' => ['from' => [['collectionId' => 'parent']]],
            'readTime' => [
                'seconds' => 123456789,
                'nanos' => 0
            ]
        ];

        $from = new CollectionSelector();
        $from->setCollectionId('parent');
        $q = new StructuredQuery;
        $q->setFrom([$from]);

        $protobufTimestamp = new ProtobufTimestamp();
        $protobufTimestamp->setSeconds($args['readTime']['seconds']);
        $expected = [
            $args['parent'],
            [
                'structuredQuery' => $q,
                'readTime' => $protobufTimestamp
            ] + $this->header()
        ];

        $this->sendAndAssert('runQuery', $args, $expected);
    }

    public function testCustomRequestHeaders()
    {
        $args = [
            'parent' => sprintf('projects/%s/databases/%s/documents', self::PROJECT, self::DATABASE),
            'headers' => [
                'foo' => ['bar']
            ]
        ];

        $headers = $this->header();
        $headers['headers']['foo'] = ['bar'];
        $expected = [$args['parent'], $headers];

        $this->sendAndAssert('listCollectionIds', $args, $expected);
    }

    public function testProvidesAuthorizationHeaderWithEmulator()
    {
        $args = [
            'parent' => sprintf('projects/%s/databases/%s/documents', self::PROJECT, self::DATABASE),
        ];

        $headers = $this->header();
        $headers['headers']['Authorization'] = ['Bearer owner'];
        $expected = [$args['parent'], $headers];

        $connection = TestHelpers::stub(Grpc::class, [
            [
                'projectId' => 'test',
                'database' => '(default)'
            ]
        ], ['isUsingEmulator']);

        $connection->___setProperty('isUsingEmulator', true);
        $this->sendAndAssert('listCollectionIds', $args, $expected, $connection);
    }

    private function header()
    {
        return [
            "headers" => [
                "google-cloud-resource-prefix" => ["projects/test/databases/(default)"],
                "x-goog-request-params" => ["project_id=test&database_id=(default)"]
            ]
        ];
    }

    private function sendAndAssert($method, array $args, array $expectedArgs, Grpc $connection = null)
    {
        $connection = $connection ?: new Grpc([
            'projectId' => 'test',
            'database' => '(default)'
        ]);

        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($this->successMessage);

        $connection->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($this->successMessage, $connection->$method($args));
    }
}

//@codingStandardsIgnoreStart
class GrpcStub extends Grpc
{
    public $config;

    protected function constructGapic($gapicName, array $config)
    {
        $this->config = $config;

        return parent::constructGapic($gapicName, $config);
    }
}
//@codingStandardsIgnoreEnd
