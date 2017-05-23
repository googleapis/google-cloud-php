<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\Trace\Sampler;

use Google\Cloud\Trace\Sampler\QpsSampler;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Prophecy\Argument;

/**
 * @group trace
 */
class QpsSamplerTest extends \PHPUnit_Framework_TestCase
{
    public function testCachedValue()
    {
        $item = $this->prophesize(CacheItemInterface::class);
        $item->get()->willReturn(microtime(true) + 100);
        $cache = $this->prophesize(CacheItemPoolInterface::class);
        $cache->getItem(Argument::any())->willReturn($item->reveal());

        $sampler = new QpsSampler($cache->reveal());
        $this->assertFalse($sampler->shouldSample());
    }

    public function testCachedValueExpired()
    {
        $item = $this->prophesize(CacheItemInterface::class);
        $item->get()->willReturn(microtime(true) - 100);
        $cache = $this->prophesize(CacheItemPoolInterface::class);
        $cache->getItem(Argument::any())->willReturn($item->reveal());
        $cache->save(Argument::any())->willReturn(true);

        $sampler = new QpsSampler($cache->reveal());
        $this->assertTrue($sampler->shouldSample());
    }

    public function testNotCached()
    {
        $cache = $this->prophesize(CacheItemPoolInterface::class);
        $cache->getItem(Argument::any())->willReturn(null);
        $cache->save(Argument::any())->willReturn(true);

        $sampler = new QpsSampler($cache->reveal());
        $this->assertTrue($sampler->shouldSample());
    }

    /**
     * @dataProvider invalidRates
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidRate($rate)
    {
        $cache = $this->prophesize(CacheItemPoolInterface::class);
        $sampler = new QpsSampler($cache->reveal(), [
            'rate' => $rate
        ]);
    }

    public function invalidRates()
    {
        return [
            [0],
            [-1],
            [10],
            [1.1]
        ];
    }
}
