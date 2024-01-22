<?php
/**
 * Copyright 2024 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core;

use Google\Auth\CredentialsLoader;
use Google\Auth\Credentials\GCECredentials;
use Google\Cloud\Core\Compute\Metadata;
use Google\Cloud\Core\Exception\GoogleException;

/**
 * Provides functionality common to new service clients.
 */
trait NewClientTrait
{
    use JsonTrait;

    /**
     * @var string|null The project ID created in the Google Developers Console.
     */
    private $projectId;

    /**
     * Fetch and validate the keyfile and set the project ID.
     *
     * @param  array $config
     * @return array
     * @throws GoogleException
     */
    private function configureAuthentication(array $config)
    {
        $config['credentials'] = $this->getKeyFile($config);
        $this->projectId = $this->detectProjectId($config);

        return $config;
    }

    /**
     * Get a keyfile if it exists.
     *
     * Process:
     * 1. If $config['credentials'] is set and an array, use that.
     * 2. If $config['credentials'] is set, and a string load the file and use that.
     * 3. If GOOGLE_APPLICATION_CREDENTIALS environment variable is set, load
     *    from that location and use that.
     * 4. If OS-specific well-known-file is set, load from that location and use
     *    that.
     *
     * @param  array  $config
     * @return array|null Key data
     * @throws GoogleException
     */
    private function getKeyFile(array $config = [])
    {
        $config += [
            'credentials' => null,
        ];

        if (is_array($config['credentials'])) {
            return $config['credentials'];
        }

        if (is_string($config['credentials'])) {
            if (!file_exists($config['credentials'])) {
                throw new GoogleException(sprintf(
                    'Given keyfile path %s does not exist',
                    $config['credentials']
                ));
            }

            try {
                return $this->jsonDecode(file_get_contents($config['credentials']), true);
            } catch (\InvalidArgumentException $ex) {
                throw new GoogleException(sprintf(
                    'Given keyfile at path %s was invalid',
                    $config['credentials']
                ));
            }
        }

        return CredentialsLoader::fromEnv()
            ?: CredentialsLoader::fromWellKnownFile();
    }

    /**
     * Detect and return a project ID.
     *
     * Process:
     * 1. If $config['projectId'] is set, use that.
     * 2. If an emulator is enabled, return a dummy value.
     * 3. If $config['keyFile'] is set, attempt to retrieve a project ID from
     *    that.
     * 4. Check `GOOGLE_CLOUD_PROJECT` environment variable.
     * 5. Check `GCLOUD_PROJECT` environment variable.
     * 6. If code is running on compute engine, try to get the project ID from
     *    the metadata store.
     * 7. Throw exception.
     *
     * @param  array $config
     * @return string
     * @throws GoogleException
     */
    private function detectProjectId(array $config)
    {
        $config += [
            'httpHandler' => null,
            'projectId' => null,
            'projectIdRequired' => false,
            'preferNumericProjectId' => false,
        ];

        if ($config['projectId']) {
            return $config['projectId'];
        }

        if ($config['hasEmulator']) {
            return 'emulator-project';
        }

        if (isset($config['credentials'])) {
            if (isset($config['credentials']['project_id'])) {
                return $config['credentials']['project_id'];
            }
        }

        if (getenv('GOOGLE_CLOUD_PROJECT')) {
            return getenv('GOOGLE_CLOUD_PROJECT');
        }

        if (getenv('GCLOUD_PROJECT')) {
            return getenv('GCLOUD_PROJECT');
        }

        if ($this->onGce($config['httpHandler'])) {
            $metadata = $this->getMetaData();
            $projectId = $config['preferNumericProjectId']
                ? $metadata->getNumericProjectId()
                : $metadata->getProjectId();
            if ($projectId) {
                return $projectId;
            }
        }

        if ($config['projectIdRequired']) {
            throw new GoogleException(
                'No project ID was provided, ' .
                'and we were unable to detect a default project ID.'
            );
        }

        return '';
    }

    /**
     * Abstract the GCECredentials call so we can mock it in the unit tests!
     *
     * @codeCoverageIgnore
     * @return bool
     */
    protected function onGce($httpHandler)
    {
        return GCECredentials::onGce($httpHandler);
    }

    /**
     * Abstract the Metadata instantiation for unit testing
     *
     * @codeCoverageIgnore
     * @return Metadata
     */
    protected function getMetaData()
    {
        return new Metadata;
    }
}
