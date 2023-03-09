<?php
/**
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\BigQuery\Tests\Snippet;

use Google\Cloud\BigQuery\BigNumeric;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigquery
 */
class BigNumericTest extends SnippetTestCase
{
    public function testClass()
    {
        $expected = new BigNumeric('999999999999999999999999999999999999999999999.99999999999999');
        $snippet = $this->snippetFromClass(BigNumeric::class);
        $res = $snippet->invoke('bigNumeric');

        $this->assertInstanceOf(BigNumeric::class, $res->returnVal());
        $this->assertEquals($expected, $res->returnVal());
    }
}
