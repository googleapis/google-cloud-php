<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\FetchAuthTokenInterface;

/**
 * Encapsulates shared functionality of request wrappers.
 */
trait RequestWrapperTrait
{
    /**
     * @var FetchAuthTokenInterface Fetches credentials.
     */
    private $credentialsFetcher;

    /**
     * @var array The contents of the service account credentials .json file
     * retrieved from the Google Developers Console.
     */
    private $keyFile;

    /**
     * @var int Number of retries for a failed request. **Defaults to** `3`.
     */
    private $retries;

    /**
     * @var array Scopes to be used for the request.
     */
    private $scopes = [];

    /**
     * Sets common defaults between request wrappers.
     *
     * @param array $config {
     *     Configuration options.
     *
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     * }
     * @throws \InvalidArgumentException
     */
    public function setCommonDefaults(array $config)
    {
        $config += [
            'credentialsFetcher' => null,
            'keyFile' => null,
            'retries' => null,
            'scopes' => null
        ];

        if ($config['credentialsFetcher'] && !$config['credentialsFetcher'] instanceof FetchAuthTokenInterface) {
            throw new \InvalidArgumentException('credentialsFetcher must implement FetchAuthTokenInterface.');
        }

        $this->credentialsFetcher = $config['credentialsFetcher'];
        $this->retries = $config['retries'];
        $this->scopes = $config['scopes'];
        $this->keyFile = $config['keyFile'];
    }

    /**
     * Gets the credentials fetcher. Precedence begins with user supplied
     * credentials fetcher instance, followed by a reference to a key file
     * stream, and finally the application default credentials.
     *
     * @return FetchAuthTokenInterface
     */
    public function getCredentialsFetcher()
    {
        if ($this->credentialsFetcher) {
            return $this->credentialsFetcher;
        }

        if ($this->keyFile) {
            return CredentialsLoader::makeCredentials($this->scopes, $this->keyFile);
        }

        return ApplicationDefaultCredentials::getCredentials($this->scopes, $this->authHttpHandler);
    }
}
