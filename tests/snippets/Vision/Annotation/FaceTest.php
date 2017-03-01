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

namespace Google\Cloud\Tests\Snippets\Vision\Annotation;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group vision
 */
class FaceTest extends SnippetTestCase
{
    private $faceData;
    private $face;

    public function setUp()
    {
        $this->faceData = [
            'landmarks' => [[]],
            'boundingPoly' => 'testBoundingPoly',
            'fdBoundingPoly' => 'testFdBoundingPoly',
            "rollAngle" => 'testrollAngle',
            "panAngle" => 'testpanAngle',
            "tiltAngle" => 'testtiltAngle',
            "detectionConfidence" => 'testdetectionConfidence',
            "landmarkingConfidence" => 'testlandmarkingConfidence',
            "joyLikelihood" => 'VERY_LIKELY',
            "sorrowLikelihood" => 'VERY_LIKELY',
            "angerLikelihood" => 'VERY_LIKELY',
            "surpriseLikelihood" => 'VERY_LIKELY',
            "underExposedLikelihood" => 'VERY_LIKELY',
            "blurredLikelihood" => 'VERY_LIKELY',
            "headwearLikelihood" => 'VERY_LIKELY',
        ];

        $this->face = new Face($this->faceData);
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
                                'landmarks' => [
                                    []
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

        $snippet = $this->snippetFromClass(Face::class);
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
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'info');
        $snippet->addLocal('face', $this->face);
        $this->assertEquals($this->faceData, $snippet->invoke('info')->returnVal());
    }

    public function testLandmarks()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'landmarks');
        $snippet->addLocal('face', new Face([
            'landmarks' => [
                [
                    'type' => 'LEFT_EYE',
                    'position' => 'foo'
                ]
            ]
        ]));

        $res = $snippet->invoke('leftEye');
        $this->assertEquals('foo', $res->returnVal());
    }

    public function testBoundingpoly()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'boundingPoly');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['boundingPoly'], $res->output());
    }

    public function testFdboundingpoly()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'fdBoundingPoly');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['fdBoundingPoly'], $res->output());
    }

    public function testRollangle()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'rollAngle');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['rollAngle'], $res->output());
    }

    public function testPanangle()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'panAngle');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['panAngle'], $res->output());
    }

    public function testTiltangle()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'tiltAngle');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['tiltAngle'], $res->output());
    }

    public function testDetectionconfidence()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'detectionConfidence');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['detectionConfidence'], $res->output());
    }

    public function testLandmarkingconfidence()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'landmarkingConfidence');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['landmarkingConfidence'], $res->output());
    }

    public function testJoylikelihood()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'joyLikelihood');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['joyLikelihood'], $res->output());
    }

    public function testSorrowlikelihood()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'sorrowLikelihood');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['sorrowLikelihood'], $res->output());
    }

    public function testAngerlikelihood()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'angerLikelihood');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['angerLikelihood'], $res->output());
    }

    public function testSurpriselikelihood()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'surpriseLikelihood');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['surpriseLikelihood'], $res->output());
    }

    public function testUnderexposedlikelihood()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'underExposedLikelihood');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['underExposedLikelihood'], $res->output());
    }

    public function testBlurredlikelihood()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'blurredLikelihood');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['blurredLikelihood'], $res->output());
    }

    public function testHeadwearlikelihood()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'headwearLikelihood');
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($this->faceData['headwearLikelihood'], $res->output());
    }

    /**
     * @dataProvider boolTests
     */
    public function testFaceBoolTests($method, $output)
    {
        $snippet = $this->snippetFromMethod(Face::class, $method);
        $snippet->addLocal('face', $this->face);

        $res = $snippet->invoke();
        $this->assertEquals($output, $res->output());
    }

    public function boolTests()
    {
        return [
            ['isJoyful', 'Face is Joyful'],
            ['isSorrowful', 'Face is Sorrowful'],
            ['isAngry', 'Face is Angry'],
            ['isSurprised', 'Face is Surprised'],
            ['isUnderExposed', 'Face is Under Exposed'],
            ['isBlurred', 'Face is Blurred'],
            ['hasHeadwear', 'Face has Headwear']
        ];
    }
}
