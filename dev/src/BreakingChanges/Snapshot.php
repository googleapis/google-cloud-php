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

use Symfony\Component\Filesystem\Filesystem;

/**
 * A throwaway git repository holding two commits of a single component: the
 * component at a baseline git ref, and the component as it exists in the
 * working copy.
 *
 * @internal
 */
class Snapshot
{
    public function __construct(
        private string $componentName,
        private string $workTree,
        private string $scratchDir,
        private Filesystem $filesystem
    ) {
    }

    public function getComponentName(): string
    {
        return $this->componentName;
    }

    /**
     * The directory to run the backwards compatibility check in. The component
     * files sit at its root, matching the layout the component is published
     * with, and its ".git" directory holds the two commits to compare.
     */
    public function getWorkTree(): string
    {
        return $this->workTree;
    }

    public function remove(): void
    {
        $this->filesystem->remove($this->scratchDir);
    }
}
