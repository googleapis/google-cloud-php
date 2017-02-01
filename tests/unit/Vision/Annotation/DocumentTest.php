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

namespace Google\Cloud\Tests\Vision\Annotation;

use Google\Cloud\Vision\Annotation\Document;

/**
 * @group vision
 */
class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $res = [
            'foo' => 'bar'
        ];

        $e = new Document($res);

        $this->assertEquals($res, $e->info());
        $this->assertEquals('bar', $e->foo());
    }
}
