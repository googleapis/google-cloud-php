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
 * A CloudRepoSourceContext denotes a particular revision in a cloud repo (a
 * repo hosted by the Google Cloud Platform).
 */
class CloudRepoSourceContext implements SourceContext
{
    /**
     * @var RepoId
     */
    private $repoId;

    /**
     * @var string
     */
    private $revisionId;

    /**
     * @var string
     */
    private $aliasName;

    /**
     * @var AliasContext
     */
    private $aliasContext;

    /**
     * Instantiate a new CloudRepoSourceContext.
     *
     * @param RepoId $repoId The ID of the repo.
     * @param string $revisionId A revision ID.
     * @param string $aliasName [Deprecated] The name of an alias (branch, tag, etc.).
     * @param AliasContext $aliasContext An alias, which may be a branch or tag.
     */
    public function __construct($repoId, $revisionId, $aliasName, $aliasContext)
    {
        $this->repoId = $repoId;
        $this->revisionId = $revisionId;
        $this->aliasName = $aliasName;
        $this->aliasContext = $aliasContext;
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'cloudRepo' => [
                'repoId' => $this->repoId,
                'revisionId' => $this->revisionId,
                'aliasName' => $this->aliasName,
                'aliasContext' => $this->aliasContext
            ]
        ];
    }
}
