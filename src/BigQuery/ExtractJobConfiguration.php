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

namespace Google\Cloud\BigQuery;

class ExtractJobConfiguration
{
    use JobConfigurationTrait;

    /**
     * @param string $projectId The project's ID.
     * @param array $config A set of configuration options for a job.
     */
    public function __construct($projectId, array $config)
    {
        $this->jobConfigurationProperties($projectId, $config);
    }

    /**
     * @param string $compression
     * @return LoadJobConfiguration
     */
    public function compression($compression)
    {
        $this->config['configuration']['extract']['compression'] = $compression;

        return $this;
    }

    /**
     * @param string|resource|StreamInterface $data
     * @return LoadJobConfiguration
     */
    public function data($data)
    {
        $this->config['data'] = $data;

        return $this;
    }

    /**
     * @param string $destinationFormat
     * @return LoadJobConfiguration
     */
    public function destinationFormat($destinationFormat)
    {
        $this->config['configuration']['extract']['destinationFormat'] = $destinationFormat;

        return $this;
    }

    /**
     * @param array $destinationUris
     * @return LoadJobConfiguration
     */
    public function destinationUris(array $destinationUris)
    {
        $this->config['configuration']['extract']['destinationUris'] = $destinationUris;

        return $this;
    }

    /**
     * @param string $fieldDelimiter
     * @return LoadJobConfiguration
     */
    public function fieldDelimiter($fieldDelimiter)
    {
        $this->config['configuration']['extract']['fieldDelimiter'] = $fieldDelimiter;

        return $this;
    }

    /**
     * @param string $printHeader
     * @return LoadJobConfiguration
     */
    public function printHeader($printHeader)
    {
        $this->config['configuration']['extract']['printHeader'] = $printHeader;

        return $this;
    }

    /**
     * @param array $sourceTable
     * @return LoadJobConfiguration
     */
    public function sourceTable(array $sourceTable)
    {
        $this->config['configuration']['extract']['sourceTable'] = $sourceTable;

        return $this;
    }
}
