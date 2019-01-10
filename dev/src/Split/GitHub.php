<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Dev\Split;

use GuzzleHttp\Client;

/**
 * Manages GitHub API calls for Subtree Split releases.
 *
 * @internal
 */
class GitHub
{
    const GITHUB_RELEASES_ENDPOINT = 'https://api.github.com/repos/%s/releases/tags/%s';
    const GITHUB_RELEASE_CREATE_ENDPOINT = 'https://api.github.com/repos/%s/releases';

    /**
     * @var RunShell
     */
    private $shell;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    public function __construct(RunShell $shell, Client $client, $token)
    {
        $this->shell = $shell;
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * Check if a given tag exists on a given GitHub repository.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @param string $tagName The tag to check.
     * @return bool
     */
    public function doesTagExist($target, $tagName)
    {
        $res = $this->client->get(sprintf(
            self::GITHUB_RELEASES_ENDPOINT,
            $this->cleanTarget($target), $tagName
        ), [
            'http_errors' => false,
            'auth' => [null, $this->token]
        ]);

        return ($res->getStatusCode() === 200);
    }

    /**
     * Create a tag on the given GitHub repository and sends a request to verify.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @param string $tagName The name of the tag to create.
     * @param string $display The tag display name.
     * @param string $notes The tag release notes.
     * @return bool True if successful, false if failed.
     */
    public function createRelease($target, $tagName, $display, $notes)
    {
        $requestBody = [
            'tag_name' => $tagName,
            'name' => $display,
            'body' => $notes
        ];

        $res = $this->client->post(sprintf(
            self::GITHUB_RELEASE_CREATE_ENDPOINT,
            $this->cleanTarget($target)
        ), [
            'http_errors' => false,
            'json' => $requestBody,
            'auth' => [null, $this->token]
        ]);

        return $this->doesTagExist($target, $tagName);
    }

    /**
     * Push a given commit ref to GitHub.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @param string $ref The commit reference.
     * @param string $targetBranch The remote branch to push to. **Defaults to**
     *        `master`.
     * @param bool $force If true, will use `--force` flag. **Defaults to**
     *        `true`.
     * @return array A list containing [(bool) $success, (string) $output].
     */
    public function push($target, $ref, $targetBranch = 'master', $force = true)
    {
        $cmd = 'git push -q ' .
            'https://%s@github.com/%s ' .
            '%s:%s';

        if ($force) {
            $cmd .= ' --force';
        }

        $cmd = sprintf(
            $cmd,
            $this->token,
            $target,
            $ref,
            $targetBranch
        );

        return $this->shell->execute($cmd);
    }

    private function cleanTarget($target)
    {
        return str_replace('.git', '', $target);
    }
}
