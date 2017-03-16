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

use Google\Cloud\Vision\Annotation\Face\Landmarks;

/**
 * @group vision
 */
class LandmarksTest extends \PHPUnit_Framework_TestCase
{
    private $data;
    private $landmarks;

    public function setUp()
    {
        $this->data = json_decode(file_get_contents(__DIR__ .'/../../../fixtures/vision/face-landmarks.json'), true);
        $this->landmarks = new Landmarks($this->data);
    }

    public function testLeftEye()
    {
        $this->assertEquals($this->landmarks->leftEye(), $this->pos('LEFT_EYE'));
    }

    public function testLeftEyePupil()
    {
        $this->assertEquals($this->landmarks->leftEyePupil(), $this->pos('LEFT_EYE_PUPIL'));
    }

    public function testLeftEyeBoundaries()
    {
        $b = $this->landmarks->leftEyeBoundaries();

        $this->assertEquals($b['left'], $this->pos('LEFT_EYE_LEFT_CORNER'));
        $this->assertEquals($b['top'], $this->pos('LEFT_EYE_TOP_BOUNDARY'));
        $this->assertEquals($b['right'], $this->pos('LEFT_EYE_RIGHT_CORNER'));
        $this->assertEquals($b['bottom'], $this->pos('LEFT_EYE_BOTTOM_BOUNDARY'));
    }

    public function testLeftEyebrow()
    {
        $b = $this->landmarks->leftEyebrow();

        $this->assertEquals($b['left'], $this->pos('LEFT_OF_LEFT_EYEBROW'));
        $this->assertEquals($b['right'], $this->pos('RIGHT_OF_LEFT_EYEBROW'));
        $this->assertEquals($b['upperMidpoint'], $this->pos('LEFT_EYEBROW_UPPER_MIDPOINT'));
    }

    public function testRightEye()
    {
        $this->assertEquals($this->landmarks->rightEye(), $this->pos('RIGHT_EYE'));
    }

    public function testRightEyePupil()
    {
        $this->assertEquals($this->landmarks->rightEyePupil(), $this->pos('RIGHT_EYE_PUPIL'));
    }

    public function testRightEyeBoundaries()
    {
        $b = $this->landmarks->rightEyeBoundaries();

        $this->assertEquals($b['left'], $this->pos('RIGHT_EYE_LEFT_CORNER'));
        $this->assertEquals($b['top'], $this->pos('RIGHT_EYE_TOP_BOUNDARY'));
        $this->assertEquals($b['right'], $this->pos('RIGHT_EYE_RIGHT_CORNER'));
        $this->assertEquals($b['bottom'], $this->pos('RIGHT_EYE_BOTTOM_BOUNDARY'));
    }

    public function testRightEyebrow()
    {
        $b = $this->landmarks->rightEyebrow();

        $this->assertEquals($b['left'], $this->pos('LEFT_OF_RIGHT_EYEBROW'));
        $this->assertEquals($b['right'], $this->pos('RIGHT_OF_RIGHT_EYEBROW'));
        $this->assertEquals($b['upperMidpoint'], $this->pos('RIGHT_EYEBROW_UPPER_MIDPOINT'));
    }

    public function testMidpointBetweenEyes()
    {
        $this->assertEquals($this->landmarks->midpointBetweenEyes(), $this->pos('MIDPOINT_BETWEEN_EYES'));
    }

    public function testLips()
    {
        $this->assertEquals($this->landmarks->lips()['upper'], $this->pos('UPPER_LIP'));
        $this->assertEquals($this->landmarks->lips()['lower'], $this->pos('LOWER_LIP'));
    }

    public function testMouth()
    {
        $this->assertEquals($this->landmarks->mouth()['left'], $this->pos('MOUTH_LEFT'));
        $this->assertEquals($this->landmarks->mouth()['right'], $this->pos('MOUTH_RIGHT'));
        $this->assertEquals($this->landmarks->mouth()['center'], $this->pos('MOUTH_CENTER'));
    }

    public function testNose()
    {
        $this->assertEquals($this->landmarks->nose()['tip'], $this->pos('NOSE_TIP'));
        $this->assertEquals($this->landmarks->nose()['bottomRight'], $this->pos('NOSE_BOTTOM_RIGHT'));
        $this->assertEquals($this->landmarks->nose()['bottomLeft'], $this->pos('NOSE_BOTTOM_LEFT'));
        $this->assertEquals($this->landmarks->nose()['bottomCenter'], $this->pos('NOSE_BOTTOM_CENTER'));
    }

    public function testEars()
    {
        $this->assertEquals($this->landmarks->ears()['left'], $this->pos('LEFT_EAR_TRAGION'));
        $this->assertEquals($this->landmarks->ears()['right'], $this->pos('RIGHT_EAR_TRAGION'));
    }

    public function testForehead()
    {
        $this->assertEquals($this->landmarks->forehead(), $this->pos('FOREHEAD_GLABELLA'));
    }

    public function testChin()
    {
        $this->assertEquals($this->landmarks->chin()['gnathion'], $this->pos('CHIN_GNATHION'));
        $this->assertEquals($this->landmarks->chin()['left'], $this->pos('CHIN_LEFT_GONION'));
        $this->assertEquals($this->landmarks->chin()['right'], $this->pos('CHIN_RIGHT_GONION'));
    }

    private function pos($type)
    {
        $val = array_filter($this->data, function ($landmark) use ($type) {
            return ($landmark['type'] === $type);
        });

        return array_shift($val)['position'];
    }
}
