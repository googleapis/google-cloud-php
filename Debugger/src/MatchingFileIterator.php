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

namespace Google\Cloud\Debugger;

/**
 * This iterator returns files that match the provided file in the provided
 * search path.
 *
 * Example:
 * ```
 * $iterator = new MatchingFileIterator('.', 'Debugger/src/DebuggerClient.php');
 * $matches = iterator_to_array($iterator);
 * ```
 *
 * @access private
 */
class MatchingFileIterator extends \FilterIterator
{
    /**
     * @var string The file pattern to search for.
     */
    private $file;

    /**
     * Create a new MatchingFileIterator.
     *
     * @param string $searchPath The root path to search in
     * @param string $file The file to search for
     */
    public function __construct($searchPath, $file)
    {
        parent::__construct(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    realpath($searchPath),
                    \FilesystemIterator::SKIP_DOTS
                )
            )
        );
        $this->file = $file;
    }

    /**
     * FilterIterator callback to determine whether or not the value should be
     * accepted.
     *
     * @access private
     * @return boolean
     */
    #[\ReturnTypeWillChange]
    public function accept()
    {
        $candidate = $this->getInnerIterator()->current();

        // Check that the candidate file (a full file path) ends in the pattern we are searching for.
        return strrpos($candidate, $this->file) === strlen($candidate) - strlen($this->file);
    }
}
