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

use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LROTrait;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient AS InstanceAdminClient;
use Google\Cloud\Bigtable\Connection\Grpc;
use Google\Cloud\Bigtable\Connection\LongRunningConnection;

/**
 * Cloud Bigtable is a highly scalable, transactional, managed, NewSQL
 * database service. Find more information at
 * [Cloud Bigtable docs](https://cloud.google.com/bigtable/).
 *
 * In production environments, it is highly recommended that you make use of the
 * Protobuf PHP extension for improved performance. Protobuf can be installed
 * via [PECL](https://pecl.php.net).
 *
 * ```
 * $ pecl install protobuf
 * ```
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\BigtableClient;
 *
 * $bigtable = new BigtableClient();
 * ```
 *
 * @method resumeOperation() {
 *     Resume a Long Running Operation
 *
 *     Example:
 *     ```
 *     $operation = $bigtable->resumeOperation($operationName);
 *     ```
 *
 *     @param string $operationName The Long Running Operation name.
 *     @param array $info [optional] The operation data.
 *     @return LongRunningOperation
 * }
 */

class BigtableClient
{
    use ClientTrait;
    use LROTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/bigtable.data';
    const ADMIN_SCOPE = 'https://www.googleapis.com/auth/bigtable.admin';

    /**
     * @var Connection\ConnectionInterface
     */
    protected $connection;

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * Create a Bigtable client. Please note that this client requires
     * [the gRPC extension](https://cloud.google.com/php/grpc).
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `0` with REST and `60` with gRPC.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     * }
     * @throws GoogleException If the gRPC extension is not enabled.
     */
    public function __construct(array $config = [])
    {
        $this->requireGrpc();
        $config += [
            'scopes' => [
                self::FULL_CONTROL_SCOPE,
                self::ADMIN_SCOPE
            ],
            'returnInt64AsObject' => false,
            'projectIdRequired' => true
        ];
        $this->connection = new Grpc($this->configureAuthentication($config));
        $this->returnInt64AsObject = $config['returnInt64AsObject'];
        $this->setLroProperties(new LongRunningConnection($this->connection), [
            [
                'typeUrl' => 'type.googleapis.com/google.bigtable.admin.instance.v2.UpdateInstanceMetadata',
                'callable' => function ($instance) {
                    $name = InstanceAdminClient::parseName($instance['name'])['instance'];
                    return $this->instance($name, $instance);
                }
            ], [
                'typeUrl' => 'type.googleapis.com/google.bigtable.admin.instance.v2.CreateInstanceMetadata',
                'callable' => function ($instance) {
                    $name = InstanceAdminClient::parseName($instance['name'])['instance'];
                    return $this->instance($name, $instance);
                }
            ]
        ]);
    }

    /**
     * Create a new instance.
     *
     * Example:
     * ```
     * $operation = $bigtable->createInstance($configuration, 'my-instance');
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigtable/docs/reference/admin/rpc/google.bigtable.admin.v2#CreateInstanceRequest CreateInstanceRequest
     *
     * @param InstanceConfiguration $config The configuration to use
     * @param string $name The instance name.
     * @param string $cluster The cluster ID.
     * @param string $location The location ID.
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $displayName **Defaults to** the value of $name.
     *     @type int $nodeCount **Defaults to** `1`.
     *     @type array $labels For more information, see
     *           [Using labels to organize Google Cloud Platform resources](https://cloudplatform.googleblog.com/2015/10/using-labels-to-organize-Google-Cloud-Platform-resources.html).
     * }
     * @return LongRunningOperation<Instance>
     * @codingStandardsIgnoreEnd
     */
    public function createInstance(InstanceConfiguration $config, $name, $cluster, $location, array $options = [])
    {
        $instance = $this->instance($name);
        return $instance->create($config, $cluster, $location, $options);
    }

    /**
     * Lazily instantiate an instance.
     *
     * Example:
     * ```
     * $instance = $bigtable->instance('my-instance');
     * ```
     *
     * @param string $name The instance name
     * @return Instance
     */
    public function instance($name, array $instance = [])
    {
        return new Instance(
            $this->connection,
            $this->lroConnection,
            $this->lroCallables,
            $this->projectId,
            $name,
            $this->returnInt64AsObject,
            $instance
        );
    }
}
