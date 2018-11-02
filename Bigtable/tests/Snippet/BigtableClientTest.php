<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Tests\Snippet;

use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\Table;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class BigtableClientTest extends SnippetTestCase
{
    public function testClass()
    {
        $snippet = $this->snippetFromClass(BigtableClient::class);
        $snippet->replace(
            '$bigtable = new BigtableClient();',
            '$bigtable = new BigtableClient(["projectId" => "my-project"]);'
        );
        $res = $snippet->invoke('bigtable');

        $this->assertInstanceOf(BigtableClient::class, $res->returnVal());
    }

    public function testTable()
    {
        $client = new BigtableClient(['projectId' => 'my-project']);
        $snippet = $this->snippetFromMethod(BigtableClient::class, 'table');
        $snippet->addLocal('bigtable', $client);
        $res = $snippet->invoke('table');

        $this->assertInstanceOf(Table::class, $res->returnVal());
    }
}
