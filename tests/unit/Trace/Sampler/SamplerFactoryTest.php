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

use Google\Cloud\Trace\Sampler\SamplerFactory;
use Google\Cloud\Trace\Sampler\SamplerInterface;
use Google\Cloud\Trace\Sampler\AlwaysOnSampler;
use Google\Cloud\Trace\Sampler\QpsSampler;
use Google\Cloud\Trace\Sampler\RandomSampler;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @group trace
 */
class SamplerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultEnabled()
    {
        $sampler = SamplerFactory::build([]);

        $this->assertTrue($sampler->shouldSample());
        $this->assertInstanceOf(AlwaysOnSampler::class, $sampler);
    }

    public function testBuildQps()
    {
        $cache = $this->prophesize(CacheItemPoolInterface::class);

        $sampler = SamplerFactory::build([
            'type' => 'qps',
            'rate' => 0.2,
            'cache' => $cache->reveal()
        ]);
        $this->assertInstanceOf(QpsSampler::class, $sampler);
        $this->assertEquals(0.2, $sampler->rate());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testQpsRequiresCache()
    {
        SamplerFactory::build([
            'type' => 'qps'
        ]);
    }

    public function testQpsDefaultRate()
    {
        $cache = $this->prophesize(CacheItemPoolInterface::class);

        $sampler = SamplerFactory::build([
            'type' => 'qps',
            'cache' => $cache->reveal()
        ]);
        $this->assertInstanceOf(QpsSampler::class, $sampler);
        $this->assertEquals(0.1, $sampler->rate());
    }

    public function testBuildRandom()
    {
        $sampler = SamplerFactory::build([
            'type' => 'random',
            'rate' => 0.2
        ]);
        $this->assertInstanceOf(RandomSampler::class, $sampler);
        $this->assertEquals(0.2, $sampler->rate());
    }

    public function testRandomDefaultRate()
    {
        $sampler = SamplerFactory::build([
            'type' => 'random'
        ]);
        $this->assertInstanceOf(RandomSampler::class, $sampler);
        $this->assertEquals(0.1, $sampler->rate());
    }

}
