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

namespace Google\Cloud\Tests\Snippets\Vision\Annotation\Face;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Vision\Annotation\Face\Landmarks;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group vision
 */
class LandmarksTest extends SnippetTestCase
{
    private $pos;
    private $landmarksData;
    private $landmarks;

    public function setUp()
    {
        $this->pos = [
            'x' => 1,
            'y' => 1,
            'z' => 1
        ];

        $this->landmarksData = [
            $this->formatLandmark('LEFT_EYE'),
            $this->formatLandmark('LEFT_EYE_PUPIL'),
            $this->formatLandmark('LEFT_EYE_LEFT_CORNER'),
            $this->formatLandmark('LEFT_EYE_TOP_BOUNDARY'),
            $this->formatLandmark('LEFT_EYE_RIGHT_CORNER'),
            $this->formatLandmark('LEFT_EYE_BOTTOM_BOUNDARY'),
            $this->formatLandmark('LEFT_OF_LEFT_EYEBROW'),
            $this->formatLandmark('RIGHT_OF_LEFT_EYEBROW'),
            $this->formatLandmark('LEFT_EYEBROW_UPPER_MIDPOINT'),
            $this->formatLandmark('RIGHT_EYE'),
            $this->formatLandmark('RIGHT_EYE_PUPIL'),
            $this->formatLandmark('RIGHT_EYE_LEFT_CORNER'),
            $this->formatLandmark('RIGHT_EYE_TOP_BOUNDARY'),
            $this->formatLandmark('RIGHT_EYE_RIGHT_CORNER'),
            $this->formatLandmark('RIGHT_EYE_BOTTOM_BOUNDARY'),
            $this->formatLandmark('LEFT_OF_RIGHT_EYEBROW'),
            $this->formatLandmark('RIGHT_OF_RIGHT_EYEBROW'),
            $this->formatLandmark('RIGHT_EYEBROW_UPPER_MIDPOINT'),
            $this->formatLandmark('MIDPOINT_BETWEEN_EYES'),
            $this->formatLandmark('UPPER_LIP'),
            $this->formatLandmark('LOWER_LIP'),
            $this->formatLandmark('MOUTH_LEFT'),
            $this->formatLandmark('MOUTH_RIGHT'),
            $this->formatLandmark('MOUTH_CENTER'),
            $this->formatLandmark('NOSE_TIP'),
            $this->formatLandmark('NOSE_BOTTOM_RIGHT'),
            $this->formatLandmark('NOSE_BOTTOM_LEFT'),
            $this->formatLandmark('NOSE_BOTTOM_CENTER'),
            $this->formatLandmark('LEFT_EAR_TRAGION'),
            $this->formatLandmark('RIGHT_EAR_TRAGION'),
            $this->formatLandmark('FOREHEAD_GLABELLA'),
            $this->formatLandmark('CHIN_GNATHION'),
            $this->formatLandmark('CHIN_LEFT_GONION'),
            $this->formatLandmark('CHIN_RIGHT_GONION'),
        ];

        $this->landmarks = new Landmarks($this->landmarksData);
    }

