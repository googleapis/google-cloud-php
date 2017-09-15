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

namespace Google\Cloud\ErrorReporting;

/**
 * This class has been moved to src/Logging/prepend.php
 */
if (file_exists(__DIR__ . '/../Logging/prepend.php')) {
    // when running from a git clone.
    require_once __DIR__ . '/../Logging/prepend.php';
} elseif (file_exists(__DIR__ . '/../cloud-logging/prepend.php')) {
    // when running from google/cloud-error-reporting installation.
    require_once __DIR__ . '/../cloud-logging/prepend.php';
}

throw new \Exception('This file is deprecated, run "composer require '
    . '"google/cloud-logging" and use "vendor/google/cloud-logging/prepend.php"'
    . 'instead.');
