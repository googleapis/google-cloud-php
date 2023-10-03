<?php
/**
 * Copyright 2023 Google LLC
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
 * Manages Packagist API calls
 *
 * @internal
 */
class Packagist
{
    private const WEBHOOK_URL = 'https://packagist.org/api/update-package?username=%s';
    private const CREATE_PACKAGE_ENDPOINT = 'https://packagist.org/api/create-package';

    public function __construct(
        private Client $client,
        private string $username,
        private string $apiToken,
        private ?OutputInterface $output = null
    ) {
    }

    /**
     * Create Packagist package from the GitHub repository.
     *
     * @param string $url The full URL of the GitHub repository.
     * @return bool True if successful, false if failed.
     */
    public function submitPackage(string $url): bool
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

            return $response->getStatusCode() === 202;
        } catch (\Exception $e) {
            $this->logException($e);
            return false;
        }
    }

    public function getWebhookUrl(): string
    {
        return sprintf(self::WEBHOOK_URL, $this->username);
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
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
