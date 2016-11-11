<?php
/*
 * Copyright 2015 Google Inc.
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

namespace Google\Cloud;

use Google\Auth\Credentials\AppIdentityCredentials;
use Google\Auth\Credentials\GCECredentials;
use Google\Auth\CredentialsLoader;
use Google\Cloud\AppEngine\AppIdentity;
use Google\Cloud\Compute\Metadata;

/**
 * DetectProjectTrait contains the behaviour used to locate and find the
 * default project
 */
trait DetectProjectTrait
{
    /**
     * Return a project ID from the GCLOUD_PROJECT environment variable
     * This is available in App Engine Flexible.
     *
     * @return string|null $projectId
     */
    protected function projectFromEnvVar()
    {
        return getenv($this->getEnvVar());
    }

    /**
     * Return a project ID from App Engine.
     *
     * @return string|null $projectId
     */
    private function projectFromAppEngine()
    {
        if ($this->onAppEngine()) {
            $appIdentity = $this->getAppIdentity();
            $projectId = $appIdentity->getApplicationId();
            if ($projectId) {
                return $projectId;
            }
        }
    }

    /**
     * Return a project ID from GCE.
     *
     * @return string|null $projectId
     */
    private function projectFromGce($httpHandler = null)
    {
        if ($this->onGce($httpHandler)) {
            $metadata = $this->getMetaData();
            $projectId = $metadata->getProjectId();
            if ($projectId) {
                return $projectId;
            }
        }
    }

    /**
     * The gcloud config path is OS dependent:
     * - windows: %APPDATA%/gcloud/configurations/config_default
     * - others: $HOME/.config/gcloud/configurations/config_default
     *
     * If the file does not exists, this returns null.
     *
     * @return string|null $projectId
     */
    private function projectFromGcloudConfig()
    {
        $path = $this->pathToGcloudConfig();
        if (!file_exists($path)) {
            return;
        }
        $configDefault = parse_ini_file($path, true);
        if (isset($configDefault['core']['project'])) {
            return $configDefault['core']['project'];
        }
    }

    /**
     * Determine the path to the gcloud configuration path
     *
     * @codeCoverageIgnore
     * @return bool
     */
    protected function pathToGcloudConfig()
    {
        if ($this->onWindows()) {
            $path = [getenv('APPDATA')];
        } else {
            $path = [
                getenv('HOME'),
                CredentialsLoader::NON_WINDOWS_WELL_KNOWN_PATH_BASE
            ];
        }
        $path[] = 'gcloud/configurations/config_default';
        return implode(DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Abstract the CredentialsLoader call so we can mock it in the unit tests!
     *
     * @codeCoverageIgnore
     * @return bool
     */
    protected function onWindows()
    {
        return CredentialsLoader::isOnWindows();
    }

    /**
     * Abstract the AppIdentity call so we can mock it in the unit tests!
     *
     * @codeCoverageIgnore
     * @return bool
     */
    protected function onAppEngine()
    {
        return AppIdentityCredentials::onAppEngine() &&
            !GCECredentials::onAppEngineFlexible();
    }

    /**
     * Abstract the AppIdentity instantiation for unit testing
     *
     * @codeCoverageIgnore
     * @return Metadata
     */
    protected function getAppIdentity()
    {
        return new AppIdentity;
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

    /**
     * Abstract the Environment Variable name for unit testing
     *
     * @codeCoverageIgnore
     * @return string
     */
    protected function getEnvVar()
    {
        return 'GCLOUD_PROJECT';
    }
}
