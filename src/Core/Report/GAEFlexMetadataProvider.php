<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Report;

/**
 * An MetadataProvider for GAE Flex.
 */
class GAEFlexMetadataProvider implements MetadataProviderInterface
{
    /** @var array */
    private $data;

    /**
     * Use the environment variables for populate the values.
     */
    public function __construct()
    {
        $projectId = getenv('GCLOUD_PROJECT') ?: 'unknown-projectid';
        $service = getenv('GAE_SERVICE') ?: 'unknown-service';
        $version = getenv('GAE_VERSION') ?: 'unknown-version';
        $this->data =
            [
                'resource' => [
                    'type' => 'gae_app',
                    'labels' => [
                        'project_id' => $projectId,
                        'version_id' => $version,
                        'module_id' => $service
                    ]
                ],
                'projectId' => $projectId,
                'service' => $service,
                'version' => $version
            ];
    }

    /**
     * Return an array representing MonitoredResource.
     * {@see https://cloud.google.com/logging/docs/reference/v2/rest/v2/MonitoredResource}
     *
     * @return array
     */
    public function getMonitoredResource()
    {
        return $this->data['resource'];
    }

    /**
     * Return the project id.
     * @return string
     */
    public function getProjectId()
    {
        return $this->data['projectId'];
    }

    /**
     * Return the service id.
     * @return string
     */
    public function getService()
    {
        return $this->data['service'];
    }

    /**
     * Return the version id.
     * @return string
     */
    public function getVersion()
    {
        return $this->data['version'];
    }
}
