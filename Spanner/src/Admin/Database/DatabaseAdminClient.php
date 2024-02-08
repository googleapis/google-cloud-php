<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Spanner\Admin\Database;

use Google\Cloud\Core\EmulatorTrait;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient as Client;

/**
 * A wrapper over the Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient
 * to support SPANNER_EMULATOR_HOST environment variable.
 *
 * ```
 * // Using a Spanner Emulator
 * use Google\Cloud\Spanner\Admin\Database\DatabaseAdminClient;
 *
 * // Be sure to use the port specified when starting the emulator.
 * // `9010` is used as an example only.
 * putenv('SPANNER_EMULATOR_HOST=localhost:9010');
 *
 * $spanner = new DatabaseAdminClient();
 * ```
 */
class DatabaseAdminClient
{
    use EmulatorTrait;

    /**
     * Creates a Spanner client. Please note that this client requires
     * [the gRPC extension](https://cloud.google.com/php/grpc).
     *
     * @param array $config [optional] {
     *     Configuration options for the client.
     *     {@see Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient}
     *     for a list of supported configuration options.
     * }
     */
    public function __construct(array $config = [])
    {
        $emulatorHost = getenv('SPANNER_EMULATOR_HOST');
        if (!empty($emulatorHost)) {
            $config = array_merge(
                $config,
                $this->emulatorGapicConfig($emulatorHost)
            );
        }

        return new Client($config);
    }
}
