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

/**
 * This implementation of the SamplerInterface uses a pseudo-random number generator
 * to sample a percentage of requests.
 */
class RandomSampler implements SamplerInterface
{
    /**
     * @var float The percentage of requests to sample represented as a float between 0 and 1.
     */
    private $rate;

    /**
     * Creates the RandomSampler
     *
     * @param float $percentage The percentage of requests to sample. Must be between 0 and 1.
     */
    public function __construct($rate)
    {
        if ($rate > 1 || $rate < 0) {
            throw new \InvalidArgumentException('Percentage must be between 0 and 1');
        }

        $this->rate = $rate;
    }

    /**
     * Uses a pseudo-random number generator to decide if we should sample the request.
     *
     * @return bool
     */
    public function shouldSample()
    {
        return lcg_value() <= $this->rate;
    }

    /**
     * Return the percentage of requests to sample represented as a float between 0 and 1
     *
     * @return float
     */
    public function rate()
    {
        return $this->rate;
    }
}
