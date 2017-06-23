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

namespace Google\Cloud\Tests\Snippets\Spanner;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Tests\GrpcTestTrait;

/**
 * @group spanner
 */
class KeyRangeTest extends SnippetTestCase
{
    use GrpcTestTrait;

    private $range;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->range = new KeyRange;
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(KeyRange::class);
        $snippet->addUse(KeyRange::class);
        $res = $snippet->invoke('range');
        $this->assertInstanceOf(KeyRange::class, $res->returnVal());
    }

    public function testPrefixMatch()
    {
        $key = ['foo'];

        $range = new KeyRange([
            'start' => $key,
            'end' => $key,
            'startType' => KeyRange::TYPE_CLOSED,
            'endType' => KeyRange::TYPE_CLOSED,
        ]);

        $snippet = $this->snippetFromMethod(KeyRange::class, 'prefixMatch');
        $snippet->addLocal('key', $key);
        $snippet->addUse(KeyRange::class);
        $res = $snippet->invoke('range');

        $this->assertEquals($range, $res->returnVal());
    }

    public function testStart()
    {
        $this->range->setStart(KeyRange::TYPE_OPEN, ['Bob']);

        $snippet = $this->snippetFromMethod(KeyRange::class, 'start');
        $snippet->addLocal('range', $this->range);
        $res = $snippet->invoke('start');
        $this->assertEquals(['Bob'], $res->returnVal());
    }

    public function testSetStart()
    {
        $snippet = $this->snippetFromMethod(KeyRange::class, 'setStart');
        $snippet->addLocal('range', $this->range);
        $snippet->addUse(KeyRange::class);
        $res = $snippet->invoke();
        $this->assertEquals(['Bob'], $this->range->start());
    }

    public function testEnd()
    {
        $this->range->setEnd(KeyRange::TYPE_CLOSED, ['Jill']);

        $snippet = $this->snippetFromMethod(KeyRange::class, 'end');
        $snippet->addLocal('range', $this->range);
        $res = $snippet->invoke('end');
        $this->assertEquals(['Jill'], $res->returnVal());
    }

    public function testSetEnd()
    {
        $snippet = $this->snippetFromMethod(KeyRange::class, 'setEnd');
        $snippet->addLocal('range', $this->range);
        $snippet->addUse(KeyRange::class);
        $res = $snippet->invoke();
        $this->assertEquals(['Jill'], $this->range->end());
    }

    public function testTypes()
    {
        $this->range->setStart(KeyRange::TYPE_OPEN, ['foo']);
        $this->range->setEnd(KeyRange::TYPE_OPEN, ['foo']);

        $snippet = $this->snippetFromMethod(KeyRange::class, 'types');
        $snippet->addLocal('range', $this->range);

        $res = $snippet->invoke('types');
        $this->assertEquals([
            'start' => 'startOpen',
            'end' => 'endOpen'
        ], $res->returnVal());
    }
}
