<?php
/**
 * Copyright 2016 Google Inc.
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
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\MutationTrait;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 */
class MutationTraitTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    private $spannerClient;
    private $serializer;
    private $mutationTrait;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        // $this->serializer = new Serializer();
        // $this->spannerClient = $this->prophesize(SpannerClient::class);
        // $session = $this->prophesize(Session::class);
        // $session->info()
        //     ->willReturn([
        //         'databaseName' => 'database'
        //     ]);
        // $session->name()
        //     ->willReturn('database');
        // $operation = new Operation(
        //     $this->spannerClient->reveal(),
        //     $this->serializer,
        //     true
        // );
        $this->mutationTrait = new MutationTraitImpl();
    }

    public function testInsert()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insert');
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('insert', $mutations[0]);
    }

    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertBatch');
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('insert', $mutations[0]);
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'update');
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('update', $mutations[0]);
    }

    public function testUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'updateBatch');
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('update', $mutations[0]);
    }

    public function testInsertOrUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertOrUpdate');
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('insertOrUpdate', $mutations[0]);
    }

    public function testInsertOrUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertOrUpdateBatch');
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('insertOrUpdate', $mutations[0]);
    }

    public function testReplace()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'replace');
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('replace', $mutations[0]);
    }

    public function testReplaceBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'replaceBatch');
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('replace', $mutations[0]);
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'delete');
        $snippet->addUse(KeySet::class);
        $snippet->addLocal('mutationGroup', $this->mutationTrait);

        $res = $snippet->invoke();

        $mutations = $this->mutationTrait->getMutations();
        $this->assertArrayHasKey('delete', $mutations[0]);
    }
}

//@codingStandardsIgnoreStart
class MutationTraitImpl
{
    use MutationTrait {
        getMutations as public;
    }

    // private ValueMapper $mapper;

    public function __construct()
    {
        // $this->mapper = new ValueMapper(false);
    }
}
//@codingStandardsIgnoreEnd
