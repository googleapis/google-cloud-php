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

namespace Google\Cloud\Tests\Snippets\Spanner;

use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Session\CacheSessionPool;

/**
 * @group spanner
 */
class CacheSessionPoolTest extends SnippetTestCase
{
    public function testClass()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }

        $snippet = $this->snippetFromClass(CacheSessionPool::class);
        $snippet->replace('$cache =', '//$cache =');
        $snippet->addLocal('cache', new MemoryCacheItemPool);
        $res = $snippet->invoke('database');
        $this->assertInstanceOf(Database::class, $res->returnVal());
    }
}
