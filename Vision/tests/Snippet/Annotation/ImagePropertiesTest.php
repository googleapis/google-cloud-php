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
use Google\Cloud\Vision\Annotation\ImageProperties;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;

/**
 * @group vision
 */
class ImagePropertiesTest extends SnippetTestCase
{
    private $propsData;
    private $props;

    public function set_up()
    {
        $this->propsData = ['dominantColors' => ['colors' => 'colorsTest']];
        $this->props = new ImageProperties($this->propsData);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(ImageProperties::class);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'imagePropertiesAnnotation' => [
                            []
                        ]
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

        $res = $snippet->invoke('imageProperties');
        $this->assertInstanceOf(ImageProperties::class, $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMagicMethod(ImageProperties::class, 'info');
        $snippet->addLocal('imageProperties', $this->props);

        $res = $snippet->invoke('info');
        $this->assertEquals($this->propsData, $res->returnVal());
    }

    public function testColors()
    {
        $snippet = $this->snippetFromMethod(ImageProperties::class, 'colors');
        $snippet->addLocal('imageProperties', $this->props);

        $res = $snippet->invoke('colors');
        $this->assertEquals($this->propsData['dominantColors']['colors'], $res->returnVal());
    }
}
