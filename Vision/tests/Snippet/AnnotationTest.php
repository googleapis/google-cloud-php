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

namespace Google\Cloud\Vision\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Vision\Annotation;
use Google\Cloud\Vision\Annotation\CropHint;
use Google\Cloud\Vision\Annotation\Document;
use Google\Cloud\Vision\Annotation\Entity;
use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Annotation\ImageProperties;
use Google\Cloud\Vision\Annotation\SafeSearch;
use Google\Cloud\Vision\Annotation\Web;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\VisionClient;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

/**
 * @group vision
 */
class AnnotationTest extends SnippetTestCase
{
    use AssertIsType;

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Annotation::class);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->annotate(Argument::any())
            ->willReturn(['responses' => [[]]]);

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

        $res = $snippet->invoke('annotation');
        $this->assertInstanceOf(Annotation::class, $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'info');
        $snippet->addLocal('annotation', new Annotation('foo'));

        $res = $snippet->invoke('info');
        $this->assertEquals('foo', $res->returnVal());
    }

    public function testFaces()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'faces');
        $snippet->addLocal('annotation', new Annotation([
            'faceAnnotations' => [
                ['landmarks' => []]
            ]
        ]));

        $res = $snippet->invoke('faces');
        $this->assertInstanceOf(Face::class, $res->returnVal()[0]);
    }

    public function testLandmarks()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'landmarks');
        $snippet->addLocal('annotation', new Annotation([
            'landmarkAnnotations' => [
                []
            ]
        ]));

        $res = $snippet->invoke('landmarks');
        $this->assertInstanceOf(Entity::class, $res->returnVal()[0]);
    }

    public function testLogos()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'logos');
        $snippet->addLocal('annotation', new Annotation([
            'logoAnnotations' => [
                []
            ]
        ]));

        $res = $snippet->invoke('logos');
        $this->assertInstanceOf(Entity::class, $res->returnVal()[0]);
    }

    public function testLabels()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'labels');
        $snippet->addLocal('annotation', new Annotation([
            'labelAnnotations' => [
                []
            ]
        ]));

        $res = $snippet->invoke('labels');
        $this->assertInstanceOf(Entity::class, $res->returnVal()[0]);
    }

    public function testText()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'text');
        $snippet->addLocal('annotation', new Annotation([
            'textAnnotations' => [
                []
            ]
        ]));

        $res = $snippet->invoke('text');
        $this->assertInstanceOf(Entity::class, $res->returnVal()[0]);
    }

    public function testSafeSearch()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'safeSearch');
        $snippet->addLocal('annotation', new Annotation([
            'safeSearchAnnotation' => []
        ]));

        $res = $snippet->invoke('safeSearch');
        $this->assertInstanceOf(SafeSearch::class, $res->returnVal());
    }

    public function testImageProperties()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'imageProperties');
        $snippet->addLocal('annotation', new Annotation([
            'imagePropertiesAnnotation' => []
        ]));

        $res = $snippet->invoke('properties');
        $this->assertInstanceOf(ImageProperties::class, $res->returnVal());
    }

    public function testFullText()
    {
        $ft = ['foo' => 'bar'];
        $snippet = $this->snippetFromMethod(Annotation::class, 'fullText');
        $snippet->addLocal('annotation', new Annotation([
            'fullTextAnnotation' => $ft
        ]));

        $res = $snippet->invoke('fullText');
        $this->assertInstanceOf(Document::class, $res->returnVal());
    }

    public function testCropHints()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'cropHints');
        $snippet->addLocal('annotation', new Annotation([
            'cropHintsAnnotation' => [
                'cropHints' => [[]]
            ]
        ]));

        $res = $snippet->invoke('hints');
        $this->assertInstanceOf(CropHint::class, $res->returnVal()[0]);
    }

    public function testWeb()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'web');
        $snippet->addLocal('annotation', new Annotation([
            'webDetection' => []
        ]));

        $res = $snippet->invoke('web');
        $this->assertInstanceOf(Web::class, $res->returnVal());
    }

    public function testError()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'error');
        $snippet->addLocal('annotation', new Annotation([
            'error' => []
        ]));

        $res = $snippet->invoke('error');
        $this->assertIsArray($res->returnVal());
    }
}
