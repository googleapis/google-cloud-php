<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Trace\Sampler;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * The SamplerFactory builds SamplerInterface instances given a variety of
 * configuration options.
 */
class SamplerFactory
{
    /**
     * Builds a sampler given the provided configuration options.
     *
     * @param array $options {
     *     Configuration options.
     *
     *     @type string $type Which type of sampler to build. May be one of:
     *           `"qps"`, `"random"`, `"enabled"`, `"disabled"`. **Defaults to**
     *           `"qps"`.
     *     @type float $rate The sampling rate for query per second and random sampling.
     *           **Defaults to** `0.1`.
     *     @type CacheItemPoolInterface $cache The PSR-6 cache implementation to use for query
     *           per second sampling.
     *     @type string $cacheItemClass The name of the CacheItemInterface class to use for
     *           query per second sampling.
     *     @type string $cacheKey The name of the cache key to use for query per second sampling.
     * }
     * @return SamplerInterface
     */
    public static function build($options)
    {
        $options += [
            'type' => 'enabled',
            'rate' => 0.1,
            'cache' => null
        ];

        switch ($options['type']) {
            case 'qps':
                return new QpsSampler(
                    $options['cache'],
                    $options
                );
            case 'random':
                return new RandomSampler($options['rate']);
            case 'enabled':
                return new AlwaysOnSampler();
            case 'disabled':
            default:
                return new AlwaysOffSampler();
        }
    }
}
