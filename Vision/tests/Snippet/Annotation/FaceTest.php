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

namespace Google\Cloud\Vision\Tests\Snippet\Annotation;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Google\Cloud\Vision\VisionClient;
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
        $snippet = $this->snippetFromClass(Face::class);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->annotate(Argument::any())
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

        $vision = TestHelpers::stub(VisionClient::class);
        $vision->___setProperty('connection', $connection->reveal());

        $snippet->addLocal('vision', $vision);

        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );
        $snippet->replace(
            '$vision = new VisionClient();',
            ''
        );

        $res = $snippet->invoke('face');
        $this->assertInstanceOf(Face::class, $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMagicMethod(Face::class, 'info');
        $snippet->addLocal('face', $this->face);
        $this->assertEquals($this->faceData, $snippet->invoke('info')->returnVal());
    }

    public function testLandmarks()
    {
        $snippet = $this->snippetFromMethod(Face::class, 'landmarks');
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
