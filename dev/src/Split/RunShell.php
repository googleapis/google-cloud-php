<?php
/**
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Dev\Split;

/**
 * Execute Shell commands and return the results.
 *
 * Allows for unit testing of calls to exec.
 *
 * @internal
 */
class RunShell
{
    /**
     * @param string $command
     * @return array [(bool) $succeeded, (string) $shellOutput, (int) $exitCode]
     */
    public function execute($command)
    {
        exec($command, $shellOutput, $exitCode);

        return [$exitCode == 0, $shellOutput, $exitCode];
    }
}
