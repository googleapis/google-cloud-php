<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Spanner\Tests\System;

use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Cloud\Spanner\Session\CacheSessionPool;
use Google\Cloud\Spanner\Session\Session;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @group spanner
 * @group spanner-session
 */
class SessionTest extends SpannerTestCase
{
    public function testCacheSessionPool()
    {
        $identity = self::$database->identity();
        $cacheKey = sprintf(
            CacheSessionPool::CACHE_KEY_TEMPLATE,
            $identity['projectId'],
            $identity['instance'],
            $identity['database']
        );

        $cache = new MemoryCacheItemPool;
        $pool = new CacheSessionPool($cache, [
            'maxSessions' => 10,
            'minSessions' => 5,
            'shouldWaitForSession' => false
        ]);
        $pool->setDatabase(self::$database);

        $this->assertNull($cache->getItem($cacheKey)->get());

        $pool->warmup();

        $this->assertPoolCounts($cache, $cacheKey, 5, 0, 0);

        $session = $pool->acquire();
        $this->assertInstanceOf(Session::class, $session);
        $this->assertTrue($session->exists());
        $this->assertPoolCounts($cache, $cacheKey, 4, 1, 0);
        $this->assertEquals($session->name(), current($cache->getItem($cacheKey)->get()['inUse'])['name']);

        $pool->release($session);

        $inUse = [];
        for ($i = 0; $i < 10; $i++) {
            $inUse[] = $pool->acquire();
        }

        $this->assertPoolCounts($cache, $cacheKey, 0, 10, 0);

        $exception = null;
        try {
            $pool->acquire();
        } catch (\RuntimeException $exception) {
            // no-op
        }
        $this->assertInstanceOf(
            \RuntimeException::class,
            $exception,
            'Should catch a RuntimeException when pool is exhausted.'
        );

        foreach ($inUse as $i) {
            $pool->release($i);
        }
        sleep(1);

        $this->assertPoolCounts($cache, $cacheKey, 10, 0, 0);

        $pool->clear();
        sleep(1);
        $this->assertNull($cache->getItem($cacheKey)->get());
        $this->assertFalse($inUse[0]->exists());
    }

    private function assertPoolCounts(CacheItemPoolInterface $cache, $key, $queue, $inUse, $toCreate)
    {
        $item = $cache->getItem($key)->get();
        $this->assertCount($queue, $item['queue'], 'Sessions In Queue');
        $this->assertCount($inUse, $item['inUse'], 'Sessions In Use');
        $this->assertCount($toCreate, $item['toCreate'], 'Sessions To Create');
    }
}
