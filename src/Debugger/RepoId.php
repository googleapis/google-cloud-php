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
 * A unique identifier for a cloud repo.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\ProjectRepoId;
 * use Google\Cloud\Debugger\RepoId;
 *
 * $repoId = new RepoId(
 *     new ProjectRepoId('project-id', 'repo-name'),
 *     'some-uid'
 * );
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/Debuggee#repoid RepoId model documentation
 * @codingStandardsIgnoreEnd
 */
class RepoId implements \JsonSerializable
{
    /**
     * @var ProjectRepoId A combination of a project ID and a repo name.
     */
    private $projectRepoId;

    /**
     * @var string A server-assigned, globally unique identifier.
     */
    private $uid;

    /**
     * Instantiate a new RepoId
     *
     * @param ProjectRepoId $projectRepoId A combination of a project ID and a
     *        repo name.
     * @param string $uid A server-assigned, globally unique identifier.
     */
    public function __construct(ProjectRepoId $projectRepoId, $uid)
    {
        $this->projectRepoId = $projectRepoId;
        $this->uid = $uid;
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'projectRepoId' => $this->projectRepoId,
            'uid' => $this->uid
        ];
    }
}
