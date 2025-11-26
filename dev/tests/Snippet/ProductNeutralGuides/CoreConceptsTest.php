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

use Google\ApiCore\OperationResponse;
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Compute\V1\Client\InstancesClient;
use Google\Cloud\Compute\V1\InsertInstanceRequest;
use Google\Cloud\Compute\V1\Instance;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\ListSecretsRequest;
use Google\Cloud\SecretManager\V1\Secret;
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
            '2. Pagination'
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

    public function testPollingForCompletion()
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
}
