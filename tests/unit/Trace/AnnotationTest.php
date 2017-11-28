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

namespace Google\Cloud\Tests\Unit\Trace;

use Google\Cloud\Trace\Annotation;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class AnnotationTest extends TestCase
{
    public function testCreateAnAnnotation()
    {
        $annotation = new Annotation('some description');
        $info = $annotation->jsonSerialize()['annotation'];

        $this->assertArrayHasKey('description', $info);
        $this->assertEquals('some description', $info['description']['value']);
        $this->assertArrayNotHasKey('attributes', $info);
    }

    public function testAddsAnAnnotation()
    {
        $annotation = new Annotation('some description');
        $annotation->addAttribute('foo', 'bar');
        $info = $annotation->jsonSerialize()['annotation'];

        $this->assertArrayHasKey('attributes', $info);
        $this->assertEquals('bar', $info['attributes']['foo']);
    }

    public function testCreatesAnAnnotionWithAttributes()
    {
        $annotation = new Annotation('some description', [
            'attributes' => [
                'foo' => 'bar'
            ]
        ]);
        $info = $annotation->jsonSerialize()['annotation'];

        $this->assertArrayHasKey('attributes', $info);
        $this->assertEquals('bar', $info['attributes']['foo']);
    }
}
