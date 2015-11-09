<?php

/**
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
namespace Google\Cloud\Compute;

use Google\Cloud\Compute\Metadata\Readers\StreamReader;

/**
 * A library for accessing the GCE metadata.
 *
 * You can get the GCE metadata values very easily like:
 *
 * use Google\Cloud\Compute\Metadata;
 *
 * $metadata = new Metadata();
 * $project_id = $metadata->getProjectId();
 *
 * $val = $metadata->getProjectMetadata($key);
 */
class Metadata
{
    /**
     * The metadata reader.
     */
    private $reader;

    /**
     * The project id.
     */
    private $projectId;

    /**
     * Whether or not running on GCE.
     */
    private $onGCE;

    /**
     * We use StreamReader for the default implementation for fetching the URL.
     */
    public function __construct()
    {
        $this->reader = new StreamReader();
    }

    /**
     * A method to replace the reader implementation.
     */
    public function setReader($reader)
    {
        $this->reader = $reader;
    }

    /**
     * This method retrieves a single metadata value for a given path.
     */
    public function get($path)
    {
        return $this->reader->read($path);
    }

    /**
     * This method detects the project id and returns it.
     */
    public function getProjectId()
    {
        if (! isset($this->projectId)) {
            $this->projectId = $this->reader->read('project/project-id');
        }
        return $this->projectId;
    }

    /**
     * This method detects whether or not running on GCE.
     */
    public function onGCE()
    {
        if (! isset($this->onGCE)) {
            $this->onGCE = $this->reader->onGCE();
        }
        return $this->onGCE;
    }

    /**
     * This method fetches the project custom metadta and returns it.
     */
    public function getProjectMetadata($key)
    {
        $path = 'project/attributes/'.$key;
        return $this->get($path);
    }

    /**
     * This method fetches the instance custom metadta and returns it.
     */
    public function getInstanceMetadata($key)
    {
        $path = 'instance/attributes/'.$key;
        return $this->get($path);
    }
}
