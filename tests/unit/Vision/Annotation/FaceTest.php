<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Tests\Unit\Vision\Annotation;

use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Annotation\Face\Landmarks;

/**
 * @group vision
 */
class FaceTest extends \PHPUnit_Framework_TestCase
{
    private $face;

    public function setUp()
    {
        $this->face = new Face([
            'landmarks' => [],
            'joyLikelihood' => 'VERY_LIKELY',
            'sorrowLikelihood' => 'VERY_LIKELY',
            'angerLikelihood' => 'VERY_LIKELY',
            'surpriseLikelihood' => 'VERY_LIKELY',
            'underExposedLikelihood' => 'VERY_LIKELY',
            'blurredLikelihood' => 'VERY_LIKELY',
            'headwearLikelihood' => 'VERY_LIKELY'
        ]);
    }

    public function testLandmarks()
    {
        $this->assertInstanceOf(Landmarks::class, $this->face->landmarks());
    }

    public function testIsJoyful()
    {
        $this->assertTrue($this->face->isJoyful());
    }

    public function testIsSorrowful()
    {
        $this->assertTrue($this->face->isSorrowful());
    }

    public function testIsAngry()
    {
        $this->assertTrue($this->face->isAngry());
    }

    public function testIsSurprised()
    {
        $this->assertTrue($this->face->isSurprised());
    }

    public function testIsUnderExposed()
    {
        $this->assertTrue($this->face->isUnderExposed());
    }

    public function testIsBlurred()
    {
        $this->assertTrue($this->face->isBlurred());
    }

    public function testHasHeadwear()
    {
        $this->assertTrue($this->face->hasHeadwear());
    }

    public function testCall()
    {
        $this->assertEquals('VERY_LIKELY', $this->face->headwearLikelihood());
    }
}
