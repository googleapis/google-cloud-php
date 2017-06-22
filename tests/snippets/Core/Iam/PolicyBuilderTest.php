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

namespace Google\Cloud\Tests\Snippets\Core\Iam;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Core\Iam\PolicyBuilder;

/**
 * @group iam
 */
class PolicyBuilderTest extends SnippetTestCase
{
    private $pb;
    private $policy;

    public function setUp()
    {
        $this->pb = new PolicyBuilder;
        $this->policy = ['etag' => 'foo'];
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(PolicyBuilder::class);
        $res = $snippet->invoke('result');

        $this->assertTrue(is_array($res->returnVal()));
    }

    public function testSetBindings()
    {
        $snippet = $this->snippetFromMethod(PolicyBuilder::class, 'setBindings');
        $snippet->addLocal('builder', $this->pb);

        $res = $snippet->invoke();
        $this->assertEquals('roles/admin', $this->pb->result()['bindings'][0]['role']);
        $this->assertEquals('user:admin@domain.com', $this->pb->result()['bindings'][0]['members'][0]);
    }

    public function testAddBindings()
    {
        $snippet = $this->snippetFromMethod(PolicyBuilder::class, 'addBinding');
        $snippet->addLocal('builder', $this->pb);

        $res = $snippet->invoke();
        $this->assertEquals('roles/admin', $this->pb->result()['bindings'][0]['role']);
        $this->assertEquals('user:admin@domain.com', $this->pb->result()['bindings'][0]['members'][0]);
    }

    public function testRemoveBinding()
    {
        $snippet = $this->snippetFromMethod(PolicyBuilder::class, 'removeBinding');
        $snippet->addLocal('builder', $this->pb);

        $res = $snippet->invoke();
        $this->assertEquals('roles/admin', $this->pb->result()['bindings'][0]['role']);
        $this->assertEquals('user2:admin@domain.com', $this->pb->result()['bindings'][0]['members'][0]);
    }

    public function testSetEtag()
    {
        $snippet = $this->snippetFromMethod(PolicyBuilder::class, 'setEtag');
        $snippet->addLocal('builder', $this->pb);
        $snippet->addLocal('oldPolicy', $this->policy);

        $res = $snippet->invoke();
        $this->assertEquals('foo', $this->pb->result()['etag']);
    }

    public function testSetVersion()
    {
        $snippet = $this->snippetFromMethod(PolicyBuilder::class, 'setVersion');
        $snippet->addLocal('builder', $this->pb);

        $res = $snippet->invoke();
        $this->assertEquals(1, $this->pb->result()['version']);
    }

    public function testResult()
    {
        $snippet = $this->snippetFromMethod(PolicyBuilder::class, 'result');
        $snippet->addLocal('builder', $this->pb);

        $res = $snippet->invoke('policy');
        $this->assertTrue(is_array($res->returnVal()));
    }
}
