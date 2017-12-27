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
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\AliasContext;
 * use Google\Cloud\Debugger\GerritSourceContext;
 *
 * $sourceContext = new GerritSourceContext(
 *     'host-uri',
 *     'gerrit-project',
 *     'revision-id',
 *     new AliasContext(AliasContext::KIND_FIXED, 'branch-alias')
 * );
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/Debuggee#gerritsourcecontext GerritSourceContext model documentation
 * @codingStandardsIgnoreEnd
 */
class GerritSourceContext implements SourceContext, \JsonSerializable
{
    /**
     * @var string The URI of a running Gerrit instance.
     */
    private $hostUri;

    /**
     * @var string The full project name within the host. Projects may be
     *      nested, so "project/subproject" is a valid project name. The
     *      "repo name" is hostURI/project.
     */
    private $gerritProject;

    /**
     * @var string A revision (commit) ID.
     */
    private $revisionId;

    /**
     * @var AliasContext An alias, which may be a branch or tag.
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
     * @param AliasContext $aliasContext An alias, which may be a branch or tag.
     */
    public function __construct(
        $hostUri,
        $gerritProject,
        $revisionId,
        AliasContext $aliasContext
    ) {
        $this->hostUri = $hostUri;
        $this->gerritProject = $gerritProject;
        $this->revisionId = $revisionId;
        $this->aliasContext = $aliasContext;
    }

    /**
     * Return context data.
     *
     * @return array
     */
    public function contextData()
    {
        return [
            'gerrit' => [
                'hostUri' => $this->hostUri,
                'gerritProject' => $this->gerritProject,
                'revisionId' => $this->revisionId,
                'aliasContext' => $this->aliasContext
            ]
        ];
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->contextData();
    }
}