    public function testClass()
    {
        $connectionStub = $this->prophesize(ConnectionInterface::class);

        $connectionStub->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'faceAnnotations' => [
                            [
                                'landmarks' => []
                            ]
                        ]
                    ]
                ]
            ]);

        $snippet = $this->snippetFromClass(Landmarks::class);
        $snippet->addLocal('connectionStub', $connectionStub->reveal());
        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );
        $snippet->insertAfterLine(3, '$reflection = new \ReflectionClass($vision);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($vision, $connectionStub);
            $property->setAccessible(false);'
        );

        $res = $snippet->invoke('landmarks');
        $this->assertInstanceOf(Landmarks::class, $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMagicMethod(Landmarks::class, 'info');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke('info');
        $this->assertEquals($this->landmarksData, $res->returnVal());
    }

    public function testLeftEye()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'leftEye');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionOutput('LEFT_EYE'), $res->output());
    }

    public function testLeftEyePupil()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'leftEyePupil');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionOutput('LEFT_EYE_PUPIL'), $res->output());
    }

    public function testLeftEyeBoundaries()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'leftEyeBoundaries');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'left' => 'LEFT_EYE_LEFT_CORNER',
            'top' => 'LEFT_EYE_TOP_BOUNDARY',
            'right' => 'LEFT_EYE_RIGHT_CORNER',
            'bottom' => 'LEFT_EYE_BOTTOM_BOUNDARY'
        ]), $res->output());
    }

    public function testLeftEyeBrow()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'leftEyebrow');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'left' => 'LEFT_OF_LEFT_EYEBROW',
            'right' => 'RIGHT_OF_LEFT_EYEBROW',
            'upperMidpoint' => 'LEFT_EYEBROW_UPPER_MIDPOINT'
        ]), $res->output());
    }

    public function testRightEye()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'rightEye');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionOutput('RIGHT_EYE'), $res->output());
    }

    public function testRightEyePupil()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'rightEyePupil');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionOutput('RIGHT_EYE_PUPIL'), $res->output());
    }

    public function testRightEyeBoundaries()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'rightEyeBoundaries');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'left' => 'RIGHT_EYE_LEFT_CORNER',
            'top' => 'RIGHT_EYE_TOP_BOUNDARY',
            'right' => 'RIGHT_EYE_RIGHT_CORNER',
            'bottom' => 'RIGHT_EYE_BOTTOM_BOUNDARY'
        ]), $res->output());
    }

    public function testRightEyeBrow()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'rightEyebrow');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'left' => 'LEFT_OF_RIGHT_EYEBROW',
            'right' => 'RIGHT_OF_RIGHT_EYEBROW',
            'upperMidpoint' => 'RIGHT_EYEBROW_UPPER_MIDPOINT'
        ]), $res->output());
    }

    public function testMidpointBetweenEyes()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'midpointBetweenEyes');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionOutput('MIDPOINT_BETWEEN_EYES'), $res->output());
    }

    public function testLips()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'lips');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'upper' => 'UPPER_LIP',
            'lower' => 'LOWER_LIP'
        ]), $res->output());
    }

    public function testMouth()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'mouth');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'left' => 'MOUTH_LEFT',
            'right' => 'MOUTH_RIGHT',
            'center' => 'MOUTH_CENTER'
        ]), $res->output());
    }

    public function testNose()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'nose');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'tip' => 'NOSE_TIP',
            'bottomRight' => 'NOSE_BOTTOM_RIGHT',
            'bottomLeft' => 'NOSE_BOTTOM_LEFT',
            'bottomCenter' => 'NOSE_BOTTOM_CENTER'
        ]), $res->output());
    }

    public function testEars()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'ears');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'left' => 'LEFT_EAR_TRAGION',
            'right' => 'RIGHT_EAR_TRAGION'
        ]), $res->output());
    }

    public function testForehead()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'forehead');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionOutput('FOREHEAD_GLABELLA'), $res->output());
    }

    public function testChin()
    {
        $snippet = $this->snippetFromMethod(Landmarks::class, 'chin');
        $snippet->addLocal('landmarks', $this->landmarks);

        $res = $snippet->invoke();
        $this->assertEquals($this->positionAggregate([
            'gnathion' => 'CHIN_GNATHION',
            'left' => 'CHIN_LEFT_GONION',
            'right' => 'CHIN_RIGHT_GONION'
        ]), $res->output());
    }

    /****** HELPERS *****/

    private function positionOutput($type)
    {
        $pos = $this->getLandmark($type);
        $res = '';
        $res .= "x position: ". $pos['position']['x'] . PHP_EOL;
        $res .= "y position: ". $pos['position']['y'] . PHP_EOL;
        $res .= "z position: ". $pos['position']['z'] . PHP_EOL;

        return $res;
    }

    private function positionAggregate(array $positions)
    {
        $res = '';
        foreach ($positions as $name => $pos) {
            $res .= "Position Type: ". $name . PHP_EOL;
            $res .= $this->positionOutput($pos);
        }

        return $res;
    }

    private function getLandmark($type)
    {
        $l = array_filter($this->landmarksData, function ($landmark) use ($type) {
            return ($landmark['type'] === $type);
        });

        if (!empty($l)) {
            return current($l);
        }
    }

    private function formatLandmark($type)
    {
        return [
            'type' => $type,
            'position' => $this->pos
        ];
    }
}
