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

    public function testDefaultStackFrameLimit()
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
            Argument::that(function ($item) {
                $this->assertEquals('debuggeeId', $item[0]);
                $this->assertInstanceOf(Breakpoint::class, $item[1]);
                $stackframes = $item[1]->stackFrames();
                $this->assertCount(6, $stackframes);
                $this->assertCount(1, $stackframes[0]->locals());
                $this->assertCount(1, $stackframes[1]->locals());
                $this->assertCount(1, $stackframes[2]->locals());
                $this->assertCount(1, $stackframes[3]->locals());
                $this->assertCount(1, $stackframes[4]->locals());
                $this->assertCount(0, $stackframes[5]->locals());
                return true;
            })
        )->shouldBeCalled();
        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $this->logger->reveal(),
            'batchRunner' => $batchRunner->reveal()
        ]);
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => [['name' => 'a', 'value' => 'a']]],
                ['filename' => 'file2.php', 'line' => 20, 'locals' => [['name' => 'b', 'value' => 'b']]],
                ['filename' => 'file3.php', 'line' => 20, 'locals' => [['name' => 'c', 'value' => 'c']]],
                ['filename' => 'file4.php', 'line' => 20, 'locals' => [['name' => 'd', 'value' => 'd']]],
                ['filename' => 'file5.php', 'line' => 20, 'locals' => [['name' => 'e', 'value' => 'e']]],
                ['filename' => 'file6.php', 'line' => 20, 'locals' => [['name' => 'f', 'value' => 'f']]],
            ]
        ]);
    }

    public function testSetStackFrameLimit()
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
            Argument::that(function ($item) {
                $this->assertEquals('debuggeeId', $item[0]);
                $this->assertInstanceOf(Breakpoint::class, $item[1]);
                $stackframes = $item[1]->stackFrames();
                $this->assertCount(6, $stackframes);
                $this->assertCount(1, $stackframes[0]->locals());
                $this->assertCount(1, $stackframes[1]->locals());
                $this->assertCount(1, $stackframes[2]->locals());
                $this->assertCount(0, $stackframes[3]->locals());
                $this->assertCount(0, $stackframes[4]->locals());
                $this->assertCount(0, $stackframes[5]->locals());
                return true;
            })
        )->shouldBeCalled();
        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $this->logger->reveal(),
            'batchRunner' => $batchRunner->reveal(),
            'maxDepth' => 3
        ]);
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => [['name' => 'a', 'value' => 'a']]],
                ['filename' => 'file2.php', 'line' => 20, 'locals' => [['name' => 'b', 'value' => 'b']]],
                ['filename' => 'file3.php', 'line' => 20, 'locals' => [['name' => 'c', 'value' => 'c']]],
                ['filename' => 'file4.php', 'line' => 20, 'locals' => [['name' => 'd', 'value' => 'd']]],
                ['filename' => 'file5.php', 'line' => 20, 'locals' => [['name' => 'e', 'value' => 'e']]],
                ['filename' => 'file6.php', 'line' => 20, 'locals' => [['name' => 'f', 'value' => 'f']]],
            ]
        ]);
    }

    public function testSetNoStackFrameLimit()
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
            Argument::that(function ($item) {
                $this->assertEquals('debuggeeId', $item[0]);
                $this->assertInstanceOf(Breakpoint::class, $item[1]);
                $stackframes = $item[1]->stackFrames();
                $this->assertCount(6, $stackframes);
                $this->assertCount(1, $stackframes[0]->locals());
                $this->assertCount(1, $stackframes[1]->locals());
                $this->assertCount(1, $stackframes[2]->locals());
                $this->assertCount(1, $stackframes[3]->locals());
                $this->assertCount(1, $stackframes[4]->locals());
                $this->assertCount(1, $stackframes[5]->locals());
                return true;
            })
        )->shouldBeCalled();
        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $this->logger->reveal(),
            'batchRunner' => $batchRunner->reveal(),
            'maxDepth' => INF
        ]);
        $agent->handleSnapshot([
            'id' => 'snapshot1',
            'evaluatedExpressions' => [],
            'stackframes' => [
                ['filename' => 'file1.php', 'line' => 20, 'locals' => [['name' => 'a', 'value' => 'a']]],
                ['filename' => 'file2.php', 'line' => 20, 'locals' => [['name' => 'b', 'value' => 'b']]],
                ['filename' => 'file3.php', 'line' => 20, 'locals' => [['name' => 'c', 'value' => 'c']]],
                ['filename' => 'file4.php', 'line' => 20, 'locals' => [['name' => 'd', 'value' => 'd']]],
                ['filename' => 'file5.php', 'line' => 20, 'locals' => [['name' => 'e', 'value' => 'e']]],
                ['filename' => 'file6.php', 'line' => 20, 'locals' => [['name' => 'f', 'value' => 'f']]],
            ]
        ]);
    }
}
