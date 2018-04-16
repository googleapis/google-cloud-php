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

use Google\Cloud\Core\Batch\ConfigStorageInterface;
use Google\Cloud\Core\Batch\JobConfig;
use Google\Cloud\Debugger\Agent;
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
        $agent = new Agent(['storage' => $this->storage->reveal()]);
    }

    public function testSpecifyLogger()
    {
        $this->storage->load()->willReturn(['debuggeeId', []])->shouldBeCalled();
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('INFO', 'LOGPOINT: message', ['context' => 'value'])->shouldBeCalled();

        $agent = new Agent([
            'storage' => $this->storage->reveal(),
            'logger' => $logger->reveal()
        ]);
        $agent->handleLogpoint('INFO', 'message', ['context' => 'value']);
    }

    /**
     * @group focus
     */
    public function testDaemonOptions()
    {
        putenv('IS_BATCH_DAEMON_RUNNING=true');
        $this->storage->load()->willReturn('debuggeeId', [])->shouldBeCalled();
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
            'daemonOptions' => [
                'uniquifier' => 'some-value',
                'configStorage' => $configStorage->reveal()
            ]
        ]);
    }
}
