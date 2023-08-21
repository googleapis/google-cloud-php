<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

use Google\Cloud\Core\Compute\Metadata;

/**
 * A MetadataProvider for Cloud Run.
 */
class CloudRunMetadataProvider implements MetadataProviderInterface
{
    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var string
     */
    private $serviceId;

    /**
     * @var string
     */
    private $revisionId;

    public function __construct(array $env)
    {
        $this->serviceId = isset($env['K_SERVICE'])
            ? $env['K_SERVICE']
            : 'unknown-service';
        $this->revisionId = isset($env['K_REVISION'])
            ? $env['K_REVISION']
            : 'unknown-revision';
        $this->metadata = new Metadata();
    }

    /**
     * not implemented
     * @TODO
     */
    public function monitoredResource()
    {
        return [];
    }

    /**
     * not implemented
     * @TODO
     */
    public function projectId()
    {
        return $this->metadata->getProjectId();
    }

    /**
     * Return the service id.
     * @return string
     */
    public function serviceId()
    {
        return $this->serviceId;
    }

    /**
     * Return the version id.
     * @return string
     */
    public function versionId()
    {
        return $this->revisionId;
    }

    /**
     * not implemented
     * @TODO
     */
    public function labels()
    {
        return [];
    }
}
