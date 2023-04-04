<?php

/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core;

use Google\Cloud\Core\Timestamp;

/**
 * Helper methods to work on Google\Cloud\Core\Timestamp.
 * @internal
 */
trait TimestampTrait
{
    /**
     * Formats Google\Cloud\Core\Timestamp to api format is present in
     * $args['readTime'] and throws exception if $args['readTime'] is not
     * Google\Cloud\Core\Timestamp
     *
     * @param array $args The $args possibly containing ['readTime'] field.
     * @return array
     * @throws \InvalidArgumentException
     */
    private function formatReadTimeOption($args)
    {
        if (isset($args['readTime'])) {
            if (!($args['readTime'] instanceof Timestamp)) {
                throw new \InvalidArgumentException(sprintf(
                    '`$options.readTime` must be an instance of %s',
                    Timestamp::class
                ));
            }

            $args['readTime'] = $args['readTime']->formatForApi();
        }
        return $args;
    }
}
