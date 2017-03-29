<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\System\Core\Batch;

class MyJob
{
    private $commandFile;
    private $targetFile;

    public function __construct($commandFile, $targetFile)
    {
        $this->commandFile = $commandFile;
        $this->targetFile = $targetFile;
    }

    /**
     * A method that we use for the test. It will return false when
     * the command file contains 'fail'.
     */
    public function runJob($items)
    {
        $failCommand = @file_get_contents($this->commandFile);
        if ($failCommand === 'fail') {
            return false;
        }
        $fp = fopen($this->targetFile, 'w+');
        if (flock($fp, LOCK_EX)) {
            foreach ($items as $item) {
                fwrite($fp, strtoupper($item) . PHP_EOL);
            }
        } else {
            echo 'Could not get the lock';
            @fclose($fp);
            return false;
        }
        fclose($fp);
        return true;
    }
}
