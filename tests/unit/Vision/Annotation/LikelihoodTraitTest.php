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

use Google\Cloud\Vision\Annotation\FeatureInterface;
use Google\Cloud\Vision\Annotation\LikelihoodTrait;

/**
 * @group vision
 */
class LikelihoodTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testLikelihoods()
    {
        $t = new LikelihoodTraitStub;

        $this->assertTrue($t->l('VERY_LIKELY', FeatureInterface::STRENGTH_HIGH));
        $this->assertFalse($t->l('LIKELY', FeatureInterface::STRENGTH_HIGH));
        $this->assertFalse($t->l('POSSIBLE', FeatureInterface::STRENGTH_HIGH));

        $this->assertTrue($t->l('VERY_LIKELY', FeatureInterface::STRENGTH_MEDIUM));
        $this->assertTrue($t->l('LIKELY', FeatureInterface::STRENGTH_MEDIUM));
        $this->assertFalse($t->l('POSSIBLE', FeatureInterface::STRENGTH_MEDIUM));

        $this->assertTrue($t->l('VERY_LIKELY', FeatureInterface::STRENGTH_LOW));
        $this->assertTrue($t->l('LIKELY', FeatureInterface::STRENGTH_LOW));
        $this->assertTrue($t->l('POSSIBLE', FeatureInterface::STRENGTH_LOW));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testErr()
    {
        $t = new LikelihoodTraitStub;

        $t->l('foo', 'bar');
    }
}

class LikelihoodTraitStub
{
    use LikelihoodTrait;

    public function l($value, $strength)
    {
        return $this->likelihood($value, $strength);
    }
}
