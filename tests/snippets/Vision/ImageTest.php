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
use Google\Cloud\ServiceBuilder;
use Google\Cloud\Vision\Image;

/**
 * @group vision
 */
class ImageTest extends SnippetTestCase
{
    public function testImageFromServiceBuilder()
    {
        $snippet = $this->snippetFromClass(Image::class, 'default');
        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function testDirectInstantiation()
    {
        $snippet = $this->snippetFromClass(Image::class, 'direct');
        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function testImageString()
    {
        $snippet = $this->snippetFromClass(Image::class, 'string');
        $snippet->setLine(5, '$imageData = \'foo\';');

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function testGcsImage()
    {
        $cloud = new ServiceBuilder;
        $snippet = $this->snippetFromClass(Image::class, 'gcs');
        $snippet->addLocal('cloud', $cloud);

        $res = $snippet->invoke('image');
        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function testMaxResults()
    {
        $snippet = $this->snippetFromClass(Image::class, 'max');
        $snippet->setLine(5, '$imageResource = fopen(\'php://temp\', \'r\');');

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function testFeatureShortcuts()
    {
        $snippet = $this->snippetFromClass(Image::class, 'shortcut');
        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function testRequestObject()
    {
        $snippet = $this->snippetFromMethod(Image::class, 'requestObject');
        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );

        $res = $snippet->invoke('requestObj');
        $this->assertTrue(array_key_exists('image', $res->returnVal()));
        $this->assertTrue(array_key_exists('features', $res->returnVal()));
    }
}
