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

namespace Google\Cloud\Tests\Snippets\Vision;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Vision\Annotation;
use Google\Cloud\Vision\Annotation\Entity;
use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Annotation\ImageProperties;
use Google\Cloud\Vision\Annotation\SafeSearch;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group vision
 */
class AnnotationTest extends SnippetTestCase
{
    public function testClass()
    {
        $snippet = $this->class(Annotation::class);
        $snippet->setLine(5, '$imageResource = fopen(\'php://temp\', \'r\');');

        $connectionStub = $this->prophesize(ConnectionInterface::class);
        $connectionStub->annotate(Argument::any())
            ->willReturn(['responses' => [ [] ] ]);

        $snippet->addLocal('connectionStub', $connectionStub->reveal());
        $snippet->insertAfterLine(3, '$reflection = new \ReflectionClass($vision);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($vision, $connectionStub);
            $property->setAccessible(false);'
        );

        $res = $snippet->invoke('annotation');
        $this->assertInstanceOf(Annotation::class, $res->return());
    }

    public function testInfo()
    {
        $snippet = $this->method(Annotation::class, 'info');
        $snippet->addLocal('annotation', new Annotation('foo'));

        $res = $snippet->invoke('info');
        $this->assertEquals('foo', $res->return());
    }

    public function testFaces()
    {
        $snippet = $this->method(Annotation::class, 'faces');
        $snippet->addLocal('annotation', new Annotation([
            'faceAnnotations' => [
                ['landmarks' => []]
            ]
        ]));

        $res = $snippet->invoke('faces');
        $this->assertInstanceOf(Face::class, $res->return()[0]);
    }

    public function testLandmarks()
    {
        $snippet = $this->method(Annotation::class, 'landmarks');
        $snippet->addLocal('annotation', new Annotation([
            'landmarkAnnotations' => [
                []
            ]
        ]));

        $res = $snippet->invoke('landmarks');
        $this->assertInstanceOf(Entity::class, $res->return()[0]);
    }

    public function testLogos()
    {
        $snippet = $this->method(Annotation::class, 'logos');
        $snippet->addLocal('annotation', new Annotation([
            'logoAnnotations' => [
                []
            ]
        ]));

        $res = $snippet->invoke('logos');
        $this->assertInstanceOf(Entity::class, $res->return()[0]);
    }

    public function testLabels()
    {
        $snippet = $this->method(Annotation::class, 'labels');
        $snippet->addLocal('annotation', new Annotation([
            'labelAnnotations' => [
                []
            ]
        ]));

        $res = $snippet->invoke('labels');
        $this->assertInstanceOf(Entity::class, $res->return()[0]);
    }

    public function testText()
    {
        $snippet = $this->method(Annotation::class, 'text');
        $snippet->addLocal('annotation', new Annotation([
            'textAnnotations' => [
                []
            ]
        ]));

        $res = $snippet->invoke('text');
        $this->assertInstanceOf(Entity::class, $res->return()[0]);
    }

    public function testSafeSearch()
    {
        $snippet = $this->method(Annotation::class, 'safeSearch');
        $snippet->addLocal('annotation', new Annotation([
            'safeSearchAnnotation' => []
        ]));

        $res = $snippet->invoke('safeSearch');
        $this->assertInstanceOf(SafeSearch::class, $res->return());
    }

    public function testImageProperties()
    {
        $snippet = $this->method(Annotation::class, 'imageProperties');
        $snippet->addLocal('annotation', new Annotation([
            'imagePropertiesAnnotation' => []
        ]));

        $res = $snippet->invoke('properties');
        $this->assertInstanceOf(ImageProperties::class, $res->return());
    }

    public function testError()
    {
        $snippet = $this->method(Annotation::class, 'error');
        $snippet->addLocal('annotation', new Annotation([
            'error' => []
        ]));

        $res = $snippet->invoke('error');
        $this->assertTrue(is_array($res->return()));
    }
}
