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

namespace Google\Cloud\Firestore\Tests\Snippet;

use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group firestore
 * @group firestore-fieldpath
 */
class FieldPathTest extends SnippetTestCase
{
    use GrpcTestTrait;

    private $fieldPath;

    public function setUp()
    {
        $this->fieldPath = new FieldPath([]);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromClass(FieldPath::class);
        $res = $snippet->invoke('path');
        $this->assertInstanceOf(FieldPath::class, $res->returnVal());
    }

    public function testFromString()
    {
        $snippet = $this->snippetFromMethod(FieldPath::class, 'fromString');
        $res = $snippet->invoke('path');
        $this->assertInstanceOf(FieldPath::class, $res->returnVal());
    }

    public function testChild()
    {
        $snippet = $this->snippetFromMethod(FieldPath::class, 'child');
        $snippet->addLocal('path', $this->fieldPath);
        $res = $snippet->invoke('child');

        $this->assertCount(1, $res->returnVal()->path());
    }

    public function testPathString()
    {
        $snippet = $this->snippetFromMethod(FieldPath::class, 'pathString');
        $snippet->addLocal('path', $this->fieldPath->child('foo'));
        $res = $snippet->invoke('string');

        $this->assertEquals('foo', $res->returnVal());
    }
}
