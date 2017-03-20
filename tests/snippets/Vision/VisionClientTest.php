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

namespace Google\Cloud\Tests\Snippets\Vision;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Vision\Annotation;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\Image;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;

/**
 * @group vision
 */
class VisionClientTest extends SnippetTestCase
{
    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(VisionClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClassWithServiceBuilder()
    {
        $snippet = $this->snippetFromClass(VisionClient::class);
        $res = $snippet->invoke('vision');

        $this->assertInstanceOf(VisionClient::class, $res->returnVal());
    }

    public function testImage()
    {
        $snippet = $this->snippetFromMethod(VisionClient::class, 'image');
        $snippet->addLocal('vision', $this->client);

        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $res = $snippet->invoke('image');

        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function testImageWithMaxResults()
    {
        $snippet = $this->snippetFromMethod(VisionClient::class, 'image', 1);
        $snippet->addLocal('vision', $this->client);

        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $res = $snippet->invoke('image');

        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function testImages()
    {
        $snippet = $this->snippetFromMethod(VisionClient::class, 'images');
        $snippet->addLocal('vision', $this->client);

        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $snippet->replace(
            "__DIR__ . '/assets/wedding-photo.jpg'",
            "'php://temp'"
        );

        $res = $snippet->invoke('images');
        $this->assertInstanceOf(Image::class, $res->returnVal()[0]);
        $this->assertInstanceOf(Image::class, $res->returnVal()[1]);
    }

    public function testAnnotate()
    {
        $snippet = $this->snippetFromMethod(VisionClient::class, 'annotate');
        $snippet->addLocal('vision', $this->client);

        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $this->connection->annotate(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'responses' => [
                    []
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('result');

        $this->assertInstanceOf(Annotation::class, $res->returnVal());
    }

    public function testAnnotateBatch()
    {
        $snippet = $this->snippetFromMethod(VisionClient::class, 'annotateBatch');
        $snippet->addLocal('vision', $this->client);

        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $snippet->replace(
            "__DIR__ . '/assets/eiffel-tower.jpg'",
            "'php://temp'"
        );

        $this->connection->annotate(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'responses' => [
                    [], []
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('result');

        $this->assertInstanceOf(Annotation::class, $res->returnVal()[0]);
        $this->assertInstanceOf(Annotation::class, $res->returnVal()[1]);
    }
}
