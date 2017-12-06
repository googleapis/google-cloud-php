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
 * A CloudWorkspaceSourceContext denotes a workspace at a particular snapshot.
 */
class CloudWorkspaceSourceContext implements \JsonSerializable
{
    /**
     * @var CloudWorkspaceId The ID of the workspace.
     */
    private $workspaceId;

    /**
     * @var string The ID of the snapshot. An empty snapshotId refers to the
     *      most recent snapshot.
     */
    private $snapshotId;

    /**
     * Instantiate a new CloudWorkspaceSourceContext.
     *
     * @param CloudWorkspaceId $workspaceId The ID of the workspace.
     * @param string $snapshotId The ID of the snapshot. An empty snapshotId
     *        refers to the most recent snapshot.
     */
    public function __construct($workspaceId, $snapshotId)
    {
        $this->workspaceId = $workspaceId;
        $this->snapshotId = $snapshotId;
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'cloudWorkspace' => [
                'workspaceId' => $this->workspaceId,
                'snapshotId' => $this->snapshotId
            ]
        ];
    }
}
