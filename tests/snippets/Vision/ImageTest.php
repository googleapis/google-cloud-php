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
        $snippet = $this->class(Image::class, 'default');
        $snippet->setLine(6, '$imageResource = fopen(\'php://temp\', \'r\');');

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->return());
    }

    public function testDirectInstantiation()
    {
        $snippet = $this->class(Image::class, 'direct');
        $snippet->setLine(4, '$imageResource = fopen(\'php://temp\', \'r\');');

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->return());
    }

    public function testImageString()
    {
        $snippet = $this->class(Image::class, 'string');
        $snippet->setLine(5, '$imageData = \'foo\';');

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->return());
    }

    public function testGcsImage()
    {
        $cloud = new ServiceBuilder;
        $snippet = $this->class(Image::class, 'gcs');
        $snippet->addLocal('cloud', $cloud);

        $res = $snippet->invoke('image');
        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->return());
    }

    public function testMaxResults()
    {
        $snippet = $this->class(Image::class, 'max');
        $snippet->setLine(5, '$imageResource = fopen(\'php://temp\', \'r\');');

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->return());
    }

    public function testFeatureShortcuts()
    {
        $snippet = $this->class(Image::class, 'shortcut');
        $snippet->setLine(5, '$imageResource = fopen(\'php://temp\', \'r\');');

        $res = $snippet->invoke('image');
        $this->assertInstanceOf(Image::class, $res->return());
    }

    public function testRequestObject()
    {
        $snippet = $this->method(Image::class, 'requestObject');
        $snippet->setLine(2, '$imageResource = fopen(\'php://temp\', \'r\');');

        $res = $snippet->invoke('requestObj');
        $this->assertTrue(array_key_exists('image', $res->return()));
        $this->assertTrue(array_key_exists('features', $res->return()));
    }
}
