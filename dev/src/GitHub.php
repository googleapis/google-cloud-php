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

namespace Google\Cloud\Dev;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Console\Output\OutputInterface;

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
    const GITHUB_RELEASE_UPDATE_ENDPOINT = self::GITHUB_REPO_ENDPOINT . '/releases/%s';
    const GITHUB_RELEASE_GET_ENDPOINT = self::GITHUB_REPO_ENDPOINT . '/releases/tags/%s';
    const GITHUB_WEBHOOK_CREATE_ENDPOINT = self::GITHUB_REPO_ENDPOINT . '/hooks';
    private const GITHUB_TEAMS_ENDPOINT = self::GITHUB_REPO_ENDPOINT . '/teams';
    private const GITHUB_TEAMS_ADD_ENDPOINT = 'https://api.github.com/orgs/%s/teams/%s/repos/%s';

    /**
     * @var array[]
     */
    private $targetInfoCache = [];

    public function __construct(
        private RunShell $shell,
        private Client $client,
        public string $token,
        private ?OutputInterface $output = null
    ) {
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
        return $this->getRepoDetails($target)['default_branch'] ?? null;
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
        $res = $this->getRepoDetails($target);

        return is_null($res) ? null : $res['size'] === 0;
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
            if ($e->getCode() === 404) {
                return false;
            }
            $this->logException($e);
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
            $this->logException($e);
            return false;
        }
    }

    /**
     * Create a tag on the given GitHub repository and sends a request to verify.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     * @param string $tagName The name of the tag to create.
     * @param string $notes The tag release notes.
     * @return bool True if successful, false if failed.
     */
    public function updateReleaseNotes($target, $tagName, $notes)
    {
        $requestBody = [
            'body' => $notes
        ];

        $res = $this->client->get(sprintf(
            self::GITHUB_RELEASE_GET_ENDPOINT,
            $this->cleanTarget($target),
            $tagName
        ), [
            'auth' => [null, $this->token]
        ]);

        if ($release = json_decode((string) $res->getBody(), true)) {
            $tagId = $release['id'];
        } else {
            throw new \LogicException('Tag ID not found!');
        }

        try {
            $res = $this->client->post(sprintf(
                self::GITHUB_RELEASE_UPDATE_ENDPOINT,
                $this->cleanTarget($target),
                $tagId
            ), [
                'json' => $requestBody,
                'auth' => [null, $this->token]
            ]);

            return $res->getStatusCode() === 201;
        } catch (\Exception $e) {
            $this->logException($e);
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
            $this->logException($e);
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
     * Get repository details from the GitHub API.
     *
     * @param string $target The GitHub organization and repository ID separated
     *        by a forward slash, i.e. `organization/repository'.
     *
     * @return array|null
     */
    public function getRepoDetails($target)
    {
        try {
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

            return json_decode((string) $res->getBody(), true);
        } catch (\Exception $e) {
            $this->logException($e);
            return null;
        }
    }

    public function getTeams(string $repoName)
    {
        try {
            // get team fields
            $res = $this->client->get(sprintf(
                self::GITHUB_TEAMS_ENDPOINT,
                $this->cleanTarget($repoName)
            ), [
                'auth' => [null, $this->token]
            ]);

            return json_decode((string) $res->getBody(), true);
        } catch (\Exception $e) {
            $this->logException($e);
            return null;
        }
    }

    public function updateRepoDetails(string $repoName, array $settings): bool
    {
        try {
            $res = $this->client->patch(sprintf(
                self::GITHUB_REPO_ENDPOINT,
                $repoName
            ), [
                'auth' => [null, $this->token],
                'body' => json_encode($settings),
            ]);

            return $res->getStatusCode() === 200;
        } catch (\Exception $e) {
            $this->logException($e);
            return false;
        }
    }

    public function updateTeamPermission(
        string $orgName,
        string $teamName,
        string $repoName,
        string $permission
    ): bool {
        try {
            $res = $this->client->put(sprintf(
                self::GITHUB_TEAMS_ADD_ENDPOINT,
                $orgName,
                $teamName,
                $repoName,
            ), [
                'auth' => [null, $this->token],
                'body' => json_encode(['permission' => $permission]),
            ]);
            return $res->getStatusCode() == 204;
        } catch (\Exception $e) {
            $this->logException($e);
            return false;
        }
    }

    /**
     * Add webhook
     */
    public function addWebhook(
        string $target,
        string $webhookUrl,
        string $secret
    ) {
        try {
            $res = $this->client->post(sprintf(
                self::GITHUB_WEBHOOK_CREATE_ENDPOINT,
                $this->cleanTarget($target)
            ), [
                'auth' => [null, $this->token],
                'json' => [
                    'name' => 'web',
                    'active' => true,
                    'events' => ['push'],
                    'config' =>  [
                        'url' => $webhookUrl,
                        'content_type' => 'json',
                        'secret' => $secret,
                        'insecure_ssl' => false,
                    ],
                ],
            ]);

            return $res->getStatusCode() === 201;
        } catch (\Exception $e) {
            $this->logException($e);
            return false;
        }
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
     * Log an exception
     *
     * @param \Exception $e
     */
    private function logException(\Exception $e)
    {
        if ($this->output) {
            $this->output->writeln(sprintf(
                '<error>Exception: %s</error>',
                $e->getMessage()
            ));
        }
    }
}
