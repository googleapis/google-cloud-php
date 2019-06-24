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
 * https://github.com/google/googleapis/blob/master/google/bigtable/admin/v2/bigtable_table_admin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Bigtable\Admin\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Bigtable\Admin\V2\CheckConsistencyRequest;
use Google\Cloud\Bigtable\Admin\V2\CheckConsistencyResponse;
use Google\Cloud\Bigtable\Admin\V2\CreateTableFromSnapshotRequest;
use Google\Cloud\Bigtable\Admin\V2\CreateTableRequest;
use Google\Cloud\Bigtable\Admin\V2\CreateTableRequest\Split;
use Google\Cloud\Bigtable\Admin\V2\DeleteSnapshotRequest;
use Google\Cloud\Bigtable\Admin\V2\DeleteTableRequest;
use Google\Cloud\Bigtable\Admin\V2\DropRowRangeRequest;
use Google\Cloud\Bigtable\Admin\V2\GenerateConsistencyTokenRequest;
use Google\Cloud\Bigtable\Admin\V2\GenerateConsistencyTokenResponse;
use Google\Cloud\Bigtable\Admin\V2\GetSnapshotRequest;
use Google\Cloud\Bigtable\Admin\V2\GetTableRequest;
use Google\Cloud\Bigtable\Admin\V2\ListSnapshotsRequest;
use Google\Cloud\Bigtable\Admin\V2\ListSnapshotsResponse;
use Google\Cloud\Bigtable\Admin\V2\ListTablesRequest;
use Google\Cloud\Bigtable\Admin\V2\ListTablesResponse;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest\Modification;
use Google\Cloud\Bigtable\Admin\V2\Snapshot;
use Google\Cloud\Bigtable\Admin\V2\SnapshotTableRequest;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\Admin\V2\Table\View;
use Google\LongRunning\Operation;
use Google\Protobuf\Duration;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Service for creating, configuring, and deleting Cloud Bigtable tables.
 *
 *
 * Provides access to the table schemas only, not the data stored within
 * the tables.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
 * try {
 *     $formattedParent = $bigtableTableAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
 *     $tableId = '';
 *     $table = new Google\Cloud\Bigtable\Admin\V2\Table();
 *     $response = $bigtableTableAdminClient->createTable($formattedParent, $tableId, $table);
 * } finally {
 *     $bigtableTableAdminClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 *
 * @experimental
 */
class BigtableTableAdminGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.bigtable.admin.v2.BigtableTableAdmin';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'bigtableadmin.googleapis.com';

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
        'https://www.googleapis.com/auth/bigtable.admin',
        'https://www.googleapis.com/auth/bigtable.admin.cluster',
        'https://www.googleapis.com/auth/bigtable.admin.instance',
        'https://www.googleapis.com/auth/bigtable.admin.table',
        'https://www.googleapis.com/auth/cloud-bigtable.admin',
        'https://www.googleapis.com/auth/cloud-bigtable.admin.cluster',
        'https://www.googleapis.com/auth/cloud-bigtable.admin.table',
        'https://www.googleapis.com/auth/cloud-platform',
        'https://www.googleapis.com/auth/cloud-platform.read-only',
    ];
    private static $clusterNameTemplate;
    private static $instanceNameTemplate;
    private static $snapshotNameTemplate;
    private static $tableNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/bigtable_table_admin_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/bigtable_table_admin_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/bigtable_table_admin_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/bigtable_table_admin_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getClusterNameTemplate()
    {
        if (null == self::$clusterNameTemplate) {
            self::$clusterNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/clusters/{cluster}');
        }

        return self::$clusterNameTemplate;
    }

    private static function getInstanceNameTemplate()
    {
        if (null == self::$instanceNameTemplate) {
            self::$instanceNameTemplate = new PathTemplate('projects/{project}/instances/{instance}');
        }

        return self::$instanceNameTemplate;
    }

    private static function getSnapshotNameTemplate()
    {
        if (null == self::$snapshotNameTemplate) {
            self::$snapshotNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/clusters/{cluster}/snapshots/{snapshot}');
        }

        return self::$snapshotNameTemplate;
    }

    private static function getTableNameTemplate()
    {
        if (null == self::$tableNameTemplate) {
            self::$tableNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/tables/{table}');
        }

        return self::$tableNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'cluster' => self::getClusterNameTemplate(),
                'instance' => self::getInstanceNameTemplate(),
                'snapshot' => self::getSnapshotNameTemplate(),
                'table' => self::getTableNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a cluster resource.
     *
     * @param string $project
     * @param string $instance
     * @param string $cluster
     *
     * @return string The formatted cluster resource.
     * @experimental
     */
    public static function clusterName($project, $instance, $cluster)
    {
        return self::getClusterNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'cluster' => $cluster,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a instance resource.
     *
     * @param string $project
     * @param string $instance
     *
     * @return string The formatted instance resource.
     * @experimental
     */
    public static function instanceName($project, $instance)
    {
        return self::getInstanceNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a snapshot resource.
     *
     * @param string $project
     * @param string $instance
     * @param string $cluster
     * @param string $snapshot
     *
     * @return string The formatted snapshot resource.
     * @experimental
     */
    public static function snapshotName($project, $instance, $cluster, $snapshot)
    {
        return self::getSnapshotNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'cluster' => $cluster,
            'snapshot' => $snapshot,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a table resource.
     *
     * @param string $project
     * @param string $instance
     * @param string $table
     *
     * @return string The formatted table resource.
     * @experimental
     */
    public static function tableName($project, $instance, $table)
    {
        return self::getTableNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'table' => $table,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - cluster: projects/{project}/instances/{instance}/clusters/{cluster}
     * - instance: projects/{project}/instances/{instance}
     * - snapshot: projects/{project}/instances/{instance}/clusters/{cluster}/snapshots/{snapshot}
     * - table: projects/{project}/instances/{instance}/tables/{table}.
     *
     * The optional $template argument can be supplied to specify a particular pattern, and must
     * match one of the templates listed above. If no $template argument is provided, or if the
     * $template argument does not match one of the templates listed, then parseName will check
     * each of the supported templates, and return the first match.
     *
     * @param string $formattedName The formatted name string
     * @param string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     * @experimental
     */
    public static function parseName($formattedName, $template = null)
    {
        $templateMap = self::getPathTemplateMap();

        if ($template) {
            if (!isset($templateMap[$template])) {
                throw new ValidationException("Template name $template does not exist");
            }

            return $templateMap[$template]->match($formattedName);
        }

        foreach ($templateMap as $templateName => $pathTemplate) {
            try {
                return $pathTemplate->match($formattedName);
            } catch (ValidationException $ex) {
                // Swallow the exception to continue trying other path templates
            }
        }
        throw new ValidationException("Input did not match any known format. Input: $formattedName");
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return OperationsClient
     * @experimental
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started
     * by a long running API method. If $methodName is not provided, or does
     * not match a long running API method, then the operation can still be
     * resumed, but the OperationResponse object will not deserialize the
     * final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $options = isset($this->descriptors[$methodName]['longRunning'])
            ? $this->descriptors[$methodName]['longRunning']
            : [];
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();

        return $operation;
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'bigtableadmin.googleapis.com:443'.
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
     *           object is provided, any settings in $transportConfig, and any $serviceAddress
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
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    /**
     * Creates a new table in the specified instance.
     * The table can be created with a full set of initial column families,
     * specified in the request.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedParent = $bigtableTableAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $tableId = '';
     *     $table = new Google\Cloud\Bigtable\Admin\V2\Table();
     *     $response = $bigtableTableAdminClient->createTable($formattedParent, $tableId, $table);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The unique name of the instance in which to create the table.
     *                             Values are of the form `projects/<project>/instances/<instance>`.
     * @param string $tableId      The name by which the new table should be referred to within the parent
     *                             instance, e.g., `foobar` rather than `<parent>/tables/foobar`.
     * @param Table  $table        The Table to create.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Split[] $initialSplits
     *          The optional list of row keys that will be used to initially split the
     *          table into several tablets (tablets are similar to HBase regions).
     *          Given two split keys, `s1` and `s2`, three tablets will be created,
     *          spanning the key ranges: `[, s1), [s1, s2), [s2, )`.
     *
     *          Example:
     *
     *          * Row keys := `["a", "apple", "custom", "customer_1", "customer_2",`
     *                         `"other", "zz"]`
     *          * initial_split_keys := `["apple", "customer_1", "customer_2", "other"]`
     *          * Key assignment:
     *              - Tablet 1 `[, apple)                => {"a"}.`
     *              - Tablet 2 `[apple, customer_1)      => {"apple", "custom"}.`
     *              - Tablet 3 `[customer_1, customer_2) => {"customer_1"}.`
     *              - Tablet 4 `[customer_2, other)      => {"customer_2"}.`
     *              - Tablet 5 `[other, )                => {"other", "zz"}.`
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Table
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createTable($parent, $tableId, $table, array $optionalArgs = [])
    {
        $request = new CreateTableRequest();
        $request->setParent($parent);
        $request->setTableId($tableId);
        $request->setTable($table);
        if (isset($optionalArgs['initialSplits'])) {
            $request->setInitialSplits($optionalArgs['initialSplits']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateTable',
            Table::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a new table from the specified snapshot. The target table must
     * not exist. The snapshot and the table must be in the same instance.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedParent = $bigtableTableAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $tableId = '';
     *     $sourceSnapshot = '';
     *     $operationResponse = $bigtableTableAdminClient->createTableFromSnapshot($formattedParent, $tableId, $sourceSnapshot);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $bigtableTableAdminClient->createTableFromSnapshot($formattedParent, $tableId, $sourceSnapshot);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $bigtableTableAdminClient->resumeOperation($operationName, 'createTableFromSnapshot');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $parent         The unique name of the instance in which to create the table.
     *                               Values are of the form `projects/<project>/instances/<instance>`.
     * @param string $tableId        The name by which the new table should be referred to within the parent
     *                               instance, e.g., `foobar` rather than `<parent>/tables/foobar`.
     * @param string $sourceSnapshot The unique name of the snapshot from which to restore the table. The
     *                               snapshot and the table must be in the same instance.
     *                               Values are of the form
     *                               `projects/<project>/instances/<instance>/clusters/<cluster>/snapshots/<snapshot>`.
     * @param array  $optionalArgs   {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createTableFromSnapshot($parent, $tableId, $sourceSnapshot, array $optionalArgs = [])
    {
        $request = new CreateTableFromSnapshotRequest();
        $request->setParent($parent);
        $request->setTableId($tableId);
        $request->setSourceSnapshot($sourceSnapshot);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'CreateTableFromSnapshot',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Lists all tables served from a specified instance.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedParent = $bigtableTableAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $bigtableTableAdminClient->listTables($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $bigtableTableAdminClient->listTables($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The unique name of the instance for which tables should be listed.
     *                             Values are of the form `projects/<project>/instances/<instance>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $view
     *          The view to be applied to the returned tables' fields.
     *          Defaults to `NAME_ONLY` if unspecified; no others are currently supported.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Table\View}
     *     @type int $pageSize
     *          Maximum number of results per page.
     *          CURRENTLY UNIMPLEMENTED AND IGNORED.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listTables($parent, array $optionalArgs = [])
    {
        $request = new ListTablesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['view'])) {
            $request->setView($optionalArgs['view']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListTables',
            $optionalArgs,
            ListTablesResponse::class,
            $request
        );
    }

    /**
     * Gets metadata information about the specified table.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
     *     $response = $bigtableTableAdminClient->getTable($formattedName);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the requested table.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/tables/<table>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $view
     *          The view to be applied to the returned table's fields.
     *          Defaults to `SCHEMA_VIEW` if unspecified.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Table\View}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Table
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getTable($name, array $optionalArgs = [])
    {
        $request = new GetTableRequest();
        $request->setName($name);
        if (isset($optionalArgs['view'])) {
            $request->setView($optionalArgs['view']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetTable',
            Table::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Permanently deletes a specified table and all of its data.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
     *     $bigtableTableAdminClient->deleteTable($formattedName);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the table to be deleted.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/tables/<table>`.
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
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteTable($name, array $optionalArgs = [])
    {
        $request = new DeleteTableRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteTable',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Performs a series of column family modifications on the specified table.
     * Either all or none of the modifications will occur before this method
     * returns, but data requests received prior to that point may see a table
     * where only some modifications have taken effect.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
     *     $modifications = [];
     *     $response = $bigtableTableAdminClient->modifyColumnFamilies($formattedName, $modifications);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string         $name          The unique name of the table whose families should be modified.
     *                                      Values are of the form
     *                                      `projects/<project>/instances/<instance>/tables/<table>`.
     * @param Modification[] $modifications Modifications to be atomically applied to the specified table's families.
     *                                      Entries are applied in order, meaning that earlier modifications can be
     *                                      masked by later ones (in the case of repeated updates to the same family,
     *                                      for example).
     * @param array          $optionalArgs  {
     *                                      Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Table
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function modifyColumnFamilies($name, $modifications, array $optionalArgs = [])
    {
        $request = new ModifyColumnFamiliesRequest();
        $request->setName($name);
        $request->setModifications($modifications);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ModifyColumnFamilies',
            Table::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Permanently drop/delete a row range from a specified table. The request can
     * specify whether to delete all rows in a table, or only those that match a
     * particular prefix.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
     *     $bigtableTableAdminClient->dropRowRange($formattedName);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the table on which to drop a range of rows.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/tables/<table>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $rowKeyPrefix
     *          Delete all rows that start with this row key prefix. Prefix cannot be
     *          zero length.
     *     @type bool $deleteAllDataFromTable
     *          Delete all rows in the table. Setting this to false is a no-op.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function dropRowRange($name, array $optionalArgs = [])
    {
        $request = new DropRowRangeRequest();
        $request->setName($name);
        if (isset($optionalArgs['rowKeyPrefix'])) {
            $request->setRowKeyPrefix($optionalArgs['rowKeyPrefix']);
        }
        if (isset($optionalArgs['deleteAllDataFromTable'])) {
            $request->setDeleteAllDataFromTable($optionalArgs['deleteAllDataFromTable']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DropRowRange',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Generates a consistency token for a Table, which can be used in
     * CheckConsistency to check whether mutations to the table that finished
     * before this call started have been replicated. The tokens will be available
     * for 90 days.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
     *     $response = $bigtableTableAdminClient->generateConsistencyToken($formattedName);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the Table for which to create a consistency token.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/tables/<table>`.
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
     * @return \Google\Cloud\Bigtable\Admin\V2\GenerateConsistencyTokenResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function generateConsistencyToken($name, array $optionalArgs = [])
    {
        $request = new GenerateConsistencyTokenRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GenerateConsistencyToken',
            GenerateConsistencyTokenResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Checks replication consistency based on a consistency token, that is, if
     * replication has caught up based on the conditions specified in the token
     * and the check request.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
     *     $consistencyToken = '';
     *     $response = $bigtableTableAdminClient->checkConsistency($formattedName, $consistencyToken);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $name             The unique name of the Table for which to check replication consistency.
     *                                 Values are of the form
     *                                 `projects/<project>/instances/<instance>/tables/<table>`.
     * @param string $consistencyToken The token created using GenerateConsistencyToken for the Table.
     * @param array  $optionalArgs     {
     *                                 Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\CheckConsistencyResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function checkConsistency($name, $consistencyToken, array $optionalArgs = [])
    {
        $request = new CheckConsistencyRequest();
        $request->setName($name);
        $request->setConsistencyToken($consistencyToken);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CheckConsistency',
            CheckConsistencyResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a new snapshot in the specified cluster from the specified
     * source table. The cluster and the table must be in the same instance.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
     *     $cluster = '';
     *     $snapshotId = '';
     *     $description = '';
     *     $operationResponse = $bigtableTableAdminClient->snapshotTable($formattedName, $cluster, $snapshotId, $description);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $bigtableTableAdminClient->snapshotTable($formattedName, $cluster, $snapshotId, $description);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $bigtableTableAdminClient->resumeOperation($operationName, 'snapshotTable');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the table to have the snapshot taken.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/tables/<table>`.
     * @param string $cluster      The name of the cluster where the snapshot will be created in.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/clusters/<cluster>`.
     * @param string $snapshotId   The ID by which the new snapshot should be referred to within the parent
     *                             cluster, e.g., `mysnapshot` of the form: `[_a-zA-Z0-9][-_.a-zA-Z0-9]*`
     *                             rather than
     *                             `projects/<project>/instances/<instance>/clusters/<cluster>/snapshots/mysnapshot`.
     * @param string $description  Description of the snapshot.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Duration $ttl
     *          The amount of time that the new snapshot can stay active after it is
     *          created. Once 'ttl' expires, the snapshot will get deleted. The maximum
     *          amount of time a snapshot can stay active is 7 days. If 'ttl' is not
     *          specified, the default value of 24 hours will be used.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function snapshotTable($name, $cluster, $snapshotId, $description, array $optionalArgs = [])
    {
        $request = new SnapshotTableRequest();
        $request->setName($name);
        $request->setCluster($cluster);
        $request->setSnapshotId($snapshotId);
        $request->setDescription($description);
        if (isset($optionalArgs['ttl'])) {
            $request->setTtl($optionalArgs['ttl']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'SnapshotTable',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Gets metadata information about the specified snapshot.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->snapshotName('[PROJECT]', '[INSTANCE]', '[CLUSTER]', '[SNAPSHOT]');
     *     $response = $bigtableTableAdminClient->getSnapshot($formattedName);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the requested snapshot.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/clusters/<cluster>/snapshots/<snapshot>`.
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
     * @return \Google\Cloud\Bigtable\Admin\V2\Snapshot
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getSnapshot($name, array $optionalArgs = [])
    {
        $request = new GetSnapshotRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetSnapshot',
            Snapshot::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists all snapshots associated with the specified cluster.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedParent = $bigtableTableAdminClient->clusterName('[PROJECT]', '[INSTANCE]', '[CLUSTER]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $bigtableTableAdminClient->listSnapshots($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $bigtableTableAdminClient->listSnapshots($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The unique name of the cluster for which snapshots should be listed.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/clusters/<cluster>`.
     *                             Use `<cluster> = '-'` to list snapshots for all clusters in an instance,
     *                             e.g., `projects/<project>/instances/<instance>/clusters/-`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listSnapshots($parent, array $optionalArgs = [])
    {
        $request = new ListSnapshotsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListSnapshots',
            $optionalArgs,
            ListSnapshotsResponse::class,
            $request
        );
    }

    /**
     * Permanently deletes the specified snapshot.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     *
     * Sample code:
     * ```
     * $bigtableTableAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient();
     * try {
     *     $formattedName = $bigtableTableAdminClient->snapshotName('[PROJECT]', '[INSTANCE]', '[CLUSTER]', '[SNAPSHOT]');
     *     $bigtableTableAdminClient->deleteSnapshot($formattedName);
     * } finally {
     *     $bigtableTableAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the snapshot to be deleted.
     *                             Values are of the form
     *                             `projects/<project>/instances/<instance>/clusters/<cluster>/snapshots/<snapshot>`.
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
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteSnapshot($name, array $optionalArgs = [])
    {
        $request = new DeleteSnapshotRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteSnapshot',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
