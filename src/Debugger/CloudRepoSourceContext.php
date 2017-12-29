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
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\AliasContext;
 * use Google\Cloud\Debugger\CloudRepoSourceContext;
 * use Google\Cloud\Debugger\ProjectRepoId;
 * use Google\Cloud\Debugger\RepoId;
 *
 * $sourceContext = new CloudRepoSourceContext(
 *     new RepoId(
 *         new ProjectRepoId('project-id', 'repo-name'),
 *         'some-uid'
 *     ),
 *     'some-sha-value',
 *     new AliasContext(AliasContext::KIND_FIXED, 'branch-alias')
 * );
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/Debuggee#cloudreposourcecontext CloudRepoSourceContext model documentation
 * @codingStandardsIgnoreEnd
 */
class CloudRepoSourceContext implements SourceContext, \JsonSerializable
{
    /**
     * @var RepoId The ID of the repo.
     */
    private $repoId;

    /**
     * @var string A revision ID.
     */
    private $revisionId;

    /**
     * @var AliasContext An alias, which may be a branch or tag.
     */
    private $aliasContext;

    /**
     * Instantiate a new CloudRepoSourceContext.
     *
     * @param RepoId $repoId The ID of the repo.
     * @param string $revisionId A revision ID.
     * @param AliasContext $aliasContext An alias, which may be a branch or tag.
     */
    public function __construct(RepoId $repoId, $revisionId, AliasContext $aliasContext)
    {
        $this->repoId = $repoId;
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
            'cloudRepo' => [
                'repoId' => $this->repoId,
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
