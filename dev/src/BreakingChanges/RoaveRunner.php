<?php
/**
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\Dev\BreakingChanges;

use RuntimeException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Runs Roave's backwards compatibility check over a prepared snapshot.
 *
 * @see https://github.com/Roave/BackwardCompatibilityCheck
 * @internal
 */
class RoaveRunner
{
    public const BINARY = 'roave-backward-compatibility-check';

    public function __construct(private ?string $binary = null)
    {
    }

    /**
     * Compare the snapshot's two commits.
     *
     * A non-zero exit code means breaking changes were found, which is an
     * expected outcome rather than an error, so the status is returned instead
     * of thrown.
     *
     * @return array{hasBreakingChanges: bool, output: string}
     */
    public function run(Snapshot $snapshot, string $format): array
    {
        $process = new Process(
            [$this->getBinary(), '--from=HEAD~1', '--format=' . $format],
            $snapshot->getWorkTree()
        );
        $process->setTimeout(600);
        $process->run();

        return [
            'hasBreakingChanges' => 0 !== $process->getExitCode(),
            'output' => $process->getOutput() . $process->getErrorOutput(),
        ];
    }

    private function getBinary(): string
    {
        if ($this->binary) {
            return $this->binary;
        }

        $default = getenv('HOME') . '/.composer/vendor/bin/' . self::BINARY;
        $this->binary = (new ExecutableFinder())->find(self::BINARY, $default);

        if (!is_executable($this->binary)) {
            throw new RuntimeException(sprintf(
                '"%s" not found. Install it with: composer global require roave/backward-compatibility-check',
                self::BINARY
            ));
        }

        return $this->binary;
    }
}
