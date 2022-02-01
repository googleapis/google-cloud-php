<?php
/*
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/bigquery/datatransfer/v1/datatransfer.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\BigQuery\DataTransfer\V1;

use Google\Cloud\BigQuery\DataTransfer\V1\Gapic\DataTransferServiceGapicClient;

/**
 * {@inheritdoc}
 */
class DataTransferServiceClient extends DataTransferServiceGapicClient
{
    /**
     * Formats a string containing the fully-qualified path to represent
     * a location_data_source resource.
     *
     * @param string $project
     * @param string $location
     * @param string $dataSource
     *
     * @return string The formatted location_data_source resource.
     *
     * @deprecated Multi-pattern resource names will have unified formatting functions.
     *             This helper function will be deleted in the next major version.
     */
    public static function locationDataSourceName($project, $location, $dataSource)
    {
        return self::projectLocationDataSourceName($project, $location, $dataSource);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location_run resource.
     *
     * @param string $project
     * @param string $location
     * @param string $transferConfig
     * @param string $run
     *
     * @return string The formatted location_run resource.
     *
     * @deprecated Multi-pattern resource names will have unified formatting functions.
     *             This helper function will be deleted in the next major version.
     */
    public static function locationRunName($project, $location, $transferConfig, $run)
    {
        return self::projectLocationTransferConfigRunName($project, $location, $transferConfig, $run);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location_transfer_config resource.
     *
     * @param string $project
     * @param string $location
     * @param string $transferConfig
     *
     * @return string The formatted location_transfer_config resource.
     *
     * @deprecated Multi-pattern resource names will have unified formatting functions.
     *             This helper function will be deleted in the next major version.
     */
    public static function locationTransferConfigName($project, $location, $transferConfig)
    {
        return self::projectLocationTransferConfigName($project, $location, $transferConfig);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project_run resource.
     *
     * @param string $project
     * @param string $transferConfig
     * @param string $run
     *
     * @return string The formatted project_run resource.
     *
     * @deprecated Multi-pattern resource names will have unified formatting functions.
     *             This helper function will be deleted in the next major version.
     */
    public static function projectRunName($project, $transferConfig, $run)
    {
        return self::projectTransferConfigRunName($project, $transferConfig, $run);
    }
}
