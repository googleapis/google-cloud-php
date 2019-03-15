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
 * Install the Splitsh-lite program.
 *
 * @internal
 */
class SplitInstall
{
    const COMPILE_SCRIPT = 'dev/sh/compile-splitsh';

    /**
     * @var RunShell
     */
    private $shell;

    /**
     * @var string
     */
    private $installPath;

    public function __construct(RunShell $shell, $installPath)
    {
        $this->shell = $shell;
        $this->installPath = $installPath;
    }

    /**
     * @param string $rootPath The repository root path.
     * @return array A list containing a status message and the path to splitsh-lite.
     */
    public function installFromSource($rootPath)
    {
        $message = 'Success';
        $location = $this->installPath . '/splitsh-lite';

        if ($this->fileExists($location)) {
            $message = 'Already Installed';
        } else {
            $res = $this->shell->execute(sprintf(
                '%s %s',
                $rootPath . '/' . self::COMPILE_SCRIPT,
                $this->installPath
            ));

            if (!$res[0]) {
                throw new \RuntimeException(
                    'Splitsh compile failed with output: ' . implode(PHP_EOL, $res[1])
                );
            }
        }

        return [$message, $location];
    }

    /**
     * Abstracted for testing.
     */
    protected function fileExists($file)
    {
        return file_exists($file);
    }
}
