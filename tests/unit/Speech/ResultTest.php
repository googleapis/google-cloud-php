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

namespace Google\Cloud\Tests\Unit\Speech;

use Google\Cloud\Speech\Result;
use Prophecy\Argument;

/**
 * @group speech
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    private $transcript;
    private $confidence;
    private $result;

    public function setUp()
    {
        $this->transcript = 'testing';
        $this->confidence = 1.0;
        $this->result = new Result([
            'alternatives' => [
                [
                    'transcript' => $this->transcript,
                    'confidence' => $this->confidence
                ]
            ]
        ]);
    }

    public function testGetsAlternatives()
    {
        $alternatives = $this->result->alternatives();

        $this->assertEquals($this->transcript, $alternatives[0]['transcript']);
        $this->assertEquals($this->confidence, $alternatives[0]['confidence']);
    }

    public function testGetsTopAlternative()
    {
        $alternative = $this->result->topAlternative();

        $this->assertEquals($this->transcript, $alternative['transcript']);
        $this->assertEquals($this->confidence, $alternative['confidence']);
    }

    public function testGetsInfo()
    {
        $info = $this->result->info();

        $this->assertArrayHasKey('alternatives', $info);
    }
}
