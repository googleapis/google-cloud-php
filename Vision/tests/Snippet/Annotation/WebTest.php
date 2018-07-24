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

namespace Google\Cloud\Vision\Tests\Snippet\Annotation;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Vision\Annotation\Web;
use Google\Cloud\Vision\Annotation\Web\WebEntity;
use Google\Cloud\Vision\Annotation\Web\WebImage;
use Google\Cloud\Vision\Annotation\Web\WebPage;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;

/**
 * @group vision
 */
class WebTest extends SnippetTestCase
{
    private $info;
    private $web;

    public function setUp()
    {
        $this->info = [
            'webEntities' => [
                []
            ],
            'fullMatchingImages' => [
                []
            ],
            'partialMatchingImages' => [
                []
            ],
            'pagesWithMatchingImages' => [
                []
            ]
        ];
        $this->web = new Web($this->info);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Web::class);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'webDetection' => []
                    ]
                ]
            ]);

        $vision = TestHelpers::stub(VisionClient::class);
        $vision->___setProperty('connection', $connection->reveal());

        $snippet->addLocal('vision', $vision);

        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );
        $snippet->replace(
            '$vision = new VisionClient();',
            ''
        );

        $res = $snippet->invoke('web');
        $this->assertInstanceOf(Web::class, $res->returnVal());
    }

    public function testEntities()
    {
        $snippet = $this->snippetFromMethod(Web::class, 'entities');
        $snippet->addLocal('web', $this->web);

        $res = $snippet->invoke('entities');
        $this->assertInstanceOf(WebEntity::class, $res->returnVal()[0]);
    }

    public function testMatchingImages()
    {
        $snippet = $this->snippetFromMethod(Web::class, 'matchingImages');
        $snippet->addLocal('web', $this->web);

        $res = $snippet->invoke('images');
        $this->assertInstanceOf(WebImage::class, $res->returnVal()[0]);
    }

    public function testPartialMatchingImages()
    {
        $snippet = $this->snippetFromMethod(Web::class, 'partialMatchingImages');
        $snippet->addLocal('web', $this->web);

        $res = $snippet->invoke('images');
        $this->assertInstanceOf(WebImage::class, $res->returnVal()[0]);
    }

    public function testPages()
    {
        $snippet = $this->snippetFromMethod(Web::class, 'pages');
        $snippet->addLocal('web', $this->web);

        $res = $snippet->invoke('pages');
        $this->assertInstanceOf(WebPage::class, $res->returnVal()[0]);
    }
}
