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

namespace Google\Cloud\Tests\Unit\Firestore;

use Google\Cloud\Firestore\PathTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group firestore
 * @group firestore-pathtrait
 */
class PathTraitTest extends TestCase
{
    const PROJECT = 'project';
    const DATABASE = 'database';
    const ROOT = 'a';
    const DOCUMENT = 'a/b';
    const COLLECTION = 'a/b/c';

    private $impl;

    public function setUp()
    {
        $this->impl = \Google\Cloud\Dev\impl(PathTrait::class);
    }

    public function testFullName()
    {
        $path = 'foo/bar';

        $this->assertEquals(
            sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::DOCUMENT),
            $this->impl->call('fullName', [self::PROJECT, self::DATABASE, self::DOCUMENT])
        );
    }

    public function testDatabaseName()
    {
        $this->assertEquals(
            sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            $this->impl->call('databaseName', [self::PROJECT, self::DATABASE])
        );
    }

    public function testFullNameFromDatabase()
    {
        $relativeName = 'foo/bar';
        $this->assertEquals(
            sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, $relativeName),
            $this->impl->call('fullNameFromDatabase', [
                sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
                $relativeName
            ])
        );
    }

    public function testDatabaseFromName()
    {
        $path = sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::DOCUMENT);

        $this->assertEquals(
            sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            $this->impl->call('databaseFromName', [$path])
        );
    }

    /**
     * @dataProvider documentsTrue
     */
    public function testIsDocument($name)
    {
        $this->assertTrue(
            $this->impl->call('isDocument', [$name])
        );
    }

    public function documentsTrue()
    {
        return [
            [self::DOCUMENT],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::DOCUMENT)]
        ];
    }

    /**
     * @dataProvider documentsFalse
     */
    public function testIsDocumentFalse($name)
    {
        $this->assertFalse(
            $this->impl->call('isDocument', [$name])
        );
    }

    public function documentsFalse()
    {
        return [
            [self::COLLECTION],
            [self::ROOT],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::ROOT)],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::COLLECTION)],
        ];
    }

    /**
     * @dataProvider collectionsTrue
     */
    public function testIsCollection($name)
    {
        $this->assertTrue(
            $this->impl->call('isCollection', [$name])
        );
    }

    /**
     * @dataProvider collectionsFalse
     */
    public function testIsCollectionFalse($name)
    {
        $this->assertFalse(
            $this->impl->call('isCollection', [$name])
        );
    }

    public function collectionsTrue()
    {
        return [
            [self::COLLECTION],
            [self::ROOT],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::ROOT)],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::COLLECTION)],
        ];
    }

    public function collectionsFalse()
    {
        return [
            [self::DOCUMENT],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::DOCUMENT)]
        ];
    }

    /**
     * @dataProvider pathId
     */
    public function testPathId($path, $expected = null)
    {
        $this->assertEquals($expected ?: $path, $this->impl->call('pathId', [$path]));
    }

    public function pathId()
    {
        return [
            [self::ROOT],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::ROOT), self::ROOT],
            [
                sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::COLLECTION),
                array_reverse(explode('/', self::COLLECTION))[0]
            ],
            ['', null]
        ];
    }

    public function testChildPath()
    {
        $path = sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::ROOT);
        $child = 'foo';

        $this->assertEquals(
            $path . '/' . $child,
            $this->impl->call('childPath', [$path, $child])
        );
    }

    public function testParentPath()
    {
        $path = sprintf('projects/%s/databases/%s/documents', self::PROJECT, self::DATABASE);
        $child = $path . '/foo';

        $this->assertEquals(
            $path,
            $this->impl->call('parentPath', [$child])
        );
    }

    public function testRandomName()
    {
        $path = sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::ROOT);

        $random = $this->impl->call('randomName', [$path]);

        $this->assertEquals(
            $path,
            $this->impl->call('parentPath', [
                $random
            ])
        );

        $this->assertEquals(20, strlen(array_reverse(explode('/', $random))[0]));
    }

    /**
     * @dataProvider relativeNames
     */
    public function testRelativeName($path, $expected)
    {
        $this->assertEquals($expected, $this->impl->call('relativeName', [$path]));
    }

    public function relativeNames()
    {
        return [
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::ROOT), self::ROOT],
            [sprintf('projects/%s/databases/%s/documents', self::PROJECT, self::DATABASE), ''],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::COLLECTION), self::COLLECTION],
            [sprintf('projects/%s/databases/%s/documents/%s', self::PROJECT, self::DATABASE, self::DOCUMENT), self::DOCUMENT]
        ];
    }

    /**
     * @dataProvider prefixOf
     */
    public function testIsPrefixOf($result, $original, $other)
    {
        $this->assertEquals($result, $this->impl->call('isPrefixOf', [$original, $other]));
    }

    public function prefixOf()
    {
        $base = 'projects/foo/databases/bar/documents/';

        return [
            [true, $base . 'a/b/c', $base .'a/b/c'],
            [true, $base . 'a/b/c/d', $base .'a/b/c/d'],
            [true, $base . 'a', $base .'a/b/c/d'],
            [false, $base . 'a', $base],
            [false, $base . 'a/b/c/d/e/f', $base .'a/b/c/d'],
        ];
    }
}
