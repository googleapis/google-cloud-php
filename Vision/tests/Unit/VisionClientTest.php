<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Vision\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Vision\Annotation;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\Image;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

/**
 * @group vision
 */
class VisionClientTest extends TestCase
{
    use AssertIsType;
    use ExpectException;

    private $client;

    private $connection;

    public function set_up()
    {
        $this->client = TestHelpers::stub(VisionClient::class);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testImage()
    {
        $image = $this->client->image('foobar', ['FACE_DETECTION']);

        $this->assertInstanceOf(Image::class, $image);
    }

    public function testImages()
    {
        $images = $this->client->images(['foobar', 'othertest'], ['FACE_DETECTION']);

        $this->assertInstanceOf(Image::class, $images[0]);
        $this->assertInstanceOf(Image::class, $images[1]);
    }

    public function testAnnotate()
    {
        $image = $this->client->image('foobar', ['FACE_DETECTION']);

        $this->connection->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    []
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->annotate($image);

        $this->assertInstanceOf(Annotation::class, $res);
    }

    public function testAnnotateBatch()
    {
        $image = $this->client->image('foobar', ['FACE_DETECTION']);

        $this->connection->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [], []
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->annotateBatch([$image]);

        $this->assertIsArray($res);

        $this->assertInstanceOf(Annotation::class, $res[0]);
        $this->assertInstanceOf(Annotation::class, $res[1]);
    }

    public function testAnnotateBatchInvalidImageType()
    {
        $this->expectException('InvalidArgumentException');

        $this->client->annotateBatch(['test']);
    }
}
