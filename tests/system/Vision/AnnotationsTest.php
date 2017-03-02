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

namespace Google\Cloud\Tests\System\Vision;

use Google\Cloud\Vision\Annotation;
use Google\Cloud\Vision\Annotation\CropHint;
use Google\Cloud\Vision\Annotation\Document;
use Google\Cloud\Vision\Annotation\Entity;
use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Annotation\Face\Landmarks;
use Google\Cloud\Vision\Annotation\ImageProperties;
use Google\Cloud\Vision\Annotation\SafeSearch;
use Google\Cloud\Vision\Annotation\Web;
use Google\Cloud\Vision\Annotation\Web\WebEntity;
use Google\Cloud\Vision\Annotation\Web\WebImage;
use Google\Cloud\Vision\Annotation\Web\WebPage;

/**
 * @group vision
 */
class AnnotationsTest extends VisionTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = parent::$vision;
    }

    public function testAnnotate()
    {
        $image = $this->client->image(
            file_get_contents($this->getFixtureFilePath('landmark.jpg')) , [
                'LANDMARK_DETECTION',
                'SAFE_SEARCH_DETECTION',
                'IMAGE_PROPERTIES',
                'CROP_HINTS',
                'WEB_DETECTION'
            ]
        );

        $res = $this->client->annotate($image);
        $this->assertInstanceOf(Annotation::class, $res);

        // Landmarks
        $this->assertInstanceOf(Entity::class, $res->landmarks()[0]);
        $this->assertEquals('Eiffel Tower', $res->landmarks()[0]->description());

        // Safe Search
        $this->assertInstanceOf(SafeSearch::class, $res->safeSearch());
        $this->assertEquals('VERY_UNLIKELY', $res->safeSearch()->adult());
        $this->assertEquals('VERY_UNLIKELY', $res->safeSearch()->spoof());
        $this->assertEquals('VERY_UNLIKELY', $res->safeSearch()->medical());
        $this->assertEquals('VERY_UNLIKELY', $res->safeSearch()->violence());
        $this->assertFalse($res->safeSearch()->isAdult());
        $this->assertFalse($res->safeSearch()->isSpoof());
        $this->assertFalse($res->safeSearch()->isMedical());
        $this->assertFalse($res->safeSearch()->isViolent());

        // Image Properties
        $this->assertInstanceOf(ImageProperties::class, $res->imageProperties());
        $this->assertTrue(is_array($res->imageProperties()->colors()));

        // Crop Hints
        $this->assertInstanceOf(CropHint::class, $res->cropHints()[0]);
        $this->assertTrue(isset($res->cropHints()[0]->boundingPoly()['vertices']));
        $this->assertTrue(is_float($res->cropHints()[0]->confidence()));
        $this->assertTrue(!is_null($res->cropHints()[0]->importanceFraction()));

        // Web Annotation
        $this->assertInstanceOf(Web::class, $res->web());
        $this->assertInstanceOf(WebEntity::class, $res->web()->entities()[0]);

        $desc = array_filter($res->web()->entities(), function ($e) {
            return ($e->description() === 'Eiffel Tower');
        });
        $this->assertTrue(count($desc) > 0);

        $this->assertInstanceOf(WebImage::class, $res->web()->matchingImages()[0]);
        $this->assertInstanceOf(WebImage::class, $res->web()->partialMatchingImages()[0]);
        $this->assertInstanceOf(WebPage::class, $res->web()->pages()[0]);
    }

    public function testFaceAndLabelDetection()
    {
        $image = $this->client->image(
            file_get_contents($this->getFixtureFilePath('obama.jpg')) , [
                'FACE_DETECTION',
                'LABEL_DETECTION'
            ]
        );

        $res = $this->client->annotate($image);

        $this->assertInstanceOf(Annotation::class, $res);

        // Face Detection
        $this->assertInstanceOf(Face::class, $res->faces()[0]);
        $this->assertInstanceOf(Landmarks::class, $res->faces()[0]->landmarks());
        $this->assertTrue($res->faces()[0]->isJoyful());
        $this->assertFalse($res->faces()[0]->isSorrowful());
        $this->assertFalse($res->faces()[0]->isAngry());
        $this->assertFalse($res->faces()[0]->isSurprised());
        $this->assertFalse($res->faces()[0]->isUnderExposed());
        $this->assertFalse($res->faces()[0]->isBlurred());
        $this->assertFalse($res->faces()[0]->hasHeadwear());

        // Label Detection
        $this->assertInstanceOf(Entity::class, $res->labels()[0]);
    }

    public function testLogoDetection()
    {
        $image = $this->client->image(
            file_get_contents($this->getFixtureFilePath('google.jpg')) , [
                'LOGO_DETECTION'
            ]
        );

        $res = $this->client->annotate($image);
        $this->assertInstanceOf(Annotation::class, $res);
        $this->assertInstanceOf(Entity::class, $res->logos()[0]);
        $this->assertEquals('Google', $res->logos()[0]->description());
    }

    public function testTextDetection()
    {
        $image = $this->client->image(
            file_get_contents($this->getFixtureFilePath('text.jpg')) , [
                'TEXT_DETECTION'
            ]
        );

        $res = $this->client->annotate($image);
        $this->assertInstanceOf(Annotation::class, $res);
        $this->assertInstanceOf(Entity::class, $res->text()[0]);
        $this->assertEquals("Hello World.", explode("\n", $res->text()[0]->description())[0]);
        $this->assertEquals("Goodby World!", explode("\n", $res->text()[0]->description())[1]);
    }

    public function testDocumentTextDetection()
    {
        $image = $this->client->image(
            file_get_contents($this->getFixtureFilePath('text.jpg')) , [
                'DOCUMENT_TEXT_DETECTION'
            ]
        );

        $res = $this->client->annotate($image);

        $this->assertInstanceOf(Annotation::class, $res);
        $this->assertInstanceOf(Document::class, $res->fullText());
    }
}
