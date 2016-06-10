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
use Google\Auth\Credentials\GCECredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Cloud\Compute\Metadata;
use Google\Cloud\Exception\GoogleException;
use GuzzleHttp\Psr7;

trait ClientTrait
{
    /**
     * @var string The project ID created in the Google Developers Console.
     */
    private $projectId;

    /**
     * Fetch and validate the keyfile and set the project ID.
     *
     * @param  array $config
     * @return array
     */
    private function configureAuthentication(array $config)
    {
        $config['keyFile'] = $this->getKeyFile($config);

        $this->projectId = $this->detectProjectId($config);

        return $config;
    }

    /**
     * Get a keyfile.
     *
     * Process:
     * 1. If $config['keyFile'] is set, use that.
     * 2. If $config['keyFilePath'] is set, load the file and use that.
     * 3. If GOOGLE_APPLICATION_CREDENTIALS environment variable is set, load
     *    from that location and use that.
     * 4. If OS-specific well-known-file is set, load from that location and use
     *    that.
     * 5. Exception. :(
     *
     * @param  array $config
     * @return array Key data
     * @throws GoogleException
     */
    private function getKeyFile(array $config = [])
    {
        $config += [
            'keyFile' => null,
            'keyFilePath' => null,
        ];

        if ($config['keyFile']) {
            return $config['keyFile'];
        }

        if ($config['keyFilePath']) {
            if (!file_exists($config['keyFilePath'])) {
                throw new GoogleException('Given keyfile path does not exist');
            }

            $keyFileData = json_decode(file_get_contents($config['keyFilePath']), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new GoogleException('Given keyfile was invalid');
            }

            return $keyFileData;
        }

        return CredentialsLoader::fromEnv()
            ?: CredentialsLoader::fromWellKnownFile();
    }

    /**
     * Detect and return a project ID.
     *
     * Process:
     * 1. If $config['projectId'] is set, use that.
     * 2. If $config['keyFile'] is set, attempt to retrieve a project ID from
     *    that.
     * 3. If code is running on compute engine, try to get the project ID from
     *    the metadata store
     * 4. Throw exception.
     *
     * @param  array $config
     * @return string
     * @throws GoogleException
     */
    private function detectProjectId(array $config)
    {
        $config += [
            'projectId' => null,
            'httpHandler' => null,
        ];

        if ($config['projectId']) {
            return $config['projectId'];
        }

        if (isset($config['keyFile']['project_id'])) {
            return $config['keyFile']['project_id'];
        }

        if (GCECredentials::onGce($config['httpHandler'])) {
            $metadata = new Metadata();
            $projectId = $metadata->getProjectId();
            if ($projectId) {
                return $projectId;
            }
        }

        throw new GoogleException(
            'No project ID was provided, ' .
            'and we were unable to detect a default project ID.'
        );
    }
}
