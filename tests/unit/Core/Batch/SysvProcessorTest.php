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

namespace Google\Cloud\Tests\Unit\Core\Batch;

use Google\Cloud\Core\Batch\BatchDaemonTrait;
use Google\Cloud\Core\Batch\SysvProcessor;
use Google\Cloud\Core\SysvTrait;

/**
 * @group core
 * @group batch
 */
class SysvProcessorTest extends \PHPUnit_Framework_TestCase
{
    use BatchDaemonTrait;
    use SysvTrait;

    private $submitter;

    public function setUp()
    {
        putenv('GOOGLE_CLOUD_SYSV_ID=U');
        if (! $this->isSysvIPCLOaded()) {
            $this->markTestSkipped(
                'Skipping because SystemV IPC extensions are not loaded');
        }
        $this->processor = new SysvProcessor();
    }

    public function tearDown()
    {
        putenv('GOOGLE_CLOUD_SYSV_ID');
    }

    /**
     * @dataProvider items
     */
    public function testSubmit($item, $exptectedType)
    {
        $this->processor->submit($item, 1);
        $q = msg_get_queue($this->getSysvKey(1));
        $result = msg_receive(
            $q,
            0,
            $type,
            8192,
            $message,
            true,
            MSG_IPC_NOWAIT,
            $errorcode
        );
        $this->assertTrue($result);
        $this->assertEquals($exptectedType, $type);
        if ($type === self::$typeDirect) {
            $this->assertEquals($item, $message);
        } else {
            $this->assertEquals(
                $item,
                unserialize(file_get_contents($message)));
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
}
