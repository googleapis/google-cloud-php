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
 * A SourceContext referring to a Gerrit project.
 */
class GerritSourceContext implements SourceContext, \JsonSerializable
{
    /**
     * @var string
     */
    private $hostUri;

    /**
     * @var string
     */
    private $gerritProject;

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
     * Instantiate a new GerritSourceContext.
     *
     * @param string $hostUri The URI of a running Gerrit instance.
     * @param string $gerritProject The full project name within the host.
     *        Projects may be nested, so "project/subproject" is a valid project
     *        name. The "repo name" is hostURI/project.
     * @param string $revisionId A revision (commit) ID.
     * @param string $aliasName The name of an alias (branch, tag, etc.).
     * @param AliasContext $aliasContext An alias, which may be a branch or tag.
     */
    public function __construct(
        $hostUri,
        $gerritProject,
        $revisionId,
        $aliasName,
        AliasContext $aliasContext
    ) {
        $this->hostUri = $hostUri;
        $this->gerritProject = $gerritProject;
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
            'gerrit' => [
                'hostUri' => $this->hostUri,
                'gerritProject' => $this->gerritProject,
                'revisionId' => $this->revisionId,
                'aliasName' => $this->aliasName,
                'aliasContext' => $this->aliasContext
            ]
        ];
    }
}
