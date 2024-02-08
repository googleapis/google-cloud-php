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

use Google\Auth\ProjectIdProviderInterface;
use Google\Cloud\Core\Exception\GoogleException;

/**
 * @internal
 * Provides functionality common to handwritten clients.
 */
trait DetectProjectIdTrait
{

    /**
     * @var string|null The project ID created in the Google Developers Console.
     */
    private $projectId;

    /**
     * Detect and return a project ID.
     * This is different from detectProjectId as this method is supposed to be used by
     * handwritten clients delegating their auth process to GAX.
     *
     * Process:
     * 1. If $config['projectId'] is set, use that.
     * 2. If an emulator is enabled, return a dummy value.
     * 3. If $config['credentials'] is set, attempt to retrieve a project ID from
     *    that.
     * 4. If code is running on compute engine, try to get the project ID from
     *    the metadata store.
     * 5. Throw exception.
     *
     * @param  array $config
     * @return string|int|null
     * @throws GoogleException
     */
    private function detectProjectId(array $config)
    {
        $config += [
            'httpHandler' => null,
            'projectId' => null,
            'projectIdRequired' => false,
            'hasEmulator' => false,
            'credentials' => null,
        ];

        if ($config['projectId']) {
            return $config['projectId'];
        }

        if ($config['hasEmulator']) {
            return 'emulator-project';
        }

        if ($config['credentials']
            && $config['credentials'] instanceof ProjectIdProviderInterface
            && $projectId = $config['credentials']->getProjectId()) {
                return $projectId;
        }

        if (getenv('GOOGLE_CLOUD_PROJECT')) {
            return getenv('GOOGLE_CLOUD_PROJECT');
        }

        if (getenv('GCLOUD_PROJECT')) {
            return getenv('GCLOUD_PROJECT');
        }

        $this->throwExceptionIfProjectIdRequired($config);

        return '';
    }

    /**
     * Throws an exception if project id is required.
     * @param array $config
     * @throws GoogleException
     */
    private function throwExceptionIfProjectIdRequired(array $config)
    {
        if ($config['projectIdRequired']) {
            throw new GoogleException(
                'No project ID was provided, ' .
                'and we were unable to detect a default project ID.'
            );
        }
    }
}
