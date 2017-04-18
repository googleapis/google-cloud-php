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
 * auto_prepend_file for Stackdriver Error Reporting. Put this file as
 * `auto_prepend_file` php configuration directive to enable automatic error
 * reporting.
 *
 * @codeCoverageIgnore
 */
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    // when running from a git clone.
    require_once __DIR__ . '/../../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../vendor/autoload.php')) {
    // when running from a project's vendor dir.
    require_once __DIR__ . '/../../../vendor/autoload.php';
}

use Google\Cloud\ErrorReporting\Bootstrap;

Bootstrap::init();
