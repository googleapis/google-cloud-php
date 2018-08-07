<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Firestore\FieldPath;
use PHPUnit\Framework\TestCase;

/**
 * @group firestore
 * @group firestore-fieldpath
 */
class FieldPathTest extends TestCase
{
    private $pieces = ['foo', 'bar', 'hello', 'world'];

    public function testConstruct()
    {
        $fieldPath = new FieldPath($this->pieces);
        $this->assertEquals($this->pieces, $fieldPath->path());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEmptyElements()
    {
        new FieldPath(['']);
    }

    public function testFromString()
    {
        $fieldPath = FieldPath::fromString(implode('.', $this->pieces));
        $this->assertEquals($this->pieces, $fieldPath->path());
    }

    /**
     * @dataProvider invalidPaths
     * @expectedException InvalidArgumentException
     */
    public function testInvalidPaths($path)
    {
        FieldPath::fromString($path);
    }

    public function invalidPaths()
    {
        return [
            ['hello..world'],
            ['.hello.world'],
            ['hello.world.'],
            ['.hello.world.'],
        ];
    }

    /**
     * @dataProvider fieldPaths
     */
    public function testEscapeFieldPath($expected, $input)
    {
        if ($input instanceof FieldPath) {
            $input = $input->pathString();
        } else {
            $input = FieldPath::fromString($input)->pathString();
        }

        $this->assertEquals($expected, $input);
    }

    public function fieldPaths()
    {
        return [
            ['foo.bar',                         'foo.bar'],
            ['foo.bar.bar.bar.baz.whatever',    'foo.bar.bar.bar.baz.whatever'],
            ['this.is.a.bad.`idea!!`',          'this.is.a.bad.idea!!'],
            ['manual.escaping.`isn\'t`.wrong',  'manual.escaping.`isn\'t`.wrong'],
            ['foo.bar',                         new FieldPath(['foo', 'bar'])],
            ['`hello.world`',                   new FieldPath(['hello.world'])],
            ['get.`$$$$`.do.`things#`',         new FieldPath(['get', '$$$$', 'do', 'things#'])]
        ];
    }
}
