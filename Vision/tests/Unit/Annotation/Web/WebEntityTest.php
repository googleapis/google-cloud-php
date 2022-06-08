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

namespace Google\Cloud\Vision\Tests\Unit\Annotation\Web;

use Google\Cloud\Vision\Annotation\Web\WebEntity;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group vision
 */
class WebEntityTest extends TestCase
{
    private $info;
    private $entity;

    public function set_up()
    {
        $this->info = [
            'entityId' => 'foo',
            'score' => 1,
            'description' => 'bar'
        ];
        $this->entity = new WebEntity($this->info);
    }

    public function testEntityId()
    {
        $this->assertEquals($this->info['entityId'], $this->entity->entityId());
    }

    public function testScore()
    {
        $this->assertEquals($this->info['score'], $this->entity->score());
    }

    public function testDescription()
    {
        $this->assertEquals($this->info['description'], $this->entity->description());
    }
}
