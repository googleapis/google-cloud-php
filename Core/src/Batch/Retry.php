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
 *
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
class Retry
{
    use HandleFailureTrait;

    /* @var BatchRunner */
    private $runner;

    /**
     * Initialize a BatchRunner and $failureFile.
     *
     * @param BatchRunner $runner [optional] **Defaults to** a new BatchRunner.
     */
    public function __construct(BatchRunner $runner = null)
    {
        $this->runner = $runner ?: new BatchRunner();
        $this->initFailureFile();
    }

    /**
     * Retry all the failed items.
     */
    public function retryAll()
    {
        foreach ($this->getFailedFiles() as $file) {
            // Rename the file first
            $tmpFile = dirname($file) . '/retrying-' . basename($file);
            rename($file, $tmpFile);

            $fp = @fopen($tmpFile, 'r');
            if ($fp === false) {
                fwrite(
                    STDERR,
                    sprintf('Could not open the file: %s' . PHP_EOL, $tmpFile)
                );
                continue;
            }
            while ($line = fgets($fp)) {
                $jsonDecodedValue = json_decode($line);
                // Check if data json_encoded after serialization
                if ($jsonDecodedValue !== null || $jsonDecodedValue !== false) {
                    $line = $jsonDecodedValue;
                }
                $a = unserialize($line);
                $idNum = key($a);
                $job = $this->runner->getJobFromIdNum($idNum);
                if (! $job->callFunc($a[$idNum])) {
                    $this->handleFailure($idNum, $a[$idNum]);
                }
            }
            @fclose($fp);
            @unlink($tmpFile);
        }
    }
}
