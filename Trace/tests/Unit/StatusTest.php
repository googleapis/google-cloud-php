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

use Google\Cloud\Trace\Status;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class StatusTest extends TestCase
{
    public function testCreate()
    {
        $status = new Status(200, 'some status message');
        $data = $status->jsonSerialize();
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals(200, $data['code']);
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('some status message', $data['message']);
    }

    public function testCreateWithDetails()
    {
        $details = [
            'id' => 1234,
            '@type' => 'types.example.com/standard/id'
        ];
        $status = new Status(200, 'some status message', [
            'details' => $details
        ]);
        $data = $status->jsonSerialize();
        $this->assertArrayHasKey('details', $data);
        $this->assertEquals($details, $data['details']);
    }
}
