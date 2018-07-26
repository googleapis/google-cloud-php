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

namespace Google\Cloud\Vision\Tests\Unit\Annotation;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Vision\Annotation\FeatureInterface;
use Google\Cloud\Vision\Annotation\LikelihoodTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group vision
 */
class LikelihoodTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = TestHelpers::impl(LikelihoodTrait::class);
    }

    /**
     * @dataProvider likelihood
     */
    public function testLikelihoods($expected, $value, $strength)
    {
        $this->assertEquals($expected, $this->stub->call('likelihood', [
            $value,
            $strength
        ]));
    }

    public function likelihood()
    {
        return [
            [true, 'VERY_LIKELY', FeatureInterface::STRENGTH_HIGH],
            [false, 'LIKELY', FeatureInterface::STRENGTH_HIGH],
            [false, 'POSSIBLE', FeatureInterface::STRENGTH_HIGH],
            [true, 'VERY_LIKELY', FeatureInterface::STRENGTH_MEDIUM],
            [true, 'LIKELY', FeatureInterface::STRENGTH_MEDIUM],
            [false, 'POSSIBLE', FeatureInterface::STRENGTH_MEDIUM],
            [true, 'VERY_LIKELY', FeatureInterface::STRENGTH_LOW],
            [true, 'LIKELY', FeatureInterface::STRENGTH_LOW],
            [true, 'POSSIBLE', FeatureInterface::STRENGTH_LOW],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testErr()
    {
        $this->stub->call('likelihood', ['foo', 'bar']);
    }
}
