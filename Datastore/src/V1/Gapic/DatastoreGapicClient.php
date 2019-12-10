<?php
/*
 * Copyright 2018 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/datastore/v1/datastore.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Datastore\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Datastore\V1\AllocateIdsRequest;
use Google\Cloud\Datastore\V1\AllocateIdsResponse;
use Google\Cloud\Datastore\V1\BeginTransactionRequest;
use Google\Cloud\Datastore\V1\BeginTransactionResponse;
use Google\Cloud\Datastore\V1\CommitRequest;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use Google\Cloud\Datastore\V1\CommitResponse;
use Google\Cloud\Datastore\V1\GqlQuery;
use Google\Cloud\Datastore\V1\Key;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\LookupResponse;
use Google\Cloud\Datastore\V1\Mutation;
use Google\Cloud\Datastore\V1\PartitionId;
use Google\Cloud\Datastore\V1\Query;
use Google\Cloud\Datastore\V1\ReadOptions;
use Google\Cloud\Datastore\V1\ReserveIdsRequest;
use Google\Cloud\Datastore\V1\ReserveIdsResponse;
use Google\Cloud\Datastore\V1\RollbackRequest;
use Google\Cloud\Datastore\V1\RollbackResponse;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use Google\Cloud\Datastore\V1\TransactionOptions;

/**
 * Service Description: Each RPC normalizes the partition IDs of the keys in its input entities,
 * and always returns entities with keys with normalized partition IDs.
 * This applies to all keys and entities, including those in values, except keys
 * with both an empty path and an empty or unset partition ID. Normalization of
 * input keys sets the project ID (if not already set) to the project ID from
 * the request.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $datastoreClient = new Google\Cloud\Datastore\V1\DatastoreClient();
 * try {
 *     $projectId = '';
 *     $keys = [];
 *     $response = $datastoreClient->lookup($projectId, $keys);
 * } finally {
 *     $datastoreClient->close();
 * }
 * ```
 *
 * @experimental
 */
class DatastoreGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.datastore.v1.Datastore';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'datastore.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The default scopes required by the service.
     */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/cloud-platform',
        'https://www.googleapis.com/auth/datastore',
    ];

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/datastore_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/datastore_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/datastore_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/datastore_rest_client_config.php',
                ],
            ],
        ];
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'datastore.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()}.
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string `rest`
     *           or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           {@see \Google\ApiCore\Transport\TransportInterface} object. Note that when this
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
     *           setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     *
     * @throws ValidationException
     * @experimental
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    /**
     * Looks up entities by key.
     *
     * Sample code:
     * ```
     * $datastoreClient = new Google\Cloud\Datastore\V1\DatastoreClient();
     * try {
     *     $projectId = '';
     *     $keys = [];
     *     $response = $datastoreClient->lookup($projectId, $keys);
     * } finally {
     *     $datastoreClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the project against which to make the request.
     * @param Key[]  $keys         Required. Keys of entities to look up.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type ReadOptions $readOptions
     *          The options for this lookup request.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Datastore\V1\LookupResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function lookup($projectId, $keys, array $optionalArgs = [])
    {
        $request = new LookupRequest();
        $request->setProjectId($projectId);
        $request->setKeys($keys);
        if (isset($optionalArgs['readOptions'])) {
            $request->setReadOptions($optionalArgs['readOptions']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'project_id' => $request->getProjectId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'Lookup',
            LookupResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Queries for entities.
     *
     * Sample code:
     * ```
     * $datastoreClient = new Google\Cloud\Datastore\V1\DatastoreClient();
     * try {
     *     $projectId = '';
     *     $partitionId = new Google\Cloud\Datastore\V1\PartitionId();
     *     $response = $datastoreClient->runQuery($projectId, $partitionId);
     * } finally {
     *     $datastoreClient->close();
     * }
     * ```
     *
     * @param string      $projectId    Required. The ID of the project against which to make the request.
     * @param PartitionId $partitionId  Entities are partitioned into subsets, identified by a partition ID.
     *                                  Queries are scoped to a single partition.
     *                                  This partition ID is normalized with the standard default context
     *                                  partition ID.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type ReadOptions $readOptions
     *          The options for this query.
     *     @type Query $query
     *          The query to run.
     *     @type GqlQuery $gqlQuery
     *          The GQL query to run.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Datastore\V1\RunQueryResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function runQuery($projectId, $partitionId, array $optionalArgs = [])
    {
        $request = new RunQueryRequest();
        $request->setProjectId($projectId);
        $request->setPartitionId($partitionId);
        if (isset($optionalArgs['readOptions'])) {
            $request->setReadOptions($optionalArgs['readOptions']);
        }
        if (isset($optionalArgs['query'])) {
            $request->setQuery($optionalArgs['query']);
        }
        if (isset($optionalArgs['gqlQuery'])) {
            $request->setGqlQuery($optionalArgs['gqlQuery']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'project_id' => $request->getProjectId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'RunQuery',
            RunQueryResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Begins a new transaction.
     *
     * Sample code:
     * ```
     * $datastoreClient = new Google\Cloud\Datastore\V1\DatastoreClient();
     * try {
     *     $projectId = '';
     *     $response = $datastoreClient->beginTransaction($projectId);
     * } finally {
     *     $datastoreClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the project against which to make the request.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type TransactionOptions $transactionOptions
     *          Options for a new transaction.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Datastore\V1\BeginTransactionResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function beginTransaction($projectId, array $optionalArgs = [])
    {
        $request = new BeginTransactionRequest();
        $request->setProjectId($projectId);
        if (isset($optionalArgs['transactionOptions'])) {
            $request->setTransactionOptions($optionalArgs['transactionOptions']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'project_id' => $request->getProjectId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'BeginTransaction',
            BeginTransactionResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Commits a transaction, optionally creating, deleting or modifying some
     * entities.
     *
     * Sample code:
     * ```
     * $datastoreClient = new Google\Cloud\Datastore\V1\DatastoreClient();
     * try {
     *     $projectId = '';
     *     $mode = Google\Cloud\Datastore\V1\CommitRequest\Mode::MODE_UNSPECIFIED;
     *     $mutations = [];
     *     $response = $datastoreClient->commit($projectId, $mode, $mutations);
     * } finally {
     *     $datastoreClient->close();
     * }
     * ```
     *
     * @param string     $projectId Required. The ID of the project against which to make the request.
     * @param int        $mode      The type of commit to perform. Defaults to `TRANSACTIONAL`.
     *                              For allowed values, use constants defined on {@see \Google\Cloud\Datastore\V1\CommitRequest\Mode}
     * @param Mutation[] $mutations The mutations to perform.
     *
     * When mode is `TRANSACTIONAL`, mutations affecting a single entity are
     * applied in order. The following sequences of mutations affecting a single
     * entity are not permitted in a single `Commit` request:
     *
     * - `insert` followed by `insert`
     * - `update` followed by `insert`
     * - `upsert` followed by `insert`
     * - `delete` followed by `update`
     *
     * When mode is `NON_TRANSACTIONAL`, no two mutations may affect a single
     * entity.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $transaction
     *          The identifier of the transaction associated with the commit. A
     *          transaction identifier is returned by a call to
     *          [Datastore.BeginTransaction][google.datastore.v1.Datastore.BeginTransaction].
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Datastore\V1\CommitResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function commit($projectId, $mode, $mutations, array $optionalArgs = [])
    {
        $request = new CommitRequest();
        $request->setProjectId($projectId);
        $request->setMode($mode);
        $request->setMutations($mutations);
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'project_id' => $request->getProjectId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'Commit',
            CommitResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Rolls back a transaction.
     *
     * Sample code:
     * ```
     * $datastoreClient = new Google\Cloud\Datastore\V1\DatastoreClient();
     * try {
     *     $projectId = '';
     *     $transaction = '';
     *     $response = $datastoreClient->rollback($projectId, $transaction);
     * } finally {
     *     $datastoreClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the project against which to make the request.
     * @param string $transaction  Required. The transaction identifier, returned by a call to
     *                             [Datastore.BeginTransaction][google.datastore.v1.Datastore.BeginTransaction].
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Datastore\V1\RollbackResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function rollback($projectId, $transaction, array $optionalArgs = [])
    {
        $request = new RollbackRequest();
        $request->setProjectId($projectId);
        $request->setTransaction($transaction);

        $requestParams = new RequestParamsHeaderDescriptor([
          'project_id' => $request->getProjectId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'Rollback',
            RollbackResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Allocates IDs for the given keys, which is useful for referencing an entity
     * before it is inserted.
     *
     * Sample code:
     * ```
     * $datastoreClient = new Google\Cloud\Datastore\V1\DatastoreClient();
     * try {
     *     $projectId = '';
     *     $keys = [];
     *     $response = $datastoreClient->allocateIds($projectId, $keys);
     * } finally {
     *     $datastoreClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the project against which to make the request.
     * @param Key[]  $keys         Required. A list of keys with incomplete key paths for which to allocate IDs.
     *                             No key may be reserved/read-only.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Datastore\V1\AllocateIdsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function allocateIds($projectId, $keys, array $optionalArgs = [])
    {
        $request = new AllocateIdsRequest();
        $request->setProjectId($projectId);
        $request->setKeys($keys);

        $requestParams = new RequestParamsHeaderDescriptor([
          'project_id' => $request->getProjectId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'AllocateIds',
            AllocateIdsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Prevents the supplied keys' IDs from being auto-allocated by Cloud
     * Datastore.
     *
     * Sample code:
     * ```
     * $datastoreClient = new Google\Cloud\Datastore\V1\DatastoreClient();
     * try {
     *     $projectId = '';
     *     $keys = [];
     *     $response = $datastoreClient->reserveIds($projectId, $keys);
     * } finally {
     *     $datastoreClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the project against which to make the request.
     * @param Key[]  $keys         Required. A list of keys with complete key paths whose numeric IDs should not be
     *                             auto-allocated.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $databaseId
     *          If not empty, the ID of the database against which to make the request.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Datastore\V1\ReserveIdsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function reserveIds($projectId, $keys, array $optionalArgs = [])
    {
        $request = new ReserveIdsRequest();
        $request->setProjectId($projectId);
        $request->setKeys($keys);
        if (isset($optionalArgs['databaseId'])) {
            $request->setDatabaseId($optionalArgs['databaseId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'project_id' => $request->getProjectId(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ReserveIds',
            ReserveIdsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
