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

namespace Google\Cloud\Debugger\Tests\Unit;

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\ConfigStorageInterface;
use Google\Cloud\Core\Batch\JobConfig;
use Google\Cloud\Debugger\Agent;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\BreakpointStorage\BreakpointStorageInterface;
use Psr\Log\LoggerInterface;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class AgentTest extends TestCase
{
    private $logger;
    private $storage;
    private $oldDaemonEnv;

    public function setUp()
    {
        parent::setUp();
        $this->oldDaemonEnv = getenv('IS_BATCH_DAEMON_RUNNING');

        if (PHP_MAJOR_VERSION < 7) {
            $this->markTestSkipped('Can only run the Agent on PHP 7+');
        }

        if (!extension_loaded('stackdriver_debugger')) {
            $this->markTestSkipped('Requires stackdriver_debugger php extension.');
        }

        $this->storage = $this->prophesize(BreakpointStorageInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
    }

    public function tearDown()
    {
        if ($this->oldDaemonEnv === false) {
            putenv('IS_BATCH_DAEMON_RUNNING');
        } else {
            putenv('IS_BATCH_DAEMON_RUNNING=' . $this->oldDaemonEnv);
        }
        parent::tearDown();
    }

    public function testSpecifyStorage()
    {
        $this->storage->load()->willReturn(['debuggeeId', []])->shouldBeCalled();
        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $this->logger->reveal()
        ]);
    }

    public function testSpecifyLogger()
    {
        $this->storage->load()->willReturn(['debuggeeId', []])->shouldBeCalled();
        $this->logger->log('INFO', 'LOGPOINT: message', ['context' => 'value'])->shouldBeCalled();

        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $this->logger->reveal()
        ]);
        $agent->handleLogpoint('INFO', 'message', ['context' => 'value']);
    }

    public function testDaemonOptions()
    {
        putenv('IS_BATCH_DAEMON_RUNNING=true');
        $this->storage->load()->willReturn(['debuggeeId', []])->shouldBeCalled();
        $configStorage = $this->prophesize(ConfigStorageInterface::class);
        $configStorage->lock()->willReturn(true)->shouldBeCalled();

        $jobConfig = $this->prophesize(JobConfig::class);
        $jobConfig->registerJob(
            Argument::any(),
            Argument::any()
        );
        $config = $jobConfig->reveal();
        $configStorage->load()->willReturn($config)->shouldBeCalled();
        $configStorage->unlock()->shouldBeCalled();
        $configStorage->save($config)->shouldBeCalled();

        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $this->logger->reveal(),
            'daemonOptions' => [
                'uniquifier' => 'some-value',
                'configStorage' => $configStorage->reveal()
            ]
        ]);
    }

    public function testDefaultMaxStringLength()
    {
        $itemMatcher = function ($item) {
            $this->assertEquals('debuggeeId', $item[0]);
            $this->assertInstanceOf(Breakpoint::class, $item[1]);
            $stackframes = $item[1]->stackFrames();
            $this->assertCount(1, $stackframes);
            $this->assertEquals(1, count($stackframes[0]->locals()));
            $variable = $stackframes[0]->locals()[0];
            $this->assertEquals(500, strlen($variable->info()['value']));
            return true;
        };
        $agent = $this->setupAgent($itemMatcher, []);
        $locals = [[
            'name' => 'longString',
            'value' => str_repeat('a', 10000)
        ]];
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => $locals]
            ]
        ]);
    }

    public function testSetsMaxStringLength()
    {
        $itemMatcher = function ($item) {
            $this->assertEquals('debuggeeId', $item[0]);
            $this->assertInstanceOf(Breakpoint::class, $item[1]);
            $stackframes = $item[1]->stackFrames();
            $this->assertCount(1, $stackframes);
            $this->assertEquals(1, count($stackframes[0]->locals()));
            $variable = $stackframes[0]->locals()[0];
            $this->assertEquals(1000, strlen($variable->info()['value']));
            return true;
        };
        $agent = $this->setupAgent($itemMatcher, [
            'maxValueLength' => 1000
        ]);
        $locals = [[
            'name' => 'longString',
            'value' => str_repeat('a', 10000)
        ]];
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => $locals]
            ]
        ]);
    }

    public function testDefaultMaxPayloadSize()
    {
        $itemMatcher = function ($item) {
            $this->assertEquals('debuggeeId', $item[0]);
            $this->assertInstanceOf(Breakpoint::class, $item[1]);
            $stackframes = $item[1]->stackFrames();
            $this->assertCount(1, $stackframes);
            $this->assertEquals(245, count($stackframes[0]->locals()));
            return true;
        };
        $agent = $this->setupAgent($itemMatcher, []);
        $locals = [];
        for ($i = 0; $i < 1000; $i++) {
            $locals[] = ['name' => 'var' . $i, 'value' => str_repeat('.', $i)];
        }
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => $locals]
            ]
        ]);
    }

    public function testSetsMaxPayloadSize()
    {
        $itemMatcher = function ($item) {
            $this->assertEquals('debuggeeId', $item[0]);
            $this->assertInstanceOf(Breakpoint::class, $item[1]);
            $stackframes = $item[1]->stackFrames();
            $this->assertCount(1, $stackframes);
            // Each entry takes 6 + 3 + 10 bytes = 19 bytes
            // We stop after 900 bytes (1000 - 100 buffer)
            // 19 bytes * 48 = 912 bytes
            $this->assertEquals(48, count($stackframes[0]->locals()));
            return true;
        };
        $agent = $this->setupAgent($itemMatcher, [
            'maxPayloadSize' => 1000
        ]);
        $locals = [];
        for ($i = 0; $i < 1000; $i++) {
            $locals[] = ['name' => 'var', 'value' => 'some value'];
        }
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => $locals]
            ]
        ]);
    }

    private function setupAgent(callable $itemMatcher, array $agentConfig)
    {
        $breakpoints = [
            new Breakpoint(['id' => 'snapshot1'])
        ];
        $this->storage->load()->willReturn(['debuggeeId', $breakpoints])->shouldBeCalled();
        $batchRunner = $this->prophesize(BatchRunner::class);
        $batchRunner->registerJob(
            'stackdriver-debugger',
            Argument::any(),
            Argument::type('array')
        )->shouldBeCalled();
        $batchRunner->submitItem(
            'stackdriver-debugger',
            Argument::that($itemMatcher)
        )->shouldBeCalled();
        return new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $this->logger->reveal(),
            'batchRunner' => $batchRunner->reveal()
        ] + $agentConfig);
    }

    public function testDefaultMaxMemberDepth()
    {
        $itemMatcher = function ($item) {
            $this->assertEquals('debuggeeId', $item[0]);
            $this->assertInstanceOf(Breakpoint::class, $item[1]);
            $stackframes = $item[1]->stackFrames();
            $this->assertCount(1, $stackframes);
            $this->assertEquals(1, count($stackframes[0]->locals()));

            $data = $stackframes[0]->locals()[0]->info();
            $depth = 5;
            while ($depth > 0) {
                $this->assertCount(1, $data['members']);
                $data = $data['members'][0];
                $depth--;
            }
            $this->assertEquals('array (1)', $data['value']);
            $this->assertArrayNotHasKey('members', $data);
            return true;
        };
        $agent = $this->setupAgent($itemMatcher, []);
        $locals = [
            [
                'name' => 'var',
                'value' => [
                    [
                        [
                            [
                                [
                                    [
                                        [
                                            1
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => $locals]
            ]
        ]);
    }

    public function testSetsMaxMemberDepth()
    {
        $itemMatcher = function ($item) {
            $this->assertEquals('debuggeeId', $item[0]);
            $this->assertInstanceOf(Breakpoint::class, $item[1]);
            $stackframes = $item[1]->stackFrames();
            $this->assertCount(1, $stackframes);
            $this->assertEquals(1, count($stackframes[0]->locals()));

            $data = $stackframes[0]->locals()[0]->info();
            $depth = 3;
            while ($depth > 0) {
                $this->assertCount(1, $data['members']);
                $data = $data['members'][0];
                $depth--;
            }
            $this->assertEquals('array (1)', $data['value']);
            $this->assertArrayNotHasKey('members', $data);
            return true;
        };
        $agent = $this->setupAgent($itemMatcher, [
            'maxMemberDepth' => 3
        ]);
        $locals = [
            [
                'name' => 'var',
                'value' => [
                    [
                        [
                            [
                                [
                                    [
                                        [
                                            1
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => $locals]
            ]
        ]);
    }

    public function testDefaultMaxMembers()
    {
        $itemMatcher = function ($item) {
            $this->assertEquals('debuggeeId', $item[0]);
            $this->assertInstanceOf(Breakpoint::class, $item[1]);
            $stackframes = $item[1]->stackFrames();
            $this->assertCount(1, $stackframes);
            $this->assertEquals(1, count($stackframes[0]->locals()));
            $variable = $stackframes[0]->locals()[0];
            $this->assertCount(1000, $variable->info()['members']);
            return true;
        };
        $agent = $this->setupAgent($itemMatcher, []);
        $locals = [[
            'name' => 'longString',
            'value' => array_fill(0, 2000, 'a')
        ]];
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => $locals]
            ]
        ]);
    }

    public function testSetsMaxMembers()
    {
        $itemMatcher = function ($item) {
            $this->assertEquals('debuggeeId', $item[0]);
            $this->assertInstanceOf(Breakpoint::class, $item[1]);
            $stackframes = $item[1]->stackFrames();
            $this->assertCount(1, $stackframes);
            $this->assertEquals(1, count($stackframes[0]->locals()));
            $variable = $stackframes[0]->locals()[0];
            $this->assertCount(5, $variable->info()['members']);
            return true;
        };
        $agent = $this->setupAgent($itemMatcher, [
            'maxMembers' => 5
        ]);
        $locals = [[
            'name' => 'longString',
            'value' => array_fill(0, 2000, 'a')
        ]];
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => $locals]
            ]
        ]);
    }
}
