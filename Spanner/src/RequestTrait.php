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

namespace Google\Cloud\Spanner;

use Google\Cloud\Spanner\Admin\Database\V1\Backup;
use Google\Cloud\Spanner\Admin\Database\V1\CopyBackupMetadata;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupMetadata;
use Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseMetadata;
use Google\Cloud\Spanner\Admin\Database\V1\Database;
use Google\Cloud\Spanner\Admin\Database\V1\OptimizeRestoredDatabaseMetadata;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseMetadata;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseDdlMetadata;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceConfigMetadata;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceMetadata;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceConfigMetadata;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceMetadata;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Protobuf\GPBEmpty;

/**
 * Shared functionality for Spanner requests.
 *
 * @internal
 */
trait RequestTrait
{
    private $larHeader = 'x-goog-spanner-route-to-leader';
    private $resourcePrefixHeader = 'google-cloud-resource-prefix';

    /**
     * Create request and send the request.
     */
    private function createAndSendRequest(
        string $clientClass,
        string $method,
        array $data,
        array $optionalArgs,
        string $requestClass,
        string $resourcePrefixHeader = '',
        bool $routeToLeader = false
    ) {
        if ($resourcePrefixHeader) {
            $optionalArgs = $this->addResourcePrefixHeader(
                $optionalArgs,
                $resourcePrefixHeader
            );
        }
        if ($routeToLeader) {
            $optionalArgs = $this->addLarHeader($optionalArgs, $routeToLeader);
        }

        $request = $this->serializer->decodeMessage(new $requestClass(), $data);

        return $this->requestHandler->sendRequest(
            $clientClass,
            $method,
            $request,
            $optionalArgs
        );
    }

    /**
     * Add the `x-goog-spanner-route-to-leader` header value to the request.
     *
     * @param array $args Request arguments.
     * @param bool $value LAR header value.
     * @param string $context Transaction context.
     * @return array
     */
    private function addLarHeader(
        array $args,
        bool $value = true,
        string $context = SessionPoolInterface::CONTEXT_READWRITE
    ) {
        if (!$value) {
            return $args;
        }
        // If value is true and context is READWRITE, set LAR header.
        if ($context === SessionPoolInterface::CONTEXT_READWRITE) {
            $args['headers'][$this->larHeader] = ['true'];
        }
        return $args;
    }

    /**
     * Conditionally unset the LAR header.
     *
     * @param array $args Request arguments.
     * @param bool $value Whether to set or unset the LAR header.
     * @return array
     */
    private function conditionallyUnsetLarHeader(
        array $args,
        bool $value = true
    ) {
        if (!$value) {
            unset($args['headers'][$this->larHeader]);
        }
        return $args;
    }

    /**
     * Add the `google-cloud-resource-prefix` header value to the request.
     *
     * @param array $args Request arguments.
     * @param string $value Resource prefix header value.
     * @return array
     */
    private function addResourcePrefixHeader(array $args, string $value)
    {
        $args['headers'][$this->resourcePrefixHeader] = [$value];
        return $args;
    }
}
