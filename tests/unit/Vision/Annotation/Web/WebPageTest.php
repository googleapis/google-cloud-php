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

use Google\Cloud\Vision\Annotation\Web\WebPage;

/**
 * @group vision
 */
class WebPageTest extends \PHPUnit_Framework_TestCase
{
    private $info;
    private $image;

    public function setUp()
    {
        $this->info = [
            'url' => 'http://foo.bar/bat',
            'score' => 0.4
        ];
        $this->image = new WebPage($this->info);
    }

    public function testUrl()
    {
        $this->assertEquals($this->info['url'], $this->image->url());
    }

    public function testScore()
    {
        $this->assertEquals($this->info['score'], $this->image->score());
    }
}
