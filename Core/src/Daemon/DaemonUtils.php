<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Daemon;

/**
 * Class DaemonUtils contains utility functions to support daemons
 * @package Google\Cloud\Core\Daemon
 */
class DaemonUtils
{
    private static $autoloaderCandidates = [
        '/vendor/autoload.php',     // Git clone of subcomponent
        '/../vendor/autoload.php',  // Git clone of google-cloud-php
        '/../../autoload.php',      // Subcomponent installation
        '/../../../autoload.php',   // google/cloud installation
    ];

    /**
     * @param string $subcomponentRoot Path to root of subcomponent for which to locate autoloader
     * @return string Path to autoloader, or null
     */
    public static function locateAutoloader($subcomponentRoot)
    {
        foreach (self::$autoloaderCandidates as $candidate) {
            if (file_exists($subcomponentRoot . $candidate)) {
                return $subcomponentRoot . $candidate;
            }
        }
        return null;
    }
}
