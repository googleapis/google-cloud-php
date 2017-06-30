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
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Tests\GrpcTestTrait;

/**
 * @group spanner
 */
class KeySetTest extends SnippetTestCase
{
    use GrpcTestTrait;

    private $keyset;
    private $range;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->keyset = new KeySet();
        $this->range = new KeyRange();
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(KeySet::class);
        $res = $snippet->invoke('keySet');
        $this->assertInstanceOf(KeySet::class, $res->returnVal());
    }

    public function testRanges()
    {
        $this->keyset->addRange($this->range);

        $snippet = $this->snippetFromMethod(KeySet::class, 'ranges');
        $snippet->addLocal('keySet', $this->keyset);

        $res = $snippet->invoke('ranges');
        $this->assertEquals($this->range, $res->returnVal()[0]);
    }

    public function testAddRange()
    {
        $snippet = $this->snippetFromMethod(KeySet::class, 'addRange');
        $snippet->addLocal('keySet', $this->keyset);
        $snippet->addUse(KeyRange::class);

        $this->assertEmpty($this->keyset->ranges());
        $res = $snippet->invoke();
        $this->assertContainsOnly(KeyRange::class, $this->keyset->ranges());
    }

    public function testSetRanges()
    {
        $snippet = $this->snippetFromMethod(KeySet::class, 'setRanges');
        $snippet->addLocal('keySet', $this->keyset);
        $snippet->addUse(KeyRange::class);

        $this->assertEmpty($this->keyset->ranges());
        $res = $snippet->invoke();
        $this->assertContainsOnly(KeyRange::class, $this->keyset->ranges());
    }

    public function testKeys()
    {
        $snippet = $this->snippetFromMethod(KeySet::class, 'keys');
        $snippet->addLocal('keySet', $this->keyset);

        $this->keyset->addKey('foo');

        $res = $snippet->invoke('keys');
        $this->assertEquals('foo', $res->returnVal()[0]);
    }

    public function testAddKey()
    {
        $snippet = $this->snippetFromMethod(KeySet::class, 'addKey');
        $snippet->addLocal('keySet', $this->keyset);

        $this->assertEmpty($this->keyset->keys());

        $res = $snippet->invoke();
        $this->assertEquals(1, count($this->keyset->keys()));
    }

    public function testSetKeys()
    {
        $snippet = $this->snippetFromMethod(KeySet::class, 'setKeys');
        $snippet->addLocal('keySet', $this->keyset);

        $this->assertEmpty($this->keyset->keys());

        $res = $snippet->invoke();
        $this->assertEquals(2, count($this->keyset->keys()));
    }

    public function testMatchAll()
    {
        $snippet = $this->snippetFromMethod(KeySet::class, 'matchAll');
        $snippet->addLocal('keySet', $this->keyset);

        $this->assertEmpty($snippet->invoke()->output());

        $this->keyset->setMatchAll(true);

        $this->assertEquals('All keys will match', $snippet->invoke()->output());
    }

    public function testSetMatchAll()
    {
        $snippet = $this->snippetFromMethod(KeySet::class, 'setMatchAll');
        $snippet->addLocal('keySet', $this->keyset);

        $this->assertFalse($this->keyset->matchAll());

        $snippet->invoke();

        $this->assertTrue($this->keyset->matchAll());
    }
}
