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
 * https://github.com/google/googleapis/blob/master/google/spanner/admin/database/v1/spanner_database_admin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Spanner\Admin\Database\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\FetchAuthTokenInterface;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseMetadata;
use Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\Database;
use Google\Cloud\Spanner\Admin\Database\V1\DropDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlResponse;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesResponse;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseDdlMetadata;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseDdlRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Cloud Spanner Database Admin API.
 *
 * The Cloud Spanner Database Admin API can be used to create, drop, and
 * list databases. It also enables updating the schema of pre-existing
 * databases.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $databaseAdminClient = new DatabaseAdminClient();
 * try {
 *     $formattedParent = $databaseAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
 *     // Iterate through all elements
 *     $pagedResponse = $databaseAdminClient->listDatabases($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $databaseAdminClient->listDatabases($formattedParent);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $databaseAdminClient->close();
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
class DatabaseAdminGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.spanner.admin.database.v1.DatabaseAdmin';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'spanner.googleapis.com';

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
        'https://www.googleapis.com/auth/spanner.admin',
    ];
    private static $instanceNameTemplate;
    private static $databaseNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/database_admin_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/database_admin_descriptor_config.php',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/database_admin_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getInstanceNameTemplate()
    {
        if (self::$instanceNameTemplate == null) {
            self::$instanceNameTemplate = new PathTemplate('projects/{project}/instances/{instance}');
        }

        return self::$instanceNameTemplate;
    }

    private static function getDatabaseNameTemplate()
    {
        if (self::$databaseNameTemplate == null) {
            self::$databaseNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/databases/{database}');
        }

        return self::$databaseNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'instance' => self::getInstanceNameTemplate(),
                'database' => self::getDatabaseNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * a database resource.
     *
     * @param string $project
     * @param string $instance
     * @param string $database
     *
     * @return string The formatted database resource.
     * @experimental
     */
    public static function databaseName($project, $instance, $database)
    {
        return self::getDatabaseNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'database' => $database,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - instance: projects/{project}/instances/{instance}
     * - database: projects/{project}/instances/{instance}/databases/{database}.
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
     *           as "<uri>:<port>". Default 'spanner.googleapis.com:443'.
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
     * Lists Cloud Spanner databases.
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedParent = $databaseAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     // Iterate through all elements
     *     $pagedResponse = $databaseAdminClient->listDatabases($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $databaseAdminClient->listDatabases($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The instance whose databases should be listed.
     *                             Values are of the form `projects/<project>/instances/<instance>`.
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
    public function listDatabases($parent, array $optionalArgs = [])
    {
        $request = new ListDatabasesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListDatabases',
            $optionalArgs,
            ListDatabasesResponse::class,
            $request
        );
    }

    /**
     * Creates a new Cloud Spanner database and starts to prepare it for serving.
     * The returned [long-running operation][google.longrunning.Operation] will
     * have a name of the format `<database_name>/operations/<operation_id>` and
     * can be used to track preparation of the database. The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [CreateDatabaseMetadata][google.spanner.admin.database.v1.CreateDatabaseMetadata]. The
     * [response][google.longrunning.Operation.response] field type is
     * [Database][google.spanner.admin.database.v1.Database], if successful.
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedParent = $databaseAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $createStatement = '';
     *     $operationResponse = $databaseAdminClient->createDatabase($formattedParent, $createStatement);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       $result = $operationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $databaseAdminClient->createDatabase($formattedParent, $createStatement);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $databaseAdminClient->resumeOperation($operationName, 'createDatabase');
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
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string $parent          Required. The name of the instance that will serve the new database.
     *                                Values are of the form `projects/<project>/instances/<instance>`.
     * @param string $createStatement Required. A `CREATE DATABASE` statement, which specifies the ID of the
     *                                new database.  The database ID must conform to the regular expression
     *                                `[a-z][a-z0-9_\-]*[a-z0-9]` and be between 2 and 30 characters in length.
     *                                If the database ID is a reserved word or if it contains a hyphen, the
     *                                database ID must be enclosed in backticks (`` ` ``).
     * @param array  $optionalArgs    {
     *                                Optional.
     *
     *     @type string[] $extraStatements
     *          An optional list of DDL statements to run inside the newly created
     *          database. Statements can create tables, indexes, etc. These
     *          statements execute atomically with the creation of the database:
     *          if there is an error in any statement, the database is not created.
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
    public function createDatabase($parent, $createStatement, array $optionalArgs = [])
    {
        $request = new CreateDatabaseRequest();
        $request->setParent($parent);
        $request->setCreateStatement($createStatement);
        if (isset($optionalArgs['extraStatements'])) {
            $request->setExtraStatements($optionalArgs['extraStatements']);
        }

        return $this->startOperationsCall(
            'CreateDatabase',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Gets the state of a Cloud Spanner database.
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedName = $databaseAdminClient->databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
     *     $response = $databaseAdminClient->getDatabase($formattedName);
     * } finally {
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the requested database. Values are of the form
     *                             `projects/<project>/instances/<instance>/databases/<database>`.
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
     * @return \Google\Cloud\Spanner\Admin\Database\V1\Database
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getDatabase($name, array $optionalArgs = [])
    {
        $request = new GetDatabaseRequest();
        $request->setName($name);

        return $this->startCall(
            'GetDatabase',
            Database::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the schema of a Cloud Spanner database by
     * creating/altering/dropping tables, columns, indexes, etc. The returned
     * [long-running operation][google.longrunning.Operation] will have a name of
     * the format `<database_name>/operations/<operation_id>` and can be used to
     * track execution of the schema change(s). The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [UpdateDatabaseDdlMetadata][google.spanner.admin.database.v1.UpdateDatabaseDdlMetadata].  The operation has no response.
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedDatabase = $databaseAdminClient->databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
     *     $statements = [];
     *     $operationResponse = $databaseAdminClient->updateDatabaseDdl($formattedDatabase, $statements);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $databaseAdminClient->updateDatabaseDdl($formattedDatabase, $statements);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $databaseAdminClient->resumeOperation($operationName, 'updateDatabaseDdl');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string   $database     Required. The database to update.
     * @param string[] $statements   DDL statements to be applied to the database.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type string $operationId
     *          If empty, the new update request is assigned an
     *          automatically-generated operation ID. Otherwise, `operation_id`
     *          is used to construct the name of the resulting
     *          [Operation][google.longrunning.Operation].
     *
     *          Specifying an explicit operation ID simplifies determining
     *          whether the statements were executed in the event that the
     *          [UpdateDatabaseDdl][google.spanner.admin.database.v1.DatabaseAdmin.UpdateDatabaseDdl] call is replayed,
     *          or the return value is otherwise lost: the [database][google.spanner.admin.database.v1.UpdateDatabaseDdlRequest.database] and
     *          `operation_id` fields can be combined to form the
     *          [name][google.longrunning.Operation.name] of the resulting
     *          [longrunning.Operation][google.longrunning.Operation]: `<database>/operations/<operation_id>`.
     *
     *          `operation_id` should be unique within the database, and must be
     *          a valid identifier: `[a-z][a-z0-9_]*`. Note that
     *          automatically-generated operation IDs always begin with an
     *          underscore. If the named operation already exists,
     *          [UpdateDatabaseDdl][google.spanner.admin.database.v1.DatabaseAdmin.UpdateDatabaseDdl] returns
     *          `ALREADY_EXISTS`.
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
    public function updateDatabaseDdl($database, $statements, array $optionalArgs = [])
    {
        $request = new UpdateDatabaseDdlRequest();
        $request->setDatabase($database);
        $request->setStatements($statements);
        if (isset($optionalArgs['operationId'])) {
            $request->setOperationId($optionalArgs['operationId']);
        }

        return $this->startOperationsCall(
            'UpdateDatabaseDdl',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Drops (aka deletes) a Cloud Spanner database.
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedDatabase = $databaseAdminClient->databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
     *     $databaseAdminClient->dropDatabase($formattedDatabase);
     * } finally {
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string $database     Required. The database to be dropped.
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
    public function dropDatabase($database, array $optionalArgs = [])
    {
        $request = new DropDatabaseRequest();
        $request->setDatabase($database);

        return $this->startCall(
            'DropDatabase',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns the schema of a Cloud Spanner database as a list of formatted
     * DDL statements. This method does not show pending schema updates, those may
     * be queried using the [Operations][google.longrunning.Operations] API.
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedDatabase = $databaseAdminClient->databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
     *     $response = $databaseAdminClient->getDatabaseDdl($formattedDatabase);
     * } finally {
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string $database     Required. The database whose schema we wish to get.
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
     * @return \Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getDatabaseDdl($database, array $optionalArgs = [])
    {
        $request = new GetDatabaseDdlRequest();
        $request->setDatabase($database);

        return $this->startCall(
            'GetDatabaseDdl',
            GetDatabaseDdlResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the access control policy on a database resource. Replaces any
     * existing policy.
     *
     * Authorization requires `spanner.databases.setIamPolicy` permission on
     * [resource][google.iam.v1.SetIamPolicyRequest.resource].
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedResource = $databaseAdminClient->databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
     *     $policy = new Policy();
     *     $response = $databaseAdminClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being specified.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
     * @param Policy $policy       REQUIRED: The complete policy to be applied to the `resource`. The size of
     *                             the policy is limited to a few 10s of KB. An empty policy is a
     *                             valid policy but certain Cloud Platform services (such as Projects)
     *                             might reject them.
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
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setIamPolicy($resource, $policy, array $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        $request->setResource($resource);
        $request->setPolicy($policy);

        return $this->startCall(
            'SetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the access control policy for a database resource. Returns an empty
     * policy if a database exists but does not have a policy set.
     *
     * Authorization requires `spanner.databases.getIamPolicy` permission on
     * [resource][google.iam.v1.GetIamPolicyRequest.resource].
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedResource = $databaseAdminClient->databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
     *     $response = $databaseAdminClient->getIamPolicy($formattedResource);
     * } finally {
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
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
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIamPolicy($resource, array $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        $request->setResource($resource);

        return $this->startCall(
            'GetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns permissions that the caller has on the specified database resource.
     *
     * Attempting this RPC on a non-existent Cloud Spanner database will result in
     * a NOT_FOUND error if the user has `spanner.databases.list` permission on
     * the containing Cloud Spanner instance. Otherwise returns an empty set of
     * permissions.
     *
     * Sample code:
     * ```
     * $databaseAdminClient = new DatabaseAdminClient();
     * try {
     *     $formattedResource = $databaseAdminClient->databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
     *     $permissions = [];
     *     $response = $databaseAdminClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $databaseAdminClient->close();
     * }
     * ```
     *
     * @param string   $resource     REQUIRED: The resource for which the policy detail is being requested.
     *                               `resource` is usually specified as a path. For example, a Project
     *                               resource is specified as `projects/{project}`.
     * @param string[] $permissions  The set of permissions to check for the `resource`. Permissions with
     *                               wildcards (such as '*' or 'storage.*') are not allowed. For more
     *                               information see
     *                               [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\TestIamPermissionsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function testIamPermissions($resource, $permissions, array $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        $request->setPermissions($permissions);

        return $this->startCall(
            'TestIamPermissions',
            TestIamPermissionsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
