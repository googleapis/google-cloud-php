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

/**
 * Manages GitHub API calls for Subtree Split releases.
 *
 * @internal
 */
class Packagist
{
    private const CREATE_PACKAGE_ENDPOINT = 'https://packagist.org/api/create-package';

    public function __construct(
        private Client $client,
        private string $username,
        private string $apiToken
    ) {
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
    public function submitPackage($url)
    {
        $requestBody = [
            'repository' => ['url' => $url],
        ];

        try {
            $response = $this->client->post(self::CREATE_PACKAGE_ENDPOINT, [
                'query' => [
                    'apiToken' => $this->apiToken,
                    'username' => $this->username,
                ],
                'json' => $requestBody,
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            return false;
        }
    }
}
