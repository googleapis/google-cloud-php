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
use Google\Cloud\Vision\Annotation\SafeSearch;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;

/**
 * @group vision
 */
class SafeSearchTest extends SnippetTestCase
{
    private $ssData;
    private $ss;

    public function set_up()
    {
        $this->ssData = [
            'adult' => 'VERY_LIKELY',
            'spoof' => 'VERY_LIKELY',
            'medical' => 'VERY_LIKELY',
            'violence' => 'VERY_LIKELY',
            'racy' => 'VERY_LIKELY',
        ];
        $this->ss = new SafeSearch($this->ssData);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(SafeSearch::class);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'safeSearchAnnotation' => [
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

        $res = $snippet->invoke('safeSearch');
        $this->assertInstanceOf(SafeSearch::class, $res->returnVal());
    }

    public function testAdult()
    {
        $snippet = $this->snippetFromMagicMethod(SafeSearch::class, 'adult');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals($this->ssData['adult'], $res->output());
    }

    public function testSpoof()
    {
        $snippet = $this->snippetFromMagicMethod(SafeSearch::class, 'spoof');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals($this->ssData['spoof'], $res->output());
    }

    public function testMedical()
    {
        $snippet = $this->snippetFromMagicMethod(SafeSearch::class, 'medical');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals($this->ssData['medical'], $res->output());
    }

    public function testViolence()
    {
        $snippet = $this->snippetFromMagicMethod(SafeSearch::class, 'violence');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals($this->ssData['violence'], $res->output());
    }

    public function testRacy()
    {
        $snippet = $this->snippetFromMagicMethod(SafeSearch::class, 'racy');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals($this->ssData['racy'], $res->output());
    }

    public function testIsAdult()
    {
        $snippet = $this->snippetFromMethod(SafeSearch::class, 'isAdult');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals(sprintf('Image contains %s content.', 'adult'), $res->output());
    }

    public function testIsSpoof()
    {
        $snippet = $this->snippetFromMethod(SafeSearch::class, 'isSpoof');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals(sprintf('Image contains %s content.', 'spoofed'), $res->output());
    }

    public function testIsMedical()
    {
        $snippet = $this->snippetFromMethod(SafeSearch::class, 'isMedical');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals(sprintf('Image contains %s content.', 'medical'), $res->output());
    }

    public function testIsViolent()
    {
        $snippet = $this->snippetFromMethod(SafeSearch::class, 'isViolent');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals(sprintf('Image contains %s content.', 'violent'), $res->output());
    }

    public function testIsRacy()
    {
        $snippet = $this->snippetFromMethod(SafeSearch::class, 'isRacy');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke();
        $this->assertEquals(sprintf('Image contains %s content.', 'racy'), $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMagicMethod(SafeSearch::class, 'info');
        $snippet->addLocal('safeSearch', $this->ss);

        $res = $snippet->invoke('info');
        $this->assertEquals($this->ssData, $res->returnVal());
    }
}
