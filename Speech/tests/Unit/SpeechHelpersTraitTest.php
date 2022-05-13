<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Speech\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Speech\SpeechHelpersTrait;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group speech
 */
class SpeechHelpersTraitTest extends TestCase
{
    const GCS_URI = 'gs://bucket/object';

    private $implementation;

    public function set_up()
    {
        $this->implementation = TestHelpers::impl(SpeechHelpersTrait::class);
    }

    /**
     * @dataProvider createAudioStreamDataProvider
     */
    public function testCreateAudioStreamFromResource($resource, $chunkSize, $expectedData)
    {
        if (is_null($chunkSize)) {
            $audioData = $this->implementation->call(
                'createAudioStreamFromResource',
                [$resource]
            );
        } else {
            $audioData = $this->implementation->call(
                'createAudioStreamFromResource',
                [$resource, $chunkSize]
            );
        }

        $this->assertSame($expectedData, iterator_to_array($audioData));
    }

    public function createAudioStreamDataProvider()
    {
        $data = "abcdefghijklmnop";
        return [
            [$this->createResource($data), null, [$data]],
            [$this->createResource($data), strlen($data), [$data]],
            [$this->createResource($data), 5, ["abcde", "fghij", "klmno", "p"]],
        ];
    }

    private function createResource($data)
    {
        $resource = fopen('php://memory', 'r+');
        fwrite($resource, $data);
        rewind($resource);
        return $resource;
    }
}
