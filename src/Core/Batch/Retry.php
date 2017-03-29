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

namespace Google\Cloud\Core\Batch;

/**
 * A class for retrying the failed items.
 */
class Retry
{
    use HandleFailureTrait;

    /* @var BatchRunner */
    private $runner;

    /**
     * Initialize a BatchRunner and $failureFile.
     */
    public function __construct()
    {
        $this->runner = new BatchRunner();
        $this->initFailureFile();
    }

    public function retryAll()
    {
        foreach ($this->getFailedFiles() as $file) {
            $fp = @fopen($file, 'r');
            if ($fp === false) {
                fwrite(
                    STDERR,
                    sprintf('Could not open the file: %s' . PHP_EOL, $file)
                );
                continue;
            }
            while ($line = fgets($fp)) {
                $a = unserialize($line);
                $idNum = key($a);
                $job = $this->runner->getJobFromIdNum($idNum);
                if (! $job->run($a[$idNum])) {
                    $this->handleFailure($idNum, $a[$idNum]);
                }
            }
            @fclose($fp);
            @unlink($file);
        }
    }
}
