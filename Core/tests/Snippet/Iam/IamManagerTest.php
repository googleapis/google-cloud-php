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

namespace Google\Cloud\Core\Tests\Snippet\Iam;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\TestHelpers;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group iam
 */
class IamManagerTest extends SnippetTestCase
{
    use ProphecyTrait;

    private $policyData;
    private $resource;

    private $requestHandler;
    private $serializer;
    private $iam;

    public function setUp(): void
    {
        $this->policyData = [];
        $this->resource = 'testObject';

        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->serializer = new Serializer();
        $this->iam = TestHelpers::stub(IamManager::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            '',
            $this->resource
        ], ['requestHandler']);
    }

    public function testPolicy()
    {
        $snippet = $this->snippetFromMethod(IamManager::class, 'policy');
        $snippet->addLocal('iam', $this->iam);

        $this->requestHandler->sendRequest(
            Argument::any(),
            'getIamPolicy',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn(['foo']);

        $this->iam->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('policy');
        $this->assertEquals(['foo'], $res->returnVal());
    }

    public function testSetPolicy()
    {
        $snippet = $this->snippetFromMethod(IamManager::class, 'setPolicy');
        $snippet->addLocal('iam', $this->iam);

            $this->requestHandler->sendRequest(
                Argument::any(),
                'setIamPolicy',
                Argument::cetera(),
            )->shouldBeCalled()->willReturn(['foo']);

        $this->iam->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('policy');

        $this->assertEquals(['foo'], $res->returnVal());
    }

    public function testTestPermissions()
    {
        $permissions = [
            'pubsub.topics.publish',
            'pubsub.topics.attachSubscription'
        ];

        $snippet = $this->snippetFromMethod(IamManager::class, 'testPermissions');
        $snippet->addLocal('iam', $this->iam);

        $this->requestHandler->sendRequest(
            Argument::any(),
            'testIamPermissions',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn(['permissions' => $permissions]);

        $this->iam->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('allowedPermissions');
        $this->assertEquals($permissions, $res->returnVal());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Iam::class, 'reload');
        $snippet->addLocal('iam', $this->iam);

        $this->requestHandler->sendRequest(
            Argument::any(),
            'getIamPolicy',
            Argument::cetera()
        )->shouldBeCalled()
        ->willReturn(['foo']);

        $this->iam->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $snippet->invoke('policy');
        $this->assertEquals(['foo'], $res->returnVal());
    }
}
