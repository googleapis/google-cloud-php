<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Vision\Annotation;

use InvalidArgumentException;

/**
 * Provide likelihood functionality to annotation features.
 * @deprecated This trait is no longer supported and will be removed in a future
 * release.
 */
trait LikelihoodTrait
{
    /**
     * @var array
     */
    private $likelihoodLevels = [
        FeatureInterface::STRENGTH_HIGH => [
            'VERY_LIKELY'
        ],
        FeatureInterface::STRENGTH_MEDIUM => [
            'VERY_LIKELY',
            'LIKELY'
        ],
        FeatureInterface::STRENGTH_LOW => [
            'VERY_LIKELY',
            'LIKELY',
            'POSSIBLE'
        ]
    ];

    /**
     * @param  string $value The value name
     * @param  string $strength The strength to test with
     * @return bool
     */
    private function likelihood($value, $strength)
    {
        if (!array_key_exists($strength, $this->likelihoodLevels)) {
            throw new InvalidArgumentException(sprintf(
                'Given strength %s is not a valid value',
                $strength
            ));
        }

        $levels = $this->likelihoodLevels[$strength];

        return in_array($value, $levels);
    }
}
