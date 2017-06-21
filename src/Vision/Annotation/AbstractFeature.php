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

/**
 * Provide shared functionality for features
 */
abstract class AbstractFeature implements FeatureInterface
{
    /**
     * @var array
     */
    protected $info;

    /**
     * Get the raw annotation result
     *
     * Example:
     * ```
     * $info = $imageProperties->info();
     * ```
     *
     * @return array
     * @access private
     */
    public function info()
    {
        return $this->info;
    }
}
