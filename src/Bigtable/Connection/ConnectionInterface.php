<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable;

/**
 * Represents a connection to Cloud Bigtable.
 */
interface ConnectionInterface
{
    /**
     * Creates a new Admin in the specified instance.
     *
     * @param string $adminId      The name by which the new admin should be referred to within the parent
     *                             instance.
     *
     * @param array  $optionalArgs {
     *                               Optional.
     *
     *          @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     * @return \Google\Bigtable\Admin\V2\Table
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function createInstanceAdmin(array $args);
    public function createTableAdmin(array $args);
    public function createsession(array $args);

}
