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

namespace Google\Cloud\BigQuery\Tests\Snippet;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Time;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigquery
 */
class TimeTest extends SnippetTestCase
{
    public function testClass()
    {
        $snippet = $this->snippetFromClass(Time::class);
        $snippet->addLocal('bigQuery', \Google\Cloud\Core\Testing\TestHelpers::stub(BigQueryClient::class));
        $res = $snippet->invoke('time');

        $this->assertInstanceOf(Time::class, $res->returnVal());
    }
}
