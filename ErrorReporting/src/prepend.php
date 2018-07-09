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
 * ```
 * auto_prepend_file = '/app/vendor/google/cloud-error-reporting/src/prepend.php'
 * ```
 *
 * @codingStandardsIgnoreFile
 */
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    // when running from a git clone.
    require_once __DIR__ . '/../../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../../vendor/autoload.php')) {
    // when running from google/cloud-error-reporting installation.
    require_once __DIR__ . '/../../../../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../../../vendor/autoload.php')) {
    // when running from google/cloud installation.
    require_once __DIR__ . '/../../../../../vendor/autoload.php';
}

/**
 * Return a user specified PsrBatchLogger.
 *
 * Put a file named 'ErrorReportingBootstrap' in the project directory which
 * returns a PsrLogger object.
 *
 * @return \Google\Cloud\Logging\PsrLogger
 */
function getPsrBatchLogger()
{
    $bootstrapFile = 'ErrorReportingBootstrap';
    if (file_exists(__DIR__ . '/../../' . $bootstrapFile)) {
        // when running from a git clone
        return include __DIR__ . '/../../' . $bootstrapFile;
    }
    if (file_exists(__DIR__ . '/../../../../' . $bootstrapFile)) {
        // when running from a google/cloud-error-reporting installation.
        return include __DIR__ . '/../../../../' . $bootstrapFile;
    }
    if (file_exists(__DIR__ . '/../../../../../' . $bootstrapFile)) {
        // when running from google/cloud installation.
        return include __DIR__ . '/../../../../../' . $bootstrapFile;
    }
    return null;
}

Bootstrap::init(getPsrBatchLogger());
