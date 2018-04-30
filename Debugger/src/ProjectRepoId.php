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

namespace Google\Cloud\Debugger;

/**
 * Selects a repo using a Google Cloud Platform project ID
 * (e.g. winged-cargo-31) and a repo name within that project.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\ProjectRepoId;
 *
 * $repoId = new ProjectRepoId(
 *     'project-id',
 *     'repo-name'
 * );
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/Debuggee#projectrepoid ProjectRepoId model documentation
 * @codingStandardsIgnoreEnd
 */
class ProjectRepoId
{
    /**
     * @var string The ID of the project.
     */
    private $projectId;

    /**
     * @var string The name of the repo. Leave empty for the default repo.
     */
    private $repoName;

    /**
     * Instantiate a new ProjectRepoId
     *
     * @param string $projectId The ID of the project.
     * @param string $repoName The name of the repo. Leave empty for the default
     *        repo.
     */
    public function __construct($projectId, $repoName = null)
    {
        $this->projectId = $projectId;
        $this->repoName = $repoName;
    }

    /**
     * Return a serializable version of this object
     *
     * @access private
     * @return array
     */
    public function info()
    {
        return [
            'projectId' => $this->projectId,
            'repoName' => $this->repoName
        ];
    }
}
