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

namespace Google\Cloud\Tests\Unit\Trace;

use Google\Cloud\Trace\MessageEvent;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class MessageEventTest extends TestCase
{
    public function testCreateMessageEvent()
    {
        $messageEvent = new MessageEvent('some id');
        $info = $messageEvent->jsonSerialize()['messageEvent'];

        $this->assertArrayHasKey('id', $info);
        $this->assertEquals('some id', $info['id']);
        $this->assertArrayNotHasKey('uncompressedSizeBytes', $info);
        $this->assertArrayNotHasKey('compressedSizeBytes', $info);
    }

    public function testDefaultType()
    {
        $messageEvent = new MessageEvent('some id');
        $info = $messageEvent->jsonSerialize()['messageEvent'];

        $this->assertArrayHasKey('type', $info);
        $this->assertEquals(MessageEvent::TYPE_UNSPECIFIED, $info['type']);
    }

    public function testUncompressedSize()
    {
        $messageEvent = new MessageEvent('some id', [
            'uncompressedSizeBytes' => 1234
        ]);
        $info = $messageEvent->jsonSerialize()['messageEvent'];

        $this->assertArrayHasKey('uncompressedSizeBytes', $info);
        $this->assertEquals(1234, $info['uncompressedSizeBytes']);
    }

    public function testCompressedSize()
    {
        $messageEvent = new MessageEvent('some id', [
            'compressedSizeBytes' => 1234
        ]);
        $info = $messageEvent->jsonSerialize()['messageEvent'];

        $this->assertArrayHasKey('compressedSizeBytes', $info);
        $this->assertEquals(1234, $info['compressedSizeBytes']);
    }
}
