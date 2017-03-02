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

namespace Google\Cloud\Tests\Vision\Annotation;

use Google\Cloud\Vision\Annotation\Web;
use Google\Cloud\Vision\Annotation\Web\WebEntity;
use Google\Cloud\Vision\Annotation\Web\WebImage;
use Google\Cloud\Vision\Annotation\Web\WebPage;

/**
 * @group vision
 */
class WebTest extends \PHPUnit_Framework_TestCase
{
    private $info;
    private $annotation;

    public function setUp()
    {
        $this->info = [
            'webEntities' => [
                ['foo' => 'bar']
            ],
            'fullMatchingImages' => [
                ['foo' => 'bar']
            ],
            'partialMatchingImages' => [
                ['foo' => 'bar']
            ],
            'pagesWithMatchingImages' => [
                ['foo' => 'bar']
            ]
        ];
        $this->annotation = new Web($this->info);
    }

    public function testEntities()
    {
        $this->assertInstanceOf(WebEntity::class, $this->annotation->entities()[0]);
        $this->assertEquals($this->info['webEntities'][0], $this->annotation->entities()[0]->info());
    }

    public function testMatchingImages()
    {
        $this->assertInstanceOf(WebImage::class, $this->annotation->matchingImages()[0]);
        $this->assertEquals($this->info['fullMatchingImages'][0], $this->annotation->matchingImages()[0]->info());
    }

    public function testPartialMatchingImages()
    {
        $this->assertInstanceOf(WebImage::class, $this->annotation->partialMatchingImages()[0]);
        $this->assertEquals($this->info['partialMatchingImages'][0], $this->annotation->partialMatchingImages()[0]->info());
    }

    public function testPages()
    {
        $this->assertInstanceOf(WebPage::class, $this->annotation->pages()[0]);
        $this->assertEquals($this->info['pagesWithMatchingImages'][0], $this->annotation->pages()[0]->info());
    }
}
