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

namespace Google\Cloud\Tests\Unit\Firestore\Connection;

use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Firestore\Connection\Grpc;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Firestore\V1beta1\Document;
use Google\Cloud\Firestore\V1beta1\DocumentMask;
use Google\Cloud\Firestore\V1beta1\Precondition;
use Google\Cloud\Firestore\V1beta1\StructuredQuery;
use Google\Cloud\Firestore\V1beta1\StructuredQuery_CollectionSelector;
use Google\Cloud\Firestore\V1beta1\TransactionOptions;
use Google\Cloud\Firestore\V1beta1\TransactionOptions_ReadWrite;
use Google\Cloud\Firestore\V1beta1\Value;
use Google\Cloud\Firestore\V1beta1\Write;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-grpc
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';

    private $requestWrapper;
    private $successMessage;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
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

    public function testBeginTransaction()
    {
        $args = [
            'retryTransaction' => 'foo',
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
        ];

        $rw = new TransactionOptions_ReadWrite;
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
            'parent' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE)
        ];

        $expected = [$args['parent'], $this->header()];

        $this->sendAndAssert('listCollectionIds', $args, $expected);
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

        $from = new StructuredQuery_CollectionSelector;
        $from->setCollectionId('parent');
        $q = new StructuredQuery;
        $q->setFrom([$from]);

        $expected = [
            $args['parent'],
            ['structuredQuery' => $q] + $this->header()
        ];

        $this->sendAndAssert('runQuery', $args, $expected);
    }

    private function header()
    {
        return [
            "userHeaders" => [
                "google-cloud-resource-prefix" => ["projects/test/databases/(default)"]
            ]
        ];
    }

    private function sendAndAssert($method, array $args, array $expectedArgs)
    {
        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($this->successMessage);

        $connection = new Grpc([
            'projectId' => 'test',
            'database' => '(default)'
        ]);
        $connection->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($this->successMessage, $connection->$method($args));
    }
}
