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
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

/**
 * Manages GitHub API calls for Subtree Split releases.
 *
 * @internal
 */
class GitHub
{
    const GITHUB_REPO_ENDPOINT = 'https://api.github.com/repos/%s';
    const GITHUB_RELEASE_ENDPOINT = self::GITHUB_REPO_ENDPOINT . '/releases/tags/%s';
    const GITHUB_RELEASE_CREATE_ENDPOINT = self::GITHUB_REPO_ENDPOINT . '/releases';

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

    /**
     * @var array[]
     */
    private $targetInfoCache = [];

    public function __construct(RunShell $shell, Client $client, $token)
    {
        $this->shell = $shell;
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * Get the default branch of a repository
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @return string|null
     */
    public function getDefaultBranch($target)
    {
        try {
            $res = $this->getRepo($target);
            return json_decode((string) $res->getBody(), true)['default_branch'];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Check if the repository is empty.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @return bool|null
     */
    public function isTargetEmpty($target)
    {
        try {
            $res = $this->getRepo($target);
            return json_decode((string) $res->getBody(), true)['size'] === 0;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Check if a given tag exists on a given GitHub repository.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @param string $tagName The tag to check.
     * @return bool|null
     */
    public function doesTagExist($target, $tagName)
    {
        try {
            $res = $this->client->get(sprintf(
                self::GITHUB_RELEASE_ENDPOINT,
                $this->cleanTarget($target), $tagName
            ), [
                'auth' => [null, $this->token]
            ]);

            return ($res->getStatusCode() === 200);
        } catch (\Exception $e) {
            return null;
        }
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

        try {
            $res = $this->client->post(sprintf(
                self::GITHUB_RELEASE_CREATE_ENDPOINT,
                $this->cleanTarget($target)
            ), [
                'json' => $requestBody,
                'auth' => [null, $this->token]
            ]);

            return $res->getStatusCode() === 201;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the changelog from a release.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @param string $tagName The name of the tag to fetch from.
     * @return string|null
     */
    public function getChangelog($target, $tagName)
    {
        try {
            $res = $this->client->get(sprintf(
                self::GITHUB_RELEASE_ENDPOINT,
                $target,
                $tagName
            ), [
                'auth' => [null, $this->token]
            ]);

            return json_decode((string) $res->getBody(), true)['body'];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Push a given commit ref to GitHub.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @param string $ref The commit reference.
     * @param string $targetBranch The remote branch to push to. **Defaults to**
     *        `main`.
     * @param bool $initialCommit If true, attempt to create target branch.
     *        **Defaults to** `false`.
     * @return array A list containing [(bool) $success, (string) $output].
     */
    public function push($target, $ref, $targetBranch = 'main', $initialCommit = false)
    {
        $targetRef = $initialCommit
            ? 'refs/heads/' . $targetBranch
            : $targetBranch;

        $cmd = [
            'git push -q',
            sprintf('https://%s@github.com/%s', $this->token, $target),
            sprintf('%s:%s', $ref, $targetRef)
        ];

        if (!$initialCommit) {
            $cmd[] = '--force';
        }

        return $this->shell->execute(implode(' ' , $cmd));
    }

    /**
     * Make sure the target is formatted properly.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @return string
     */
    private function cleanTarget($target)
    {
        return str_replace('.git', '', $target);
    }

    /**
     * Get and cache the repository object from the API
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @return Response
     * @throws GuzzleException
     */
    private function getRepo($target)
    {
        if (isset($this->targetInfoCache[$target])) {
            $res = $this->targetInfoCache[$target];
        } else {
            $res = $this->client->get(sprintf(
                self::GITHUB_REPO_ENDPOINT,
                $this->cleanTarget($target)
            ), [
                'auth' => [null, $this->token]
            ]);

            $this->targetInfoCache[$target] = $res;
        }

        return $res;
    }
}
