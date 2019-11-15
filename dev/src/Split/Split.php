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
 * Execute Subtree Split
 *
 * @internal
 */
class Split
{
    /**
     * @var RunShell
     */
    private $shell;

    public function __construct(RunShell $shell)
    {
        $this->shell = $shell;
    }

    /**
     * @param string $binaryPath The path to the splitsh-lite binary.
     * @param string $rootPath The path to the root of the repository.
     * @param string $folderToSplit The name of the folder to split, relative to
     *      `$rootPath`.
     * @return string|null The sha identifier, or null if failure.
    */
    public function execute($binaryPath, $rootPath, $folderToSplit)
    {
        $cmd = \sprintf(
            'SPLIT_SHA=`%s --prefix=%s --path=%s`; echo $SPLIT_SHA;',
            $binaryPath,
            $folderToSplit,
            \realpath($rootPath)
        );

        $res = $this->shell->execute($cmd);

        if (!$res[0]) {
            return null;
        }

        return $res[1][0];
    }
}
