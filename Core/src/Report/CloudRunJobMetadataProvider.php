<?php
/**
 * Copyright 2024 Google LLC
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
 * A MetadataProvider for Cloud Run Jobs.
 */
class CloudRunJobMetadataProvider implements MetadataProviderInterface
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
    private $taskIndex;

    /**
     * @var string
     */
    private $taskAttempt;

    /**
     * @var string
     */
    private $instanceId;

    /**
     * @var string
     */
    private $traceId;

    /**
     * @var string
     */
    private $region;

    /**
     * @see https://cloud.google.com/run/docs/container-contract#jobs-env-vars
     * @param array $env
     */
    public function __construct(array $env, ?Metadata $metadata = null)
    {
        $this->serviceId = $env['CLOUD_RUN_JOB'] ?? 'unknown-job';
        $this->revisionId = $env['CLOUD_RUN_EXECUTION'] ?? '';
        $this->taskIndex = $env['CLOUD_RUN_TASK_INDEX'] ?? '';
        $this->taskAttempt = $env['CLOUD_RUN_TASK_ATTEMPT'] ?? '';

        $this->traceId = isset($env['HTTP_X_CLOUD_TRACE_CONTEXT'])
            ? \substr($env['HTTP_X_CLOUD_TRACE_CONTEXT'], 0, 32)
            : null;

        $this->metadata = $metadata ?? new Metadata();
        $this->region = \basename($this->metadata->get('instance/region') ?? '');
        $this->instanceId = $this->metadata->get('instance/id');
    }

    /**
     * @return array
     */
    public function monitoredResource()
    {
        return [
            'type' => 'cloud_run_job',
            'labels' => [
                'job_name' => $this->serviceId,
                'location' => $this->region,
                'project_id' => $this->projectId(),
            ],
        ];
    }

    /**
     * Return the project id.
     * @return string
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
     * Return the labels.
     * @return array
     */
    public function labels()
    {
        $labels = [
            'instanceId' => $this->instanceId,
            'run.googleapis.com/execution_name' => $this->revisionId,
            'run.googleapis.com/task_attempt' => $this->taskAttempt,
            'run.googleapis.com/task_index' => $this->taskIndex,
            'run.googleapis.com/trace_id' => $this->traceId,
        ];
        return \array_filter($labels);
    }
}
