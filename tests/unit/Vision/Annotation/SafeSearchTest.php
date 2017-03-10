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

use Google\Cloud\Vision\Annotation\SafeSearch;

/**
 * @group vision
 */
class SafeSearchTest extends \PHPUnit_Framework_TestCase
{
    private $safeSearch;

    public function setUp()
    {
        $this->safeSearch = new SafeSearch([
            'adult' => 'VERY_LIKELY',
            'spoof' => 'VERY_LIKELY',
            'medical' => 'VERY_LIKELY',
            'violence' => 'VERY_LIKELY'
        ]);
    }

    public function testIsAdult()
    {
        $this->assertTrue($this->safeSearch->isAdult());
    }

    public function testIsSpoof()
    {
        $this->assertTrue($this->safeSearch->isSpoof());
    }

    public function testIsMedical()
    {
        $this->assertTrue($this->safeSearch->isMedical());
    }

    public function testIsViolent()
    {
        $this->assertTrue($this->safeSearch->isViolent());
    }

    public function testCall()
    {
        $this->assertEquals('VERY_LIKELY', $this->safeSearch->violence());
    }
}
