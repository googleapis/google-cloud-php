<?php
/*
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/spanner/admin/database/v1/spanner_database_admin.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Spanner\Admin\Database\V1;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use google\iam\v1\GetIamPolicyRequest;
use google\iam\v1\Policy;
use google\iam\v1\SetIamPolicyRequest;
use google\iam\v1\TestIamPermissionsRequest;
use google\spanner\admin\database\v1\CreateDatabaseRequest;
use google\spanner\admin\database\v1\DatabaseAdminClient;
use google\spanner\admin\database\v1\DropDatabaseRequest;
use google\spanner\admin\database\v1\GetDatabaseDDLRequest;
use google\spanner\admin\database\v1\ListDatabasesRequest;
use google\spanner\admin\database\v1\UpdateDatabaseRequest;

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
 * try {
 *     $databaseAdminApi = new DatabaseAdminApi();
 *     $formattedName = DatabaseAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
 *     foreach ($databaseAdminApi->listDatabases($formattedName) as $element) {
 *         // doThingsWith(element);
 *     }
 * } finally {
 *     if (isset($databaseAdminApi)) {
 *         $databaseAdminApi->close();
 *     }
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 */
class DatabaseAdminApi
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'wrenchworks.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The default timeout for non-retrying methods.
     */
    const DEFAULT_TIMEOUT_MILLIS = 30000;

    const _GAX_VERSION = '0.1.0';
    const _CODEGEN_NAME = 'GAPIC';
    const _CODEGEN_VERSION = '0.0.0';

    private static $instanceNameTemplate;
    private static $databaseNameTemplate;

    private $grpcCredentialsHelper;
    private $databaseAdminStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    /**
     * Formats a string containing the fully-qualified path to represent
     * a instance resource.
     */
    public static function formatInstanceName($project, $instance)
    {
        return self::getInstanceNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a database resource.
     */
    public static function formatDatabaseName($project, $instance, $database)
    {
        return self::getDatabaseNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'database' => $database,
        ]);
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a instance resource.
     */
    public static function parseProjectFromInstanceName($instanceName)
    {
        return self::getInstanceNameTemplate()->match($instanceName)['project'];
    }

    /**
     * Parses the instance from the given fully-qualified path which
     * represents a instance resource.
     */
    public static function parseInstanceFromInstanceName($instanceName)
    {
        return self::getInstanceNameTemplate()->match($instanceName)['instance'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a database resource.
     */
    public static function parseProjectFromDatabaseName($databaseName)
    {
        return self::getDatabaseNameTemplate()->match($databaseName)['project'];
    }

    /**
     * Parses the instance from the given fully-qualified path which
     * represents a database resource.
     */
    public static function parseInstanceFromDatabaseName($databaseName)
    {
        return self::getDatabaseNameTemplate()->match($databaseName)['instance'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a database resource.
     */
    public static function parseDatabaseFromDatabaseName($databaseName)
    {
        return self::getDatabaseNameTemplate()->match($databaseName)['database'];
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

    private static function getPageStreamingDescriptors()
    {
        $listDatabasesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenField' => 'page_token',
                    'requestPageSizeField' => 'page_size',
                    'responsePageTokenField' => 'next_page_token',
                    'resourceField' => 'databases',
                ]);

        $pageStreamingDescriptors = [
            'listDatabases' => $listDatabasesPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'wrenchworks.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Spanner Admin Database API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @type string $appName The codename of the calling service. Default 'gax'.
     *     @type string $appVersion The version of the calling service.
     *                              Default: the current version of GAX.
     *     @type Google\Auth\CredentialsLoader $credentialsLoader
     *                              A CredentialsLoader object created using the
     *                              Google\Auth library.
     * }
     */
    public function __construct($options = [])
    {
        $defaultScopes = [
            'https://www.googleapis.com/auth/cloud-platform',
            'https://www.googleapis.com/auth/spanner.admin',
        ];
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => $defaultScopes,
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'appName' => 'gax',
            'appVersion' => self::_GAX_VERSION,
            'credentialsLoader' => null,
        ];
        $options = array_merge($defaultOptions, $options);

        $headerDescriptor = new AgentHeaderDescriptor([
            'clientName' => $options['appName'],
            'clientVersion' => $options['appVersion'],
            'codeGenName' => self::_CODEGEN_NAME,
            'codeGenVersion' => self::_CODEGEN_VERSION,
            'gaxVersion' => self::_GAX_VERSION,
            'phpVersion' => phpversion(),
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'listDatabases' => $defaultDescriptors,
            'createDatabase' => $defaultDescriptors,
            'updateDatabase' => $defaultDescriptors,
            'dropDatabase' => $defaultDescriptors,
            'getDatabaseDDL' => $defaultDescriptors,
            'setIamPolicy' => $defaultDescriptors,
            'getIamPolicy' => $defaultDescriptors,
            'testIamPermissions' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/database_admin_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.spanner.admin.database.v1.DatabaseAdmin',
                    $clientConfig,
                    $options['retryingOverride'],
                    GrpcConstants::getStatusCodeNames(),
                    $options['timeoutMillis']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (!empty($options['sslCreds'])) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);

        $createDatabaseAdminStubFunction = function ($hostname, $opts) {
            return new DatabaseAdminClient($hostname, $opts);
        };
        $this->databaseAdminStub = $this->grpcCredentialsHelper->createStub(
            $createDatabaseAdminStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Lists Cloud Spanner databases.
     *
     * Sample code:
     * ```
     * try {
     *     $databaseAdminApi = new DatabaseAdminApi();
     *     $formattedName = DatabaseAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     foreach ($databaseAdminApi->listDatabases($formattedName) as $element) {
     *         // doThingsWith(element);
     *     }
     * } finally {
     *     if (isset($databaseAdminApi)) {
     *         $databaseAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The project whose databases should be listed. Required.
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
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return Google\GAX\PagedListResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function listDatabases($name, $optionalArgs = [])
    {
        $request = new ListDatabasesRequest();
        $request->setName($name);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listDatabases']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->databaseAdminStub,
            'ListDatabases',
            $mergedSettings,
            $this->descriptors['listDatabases']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a new Cloud Spanner database.
     *
     * Sample code:
     * ```
     * try {
     *     $databaseAdminApi = new DatabaseAdminApi();
     *     $formattedName = DatabaseAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $createStatement = "";
     *     $response = $databaseAdminApi->createDatabase($formattedName, $createStatement);
     * } finally {
     *     if (isset($databaseAdminApi)) {
     *         $databaseAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name            The name of the instance that will serve the new database.
     *                                Values are of the form `projects/<project>/instances/<instance>`.
     * @param string $createStatement A `CREATE DATABASE` statement, which specifies the name of the
     *                                new database.  The database name must conform to the regular expression
     *                                `[a-z][a-z0-9_\-]*[a-z0-9]` and be between 2 and 30 characters in length.
     * @param array  $optionalArgs    {
     *                                Optional.
     *
     *     @type string[] $extraStatements
     *          An optional list of DDL statements to run inside the newly created
     *          database. Statements can create tables, indexes, etc. These
     *          statements execute atomically with the creation of the database:
     *          if there is an error in any statement, the database is not created.
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\spanner\admin\database\v1\Database
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function createDatabase($name, $createStatement, $optionalArgs = [])
    {
        $request = new CreateDatabaseRequest();
        $request->setName($name);
        $request->setCreateStatement($createStatement);
        if (isset($optionalArgs['extraStatements'])) {
            foreach ($optionalArgs['extraStatements'] as $elem) {
                $request->addExtraStatements($elem);
            }
        }

        $mergedSettings = $this->defaultCallSettings['createDatabase']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->databaseAdminStub,
            'CreateDatabase',
            $mergedSettings,
            $this->descriptors['createDatabase']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates the schema of a Cloud Spanner database by
     * creating/altering/dropping tables, columns, indexes, etc.  The
     * [UpdateDatabaseMetadata][google.spanner.admin.database.v1.UpdateDatabaseMetadata] message is used for operation
     * metadata; The operation has no response.
     *
     * Sample code:
     * ```
     * try {
     *     $databaseAdminApi = new DatabaseAdminApi();
     *     $formattedDatabase = DatabaseAdminApi::formatDatabaseName("[PROJECT]", "[INSTANCE]", "[DATABASE]");
     *     $statements = [];
     *     $response = $databaseAdminApi->updateDatabase($formattedDatabase, $statements);
     * } finally {
     *     if (isset($databaseAdminApi)) {
     *         $databaseAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string   $database     The database to update.
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
     *          [UpdateDatabase][google.spanner.admin.database.v1.DatabaseAdmin.UpdateDatabase] call is replayed,
     *          or the return value is otherwise lost: the [database][google.spanner.admin.database.v1.UpdateDatabaseRequest.database] and
     *          `operation_id` fields can be combined to form the
     *          [name][google.longrunning.Operation.name] of the resulting
     *          [longrunning.Operation][google.longrunning.Operation]: `<database>/operations/<operation_id>`.
     *
     *          `operation_id` should be unique within the database, and must be
     *          a valid identifier: `[a-zA-Z][a-zA-Z0-9_]*`. Note that
     *          automatically-generated operation IDs always begin with an
     *          underscore. If the named operation already exists,
     *          [UpdateDatabase][google.spanner.admin.database.v1.DatabaseAdmin.UpdateDatabase] returns
     *          `ALREADY_EXISTS`.
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\longrunning\Operation
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function updateDatabase($database, $statements, $optionalArgs = [])
    {
        $request = new UpdateDatabaseRequest();
        $request->setDatabase($database);
        foreach ($statements as $elem) {
            $request->addStatements($elem);
        }
        if (isset($optionalArgs['operationId'])) {
            $request->setOperationId($optionalArgs['operationId']);
        }

        $mergedSettings = $this->defaultCallSettings['updateDatabase']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->databaseAdminStub,
            'UpdateDatabase',
            $mergedSettings,
            $this->descriptors['updateDatabase']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Drops (aka deletes) a Cloud Spanner database.
     *
     * Sample code:
     * ```
     * try {
     *     $databaseAdminApi = new DatabaseAdminApi();
     *     $formattedDatabase = DatabaseAdminApi::formatDatabaseName("[PROJECT]", "[INSTANCE]", "[DATABASE]");
     *     $databaseAdminApi->dropDatabase($formattedDatabase);
     * } finally {
     *     if (isset($databaseAdminApi)) {
     *         $databaseAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $database     The database to be dropped.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function dropDatabase($database, $optionalArgs = [])
    {
        $request = new DropDatabaseRequest();
        $request->setDatabase($database);

        $mergedSettings = $this->defaultCallSettings['dropDatabase']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->databaseAdminStub,
            'DropDatabase',
            $mergedSettings,
            $this->descriptors['dropDatabase']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns the schema of a Cloud Spanner database as a list of formatted
     * DDL statements. This method does not show pending schema updates, those may
     * be queried using the [Operations][google.longrunning.Operations] API.
     *
     * Sample code:
     * ```
     * try {
     *     $databaseAdminApi = new DatabaseAdminApi();
     *     $formattedDatabase = DatabaseAdminApi::formatDatabaseName("[PROJECT]", "[INSTANCE]", "[DATABASE]");
     *     $response = $databaseAdminApi->getDatabaseDDL($formattedDatabase);
     * } finally {
     *     if (isset($databaseAdminApi)) {
     *         $databaseAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $database     The database whose schema we wish to get.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\spanner\admin\database\v1\GetDatabaseDDLResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function getDatabaseDDL($database, $optionalArgs = [])
    {
        $request = new GetDatabaseDDLRequest();
        $request->setDatabase($database);

        $mergedSettings = $this->defaultCallSettings['getDatabaseDDL']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->databaseAdminStub,
            'GetDatabaseDDL',
            $mergedSettings,
            $this->descriptors['getDatabaseDDL']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the access control policy on a database resource. Replaces any
     * existing policy.
     *
     * Sample code:
     * ```
     * try {
     *     $databaseAdminApi = new DatabaseAdminApi();
     *     $formattedResource = DatabaseAdminApi::formatDatabaseName("[PROJECT]", "[INSTANCE]", "[DATABASE]");
     *     $policy = new Policy();
     *     $response = $databaseAdminApi->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     if (isset($databaseAdminApi)) {
     *         $databaseAdminApi->close();
     *     }
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
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\iam\v1\Policy
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function setIamPolicy($resource, $policy, $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        $request->setResource($resource);
        $request->setPolicy($policy);

        $mergedSettings = $this->defaultCallSettings['setIamPolicy']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->databaseAdminStub,
            'SetIamPolicy',
            $mergedSettings,
            $this->descriptors['setIamPolicy']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets the access control policy for a database resource. Returns an empty
     * policy if a database exists but does not have a policy set.
     *
     * Sample code:
     * ```
     * try {
     *     $databaseAdminApi = new DatabaseAdminApi();
     *     $formattedResource = DatabaseAdminApi::formatDatabaseName("[PROJECT]", "[INSTANCE]", "[DATABASE]");
     *     $response = $databaseAdminApi->getIamPolicy($formattedResource);
     * } finally {
     *     if (isset($databaseAdminApi)) {
     *         $databaseAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\iam\v1\Policy
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function getIamPolicy($resource, $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        $request->setResource($resource);

        $mergedSettings = $this->defaultCallSettings['getIamPolicy']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->databaseAdminStub,
            'GetIamPolicy',
            $mergedSettings,
            $this->descriptors['getIamPolicy']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns permissions that the caller has on the specified database resource.
     *
     * Sample code:
     * ```
     * try {
     *     $databaseAdminApi = new DatabaseAdminApi();
     *     $formattedResource = DatabaseAdminApi::formatDatabaseName("[PROJECT]", "[INSTANCE]", "[DATABASE]");
     *     $permissions = [];
     *     $response = $databaseAdminApi->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     if (isset($databaseAdminApi)) {
     *         $databaseAdminApi->close();
     *     }
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
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\iam\v1\TestIamPermissionsResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function testIamPermissions($resource, $permissions, $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        foreach ($permissions as $elem) {
            $request->addPermissions($elem);
        }

        $mergedSettings = $this->defaultCallSettings['testIamPermissions']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->databaseAdminStub,
            'TestIamPermissions',
            $mergedSettings,
            $this->descriptors['testIamPermissions']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     */
    public function close()
    {
        $this->databaseAdminStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
