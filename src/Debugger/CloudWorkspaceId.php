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
 * A CloudWorkspaceId is a unique identifier for a cloud workspace. A cloud
 * workspace is a place associated with a repo where modified files can be
 * stored before they are committed.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\CloudWorkspaceId;
 * use Google\Cloud\Debugger\ProjectRepoId;
 * use Google\Cloud\Debugger\RepoId;
 *
 * $workspace = new CloudWorkspaceId(
 *     new RepoId(
 *         new ProjectRepoId('project-id', 'repo-name'),
 *         'some-uid'
 *     ),
 *     'workspace-name'
 * );
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/Debuggee#cloudworkspaceid CloudWorkspaceId model documentation
 * @codingStandardsIgnoreEnd
 */
class CloudWorkspaceId implements \JsonSerializable
{
    /**
     * @var RepoId The ID of the repo containing the workspace.
     */
    private $repoId;

    /**
     * @var string The unique name of the workspace within the repo. This is the
     *      name chosen by the client in the Source API's CreateWorkspace
     *      method.
     */
    private $name;

    /**
     * Instantiate a new CloudWorkspaceId.
     *
     * @param RepoId $repoId The ID of the repo.
     * @param string $name The unique name of the workspace within the repo.
     *        This is the name chosen by the client in the Source API's
     *        CreateWorkspace method.
     */
    public function __construct(RepoId $repoId, $name)
    {
        $this->repoId = $repoId;
        $this->name = $name;
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
            'repoId' => $this->repoId,
            'name' => $this->name
        ];
    }
}
