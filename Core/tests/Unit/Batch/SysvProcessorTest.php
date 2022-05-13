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

namespace Google\Cloud\Core\Tests\Unit\Batch;

use Google\Cloud\Core\Batch\BatchDaemonTrait;
use Google\Cloud\Core\Batch\SysvProcessor;
use Google\Cloud\Core\SysvTrait;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 * @group batch
 */
class SysvProcessorTest extends TestCase
{
    use ExpectException;
    use BatchDaemonTrait;
    use SysvTrait;

    private $submitter;
    private $processor;
    private $queue;

    public function set_up()
    {
        putenv('GOOGLE_CLOUD_SYSV_ID=U');
        if (! $this->isSysvIPCLoaded()) {
            $this->markTestSkipped(
                'Skipping because SystemV IPC extensions are not loaded'
            );
        }
        $this->processor = new SysvProcessor();
        $this->queue = msg_get_queue($this->getSysvKey(1));
        $this->clearQueue();
    }

    public function tear_down()
    {
        if ($this->isSysvIPCLoaded()) {
            $this->clearQueue();
        }
        putenv('GOOGLE_CLOUD_SYSV_ID');
    }

    /**
     * @dataProvider items
     */
    public function testSubmit($item, $exptectedType)
    {
        $this->processor->submit($item, 1);
        $result = $this->receive($type, $message, $errorCode, true);
        $this->assertTrue($result);
        $this->assertEquals($exptectedType, $type);
        if ($type === self::$typeDirect) {
            $this->assertEquals($item, $message);
        } else {
            $this->assertEquals(
                $item,
                unserialize(file_get_contents($message))
            );
            @unlink($message);
        }
    }

    public function items()
    {
        return [
            ['item', self::$typeDirect],
            [str_repeat('x', 8193), self::$typeFile]
        ];
    }

    /**
     * Message queue has no room for a "direct" message, but has enough room for a file path.
     * Test that submit() method does not stall.
     */
    public function testQueueOverflowDirect()
    {
        $queueSize = $this->queueSize();
        $item = str_repeat('a', 8160);
        while ($queueSize >= 9000) {
            $this->send($item);
            $queueSize -= 8192;
        }
        if ($queueSize > 1000) {
            $this->send(str_repeat('b', $queueSize - 1000));
        }

        $gotAlarm = false;
        pcntl_signal(SIGALRM, function ($n, $i) use (&$gotAlarm) {
            $gotAlarm = true;
        });
        try {
            pcntl_alarm(2);
            $this->processor->submit($item, 1);
        } finally {
            pcntl_signal_dispatch();
            pcntl_signal(SIGALRM, SIG_IGN);
            if (!$gotAlarm) {
                sleep(3);
            }
        }

        $this->assertFalse($gotAlarm);
        $gotTypeFile = false;
        while ($this->receive($type, $message, $code)) {
            if ($type == self::$typeFile) {
                $gotTypeFile = true;
                $fileName = unserialize($message);
                $this->assertFileExists($fileName);
                $fileContent = unserialize(file_get_contents($fileName));
                @unlink($fileName);
                $this->assertEquals($item, $fileContent);
            }
        }
        $this->assertTrue($gotTypeFile);
    }

    /**
     * Message queue has no room even for a file path.
     * Test that submit() method does not stall.
     *
     * @depends testQueueOverflowDirect
     */
    public function testQueueOverflowFile()
    {
        $this->expectException('\Google\Cloud\Core\Batch\QueueOverflowException');

        $queueSize = $this->queueSize();
        $item = str_repeat('a', 8160);
        while ($queueSize >= 8192) {
            $this->send($item);
            $queueSize -= 8192;
        }
        do {
            $result = @$this->send('12345678');
        } while ($result);

        $gotAlarm = false;
        pcntl_signal(SIGALRM, function ($n, $i) use (&$gotAlarm) {
            $gotAlarm = true;
        });
        try {
            pcntl_alarm(2);
            $this->processor->submit($item, 1);
        } finally {
            pcntl_signal_dispatch();
            pcntl_signal(SIGALRM, SIG_IGN);
            if (!$gotAlarm) {
                sleep(3);
            }
        }
        $this->assertFalse($gotAlarm);
    }

    private function clearQueue()
    {
        while ($this->receive($type, $message, $code)) {
            if ($type == self::$typeFile) {
                @unlink(unserialize($message));
            }
        }
    }

    private function queueSize()
    {
        return msg_stat_queue($this->queue)['msg_qbytes'];
    }

    private function send($message, $type = null)
    {
        if (!$type) {
            $type = self::$typeDirect;
        }
        $serialize = $type == self::$typeDirect;
        return @msg_send($this->queue, $type, $message, $serialize, false);
    }

    private function receive(&$type, &$message, &$errorcode, $unserialize = false)
    {
        return @msg_receive(
            $this->queue,
            0,
            $type,
            8192,
            $message,
            $unserialize,
            MSG_IPC_NOWAIT,
            $errorcode
        );
    }
}
