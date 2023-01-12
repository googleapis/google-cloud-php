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
use Google\Cloud\Vision\Annotation\CropHint;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;

/**
 * @group vision
 */
class CropHintTest extends SnippetTestCase
{
    private $info;
    private $crop;

    public function set_up()
    {
        $this->info = [
            'boundingPoly' => ['foo' => 'bar'],
            'confidence' => 0.4,
            'importanceFraction' => 0.1
        ];

        $this->hint = new CropHint($this->info);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(CropHint::class);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'cropHintsAnnotation' => [
                            'cropHints' => [[]]
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

        $res = $snippet->invoke('hint');
        $this->assertInstanceOf(CropHint::class, $res->returnVal());
    }

    public function testBoundingPoly()
    {
        $snippet = $this->snippetFromMagicMethod(CropHint::class, 'boundingPoly');
        $snippet->addLocal('hint', $this->hint);

        $res = $snippet->invoke('poly');
        $this->assertEquals($this->info['boundingPoly'], $res->returnVal());
    }

    public function testConfidence()
    {
        $snippet = $this->snippetFromMagicMethod(CropHint::class, 'confidence');
        $snippet->addLocal('hint', $this->hint);

        $res = $snippet->invoke('confidence');
        $this->assertEquals($this->info['confidence'], $res->returnVal());
    }

    public function testImportanceFraction()
    {
        $snippet = $this->snippetFromMagicMethod(CropHint::class, 'importanceFraction');
        $snippet->addLocal('hint', $this->hint);

        $res = $snippet->invoke('importance');
        $this->assertEquals($this->info['importanceFraction'], $res->returnVal());
    }
}
