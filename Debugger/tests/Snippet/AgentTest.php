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

namespace Google\Cloud\Debugger\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Debugger\Agent;
use Google\Cloud\Debugger\BreakpointStorage\BreakpointStorageInterface;
use Prophecy\Argument;

/**
 * @group debugger
 */
class AgentTest extends SnippetTestCase
{
    private $storage;

    public function set_up()
    {
        $this->storage = $this->prophesize(BreakpointStorageInterface::class);
    }

    public function testClass()
    {
        $this->storage->load()->willReturn(['debuggee-id', []]);

        $snippet = $this->snippetFromClass(Agent::class);
        $snippet->addLocal('options', [
            'storage' => $this->storage->reveal()
        ]);
        $snippet->replace('Agent()', 'Agent($options)');

        $res = $snippet->invoke('agent');
        $this->assertInstanceOf(Agent::class, $res->returnVal());
    }
}
