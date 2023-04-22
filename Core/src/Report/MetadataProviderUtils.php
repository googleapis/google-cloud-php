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

namespace Google\Cloud\Core\Report;

/**
 * Utility class for MetadataProvider.
 */
class MetadataProviderUtils
{
    /**
     * Automatically choose the most appropriate MetadataProvider and return it.
     *
     * @param array $server Normally pass the $_SERVER.
     * @return MetadataProviderInterface
     */
    public static function autoSelect($server)
    {
        if (isset($server['GAE_SERVICE'])) {
            if (isset($server['GAE_ENV']) && $server['GAE_ENV'] === 'standard') {
                return new GAEStandardMetadataProvider($server);
            }
            return new GAEFlexMetadataProvider($server);
        }
        if (!empty(getenv('K_CONFIGURATION'))) {
            return new CloudRunMetadataProvider(getenv());
        }
        return new EmptyMetadataProvider();
    }
}
