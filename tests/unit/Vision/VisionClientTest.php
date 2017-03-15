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

namespace Google\Cloud\Tests\Unit\Vision;

use Google\Cloud\Vision\Annotation;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\Image;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;

/**
 * @group vision
 */
class VisionClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    private $connection;

    public function setUp()
    {
        $this->client = new VisionClientStub;
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

        $this->client->setConnection($this->connection->reveal());

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

        $this->client->setConnection($this->connection->reveal());

        $res = $this->client->annotateBatch([$image]);

        $this->assertTrue(is_array($res));

        $this->assertInstanceOf(Annotation::class, $res[0]);
        $this->assertInstanceOf(Annotation::class, $res[1]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAnnotateBatchInvalidImageType()
    {
        $this->client->annotateBatch(['test']);
    }
}

class VisionClientStub extends VisionClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
