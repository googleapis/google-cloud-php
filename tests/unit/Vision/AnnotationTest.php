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

namespace Google\Cloud\Tests\Unit\Vision;

use Google\Cloud\Vision\Annotation;
use Google\Cloud\Vision\Annotation\CropHint;
use Google\Cloud\Vision\Annotation\Document;
use Google\Cloud\Vision\Annotation\Entity;
use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Annotation\ImageProperties;
use Google\Cloud\Vision\Annotation\SafeSearch;
use Google\Cloud\Vision\Annotation\Web;

/**
 * @group vision
 */
class AnnotationTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $res = [
            'faceAnnotations' => [
                ['landmarks' => []]
            ],
            'landmarkAnnotations' => ['foo' => ['bat' => 'bar']],
            'logoAnnotations' => ['foo' => ['bat' => 'bar']],
            'labelAnnotations' => ['foo' => ['bat' => 'bar']],
            'textAnnotations' => ['foo' => ['bat' => 'bar']],
            'safeSearchAnnotation' => ['foo' => ['bat' => 'bar']],
            'imagePropertiesAnnotation' => ['foo' => ['bat' => 'bar']],
            'error' => ['foo' => ['bat' => 'bar']],
            'fullTextAnnotation' => ['foo' => 'bar'],
            'cropHintsAnnotation' => ['cropHints' => [['bat' => 'bar']]],
            'webDetection' => ['foo' => ['bat' => 'bar']],
        ];

        $ann = new Annotation($res);

        $this->assertInstanceOf(Face::class, $ann->faces()[0]);
        $this->assertInstanceOf(Entity::class, $ann->landmarks()[0]);
        $this->assertInstanceOf(Entity::class, $ann->logos()[0]);
        $this->assertInstanceOf(Entity::class, $ann->labels()[0]);
        $this->assertInstanceOf(Entity::class, $ann->text()[0]);
        $this->assertInstanceOf(SafeSearch::class, $ann->safeSearch());
        $this->assertInstanceOf(ImageProperties::class, $ann->imageProperties());
        $this->assertEquals($res['error'], $ann->error());
        $this->assertInstanceOf(Document::class, $ann->fullText());
        $this->assertInstanceOf(CropHint::class, $ann->cropHints()[0]);
        $this->assertInstanceOf(Web::class, $ann->web());

        $this->assertEquals($res, $ann->info());
    }
}
