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

namespace Google\Cloud\Vision\Tests\Snippet\Annotation\Web;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Vision\Annotation\Web\WebPage;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;

/**
 * @group vision
 */
class WebPageTest extends SnippetTestCase
{
    private $info;
    private $image;

    public function set_up()
    {
        $this->info = [
            'url' => 'http://foo.bar/image.jpg',
            'score' => 0.1,
        ];
        $this->image = new WebPage($this->info);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(WebPage::class);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'webDetection' => [
                            'pagesWithMatchingImages' => [
                                []
                            ]
                        ]
                    ]
                ]
            ]);

        $vision = TestHelpers::stub(VisionClient::class);
        $vision->___setProperty('connection', $connection->reveal());

        $snippet->addLocal('vision', $vision);

        $snippet->replace(
            "__DIR__ . '/assets/eiffel-tower.jpg'",
            "'php://temp'"
        );
        $snippet->replace(
            '$vision = new VisionClient();',
            ''
        );

        $res = $snippet->invoke('firstPage');
        $this->assertInstanceOf(WebPage::class, $res->returnVal());
    }

    public function testurl()
    {
        $snippet = $this->snippetFromMagicMethod(WebPage::class, 'url');
        $snippet->addLocal('image', $this->image);

        $res = $snippet->invoke('url');
        $this->assertEquals($this->info['url'], $this->image->url());
    }

    public function testscore()
    {
        $snippet = $this->snippetFromMagicMethod(WebPage::class, 'score');
        $snippet->addLocal('image', $this->image);

        $res = $snippet->invoke('score');
        $this->assertEquals($this->info['score'], $this->image->score());
    }
}
