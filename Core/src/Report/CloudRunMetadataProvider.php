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

    /**
     * @var string
     */
    private $traceId;

    public function __construct(array $env)
    {
        $this->serviceId = isset($env['K_SERVICE'])
            ? $env['K_SERVICE']
            : 'unknown-service';
        $this->revisionId = isset($env['K_REVISION'])
            ? $env['K_REVISION']
            : 'unknown-revision';
        $this->traceId = isset($env['HTTP_X_CLOUD_TRACE_CONTEXT'])
            ? substr($env['HTTP_X_CLOUD_TRACE_CONTEXT'], 0, 32)
            : null;
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
     * Return the labels. We need to evaluate $_SERVER for each request.
     * @return array
     */
    public function labels()
    {
        return !empty($this->traceId)
            ? ['run.googleapis.com/trace_id' => $this->traceId ]
            : [];
    }
}
