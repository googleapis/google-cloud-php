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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Numeric;
use Google\Cloud\Core\Testing\GrpcTestTrait;

/**
 * @group spanner
 */
class NumericTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const SECONDS = 1;
    const NANOS = 2;

    private $numeric;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->numeric = new Numeric(self::SECONDS, self::NANOS);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Numeric::class);
        $res = $snippet->invoke('numeric');
        $this->assertInstanceOf(Numeric::class, $res->returnVal());
    }
}
