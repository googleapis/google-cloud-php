<?php
/*
 * Copyright 2017, Google Inc. All rights reserved.
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

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/spanner/v1/spanner.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Spanner\V1;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PathTemplate;
use Google\Protobuf\Struct;
use Google\Spanner\V1\BeginTransactionRequest;
use Google\Spanner\V1\CommitRequest;
use Google\Spanner\V1\CreateSessionRequest;
use Google\Spanner\V1\DeleteSessionRequest;
use Google\Spanner\V1\ExecuteSqlRequest;
use Google\Spanner\V1\ExecuteSqlRequest_QueryMode as QueryMode;
use Google\Spanner\V1\GetSessionRequest;
use Google\Spanner\V1\KeySet;
use Google\Spanner\V1\Mutation;
use Google\Spanner\V1\ReadRequest;
use Google\Spanner\V1\RollbackRequest;
use Google\Spanner\V1\SpannerGrpcClient;
use Google\Spanner\V1\TransactionOptions;
use Google\Spanner\V1\TransactionSelector;

/**
 * Service Description: Cloud Spanner API.
 *
 * The Cloud Spanner API can be used to manage sessions and execute
 * transactions on data stored in Cloud Spanner databases.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $spannerClient = new SpannerClient();
 *     $formattedDatabase = SpannerClient::formatDatabaseName("[PROJECT]", "[INSTANCE]", "[DATABASE]");
 *     $response = $spannerClient->createSession($formattedDatabase);
 * } finally {
 *     $spannerClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 *
 * @experimental
 */
class SpannerClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'spanner.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The default timeout for non-retrying methods.
     */
    const DEFAULT_TIMEOUT_MILLIS = 30000;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $databaseNameTemplate;
    private static $sessionNameTemplate;

    private $grpcCredentialsHelper;
    private $spannerStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

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
    public static function formatDatabaseName($project, $instance, $database)
    {
        return self::getDatabaseNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'database' => $database,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a session resource.
     *
     * @param string $project
     * @param string $instance
     * @param string $database
     * @param string $session
     *
     * @return string The formatted session resource.
     * @experimental
     */
    public static function formatSessionName($project, $instance, $database, $session)
    {
        return self::getSessionNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'database' => $database,
            'session' => $session,
        ]);
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a database resource.
     *
     * @param string $databaseName The fully-qualified database resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromDatabaseName($databaseName)
    {
        return self::getDatabaseNameTemplate()->match($databaseName)['project'];
    }

    /**
     * Parses the instance from the given fully-qualified path which
     * represents a database resource.
     *
     * @param string $databaseName The fully-qualified database resource.
     *
     * @return string The extracted instance value.
     * @experimental
     */
    public static function parseInstanceFromDatabaseName($databaseName)
    {
        return self::getDatabaseNameTemplate()->match($databaseName)['instance'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a database resource.
     *
     * @param string $databaseName The fully-qualified database resource.
     *
     * @return string The extracted database value.
     * @experimental
     */
    public static function parseDatabaseFromDatabaseName($databaseName)
    {
        return self::getDatabaseNameTemplate()->match($databaseName)['database'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a session resource.
     *
     * @param string $sessionName The fully-qualified session resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromSessionName($sessionName)
    {
        return self::getSessionNameTemplate()->match($sessionName)['project'];
    }

    /**
     * Parses the instance from the given fully-qualified path which
     * represents a session resource.
     *
     * @param string $sessionName The fully-qualified session resource.
     *
     * @return string The extracted instance value.
     * @experimental
     */
    public static function parseInstanceFromSessionName($sessionName)
    {
        return self::getSessionNameTemplate()->match($sessionName)['instance'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a session resource.
     *
     * @param string $sessionName The fully-qualified session resource.
     *
     * @return string The extracted database value.
     * @experimental
     */
    public static function parseDatabaseFromSessionName($sessionName)
    {
        return self::getSessionNameTemplate()->match($sessionName)['database'];
    }

    /**
     * Parses the session from the given fully-qualified path which
     * represents a session resource.
     *
     * @param string $sessionName The fully-qualified session resource.
     *
     * @return string The extracted session value.
     * @experimental
     */
    public static function parseSessionFromSessionName($sessionName)
    {
        return self::getSessionNameTemplate()->match($sessionName)['session'];
    }

    private static function getDatabaseNameTemplate()
    {
        if (self::$databaseNameTemplate == null) {
            self::$databaseNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/databases/{database}');
        }

        return self::$databaseNameTemplate;
    }

    private static function getSessionNameTemplate()
    {
        if (self::$sessionNameTemplate == null) {
            self::$sessionNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/databases/{database}/sessions/{session}');
        }

        return self::$sessionNameTemplate;
    }

    private static function getGrpcStreamingDescriptors()
    {
        return [
            'executeStreamingSql' => [
                'grpcStreamingType' => 'ServerStreaming',
            ],
            'streamingRead' => [
                'grpcStreamingType' => 'ServerStreaming',
            ],
        ];
    }

    private static function getGapicVersion()
    {
        if (file_exists(__DIR__.'/../VERSION')) {
            return trim(file_get_contents(__DIR__.'/../VERSION'));
        } elseif (class_exists('\Google\Cloud\ServiceBuilder')) {
            return \Google\Cloud\ServiceBuilder::VERSION;
        } else {
            return;
        }
    }

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'spanner.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Cloud Spanner API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *                              A CredentialsLoader object created using the
     *                              Google\Auth library.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
                'https://www.googleapis.com/auth/spanner.data',
            ],
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'libName' => null,
            'libVersion' => null,
        ];
        $options = array_merge($defaultOptions, $options);

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'createSession' => $defaultDescriptors,
            'getSession' => $defaultDescriptors,
            'deleteSession' => $defaultDescriptors,
            'executeSql' => $defaultDescriptors,
            'executeStreamingSql' => $defaultDescriptors,
            'read' => $defaultDescriptors,
            'streamingRead' => $defaultDescriptors,
            'beginTransaction' => $defaultDescriptors,
            'commit' => $defaultDescriptors,
            'rollback' => $defaultDescriptors,
        ];
        $grpcStreamingDescriptors = self::getGrpcStreamingDescriptors();
        foreach ($grpcStreamingDescriptors as $method => $grpcStreamingDescriptor) {
            $this->descriptors[$method]['grpcStreamingDescriptor'] = $grpcStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/spanner_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.spanner.v1.Spanner',
                    $clientConfig,
                    $options['retryingOverride'],
                    GrpcConstants::getStatusCodeNames(),
                    $options['timeoutMillis']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);

        $createSpannerStubFunction = function ($hostname, $opts) {
            return new SpannerGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createSpannerStubFunction', $options)) {
            $createSpannerStubFunction = $options['createSpannerStubFunction'];
        }
        $this->spannerStub = $this->grpcCredentialsHelper->createStub(
            $createSpannerStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Creates a new session. A session can be used to perform
     * transactions that read and/or modify data in a Cloud Spanner database.
     * Sessions are meant to be reused for many consecutive
     * transactions.
     *
     * Sessions can only execute one transaction at a time. To execute
     * multiple concurrent read-write/write-only transactions, create
     * multiple sessions. Note that standalone reads and queries use a
     * transaction internally, and count toward the one transaction
     * limit.
     *
     * Cloud Spanner limits the number of sessions that can exist at any given
     * time; thus, it is a good idea to delete idle and/or unneeded sessions.
     * Aside from explicit deletes, Cloud Spanner can delete sessions for which no
     * operations are sent for more than an hour. If a session is deleted,
     * requests to it return `NOT_FOUND`.
     *
     * Idle sessions can be kept alive by sending a trivial SQL query
     * periodically, e.g., `"SELECT 1"`.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedDatabase = SpannerClient::formatDatabaseName("[PROJECT]", "[INSTANCE]", "[DATABASE]");
     *     $response = $spannerClient->createSession($formattedDatabase);
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string $database     Required. The database in which the new session is created.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Spanner\V1\Session
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createSession($database, $optionalArgs = [])
    {
        $request = new CreateSessionRequest();
        $request->setDatabase($database);

        $mergedSettings = $this->defaultCallSettings['createSession']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'CreateSession',
            $mergedSettings,
            $this->descriptors['createSession']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets a session. Returns `NOT_FOUND` if the session does not exist.
     * This is mainly useful for determining whether a session is still
     * alive.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedName = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $response = $spannerClient->getSession($formattedName);
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the session to retrieve.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Spanner\V1\Session
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getSession($name, $optionalArgs = [])
    {
        $request = new GetSessionRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getSession']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'GetSession',
            $mergedSettings,
            $this->descriptors['getSession']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Ends a session, releasing server resources associated with it.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedName = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $spannerClient->deleteSession($formattedName);
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the session to delete.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function deleteSession($name, $optionalArgs = [])
    {
        $request = new DeleteSessionRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['deleteSession']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'DeleteSession',
            $mergedSettings,
            $this->descriptors['deleteSession']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Executes an SQL query, returning all rows in a single reply. This
     * method cannot be used to return a result set larger than 10 MiB;
     * if the query yields more data than that, the query fails with
     * a `FAILED_PRECONDITION` error.
     *
     * Queries inside read-write transactions might return `ABORTED`. If
     * this occurs, the application should restart the transaction from
     * the beginning. See [Transaction][google.spanner.v1.Transaction] for more details.
     *
     * Larger result sets can be fetched in streaming fashion by calling
     * [ExecuteStreamingSql][google.spanner.v1.Spanner.ExecuteStreamingSql] instead.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedSession = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $sql = "";
     *     $response = $spannerClient->executeSql($formattedSession, $sql);
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string $session      Required. The session in which the SQL query should be performed.
     * @param string $sql          Required. The SQL query string.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type TransactionSelector $transaction
     *          The transaction to use. If none is provided, the default is a
     *          temporary read-only transaction with strong concurrency.
     *     @type Struct $params
     *          The SQL query string can contain parameter placeholders. A parameter
     *          placeholder consists of `'&#64;'` followed by the parameter
     *          name. Parameter names consist of any combination of letters,
     *          numbers, and underscores.
     *
     *          Parameters can appear anywhere that a literal value is expected.  The same
     *          parameter name can be used more than once, for example:
     *            `"WHERE id > &#64;msg_id AND id < &#64;msg_id + 100"`
     *
     *          It is an error to execute an SQL query with unbound parameters.
     *
     *          Parameter values are specified using `params`, which is a JSON
     *          object whose keys are parameter names, and whose values are the
     *          corresponding parameter values.
     *     @type array $paramTypes
     *          It is not always possible for Cloud Spanner to infer the right SQL type
     *          from a JSON value.  For example, values of type `BYTES` and values
     *          of type `STRING` both appear in [params][google.spanner.v1.ExecuteSqlRequest.params] as JSON strings.
     *
     *          In these cases, `param_types` can be used to specify the exact
     *          SQL type for some or all of the SQL query parameters. See the
     *          definition of [Type][google.spanner.v1.Type] for more information
     *          about SQL types.
     *     @type string $resumeToken
     *          If this request is resuming a previously interrupted SQL query
     *          execution, `resume_token` should be copied from the last
     *          [PartialResultSet][google.spanner.v1.PartialResultSet] yielded before the interruption. Doing this
     *          enables the new SQL query execution to resume where the last one left
     *          off. The rest of the request parameters must exactly match the
     *          request that yielded this token.
     *     @type int $queryMode
     *          Used to control the amount of debugging information returned in
     *          [ResultSetStats][google.spanner.v1.ResultSetStats].
     *          For allowed values, use constants defined on {@see \Google\Spanner\V1\ExecuteSqlRequest_QueryMode}
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Spanner\V1\ResultSet
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function executeSql($session, $sql, $optionalArgs = [])
    {
        $request = new ExecuteSqlRequest();
        $request->setSession($session);
        $request->setSql($sql);
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }
        if (isset($optionalArgs['params'])) {
            $request->setParams($optionalArgs['params']);
        }
        if (isset($optionalArgs['paramTypes'])) {
            $request->setParamTypes($optionalArgs['paramTypes']);
        }
        if (isset($optionalArgs['resumeToken'])) {
            $request->setResumeToken($optionalArgs['resumeToken']);
        }
        if (isset($optionalArgs['queryMode'])) {
            $request->setQueryMode($optionalArgs['queryMode']);
        }

        $mergedSettings = $this->defaultCallSettings['executeSql']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'ExecuteSql',
            $mergedSettings,
            $this->descriptors['executeSql']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Like [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql], except returns the result
     * set as a stream. Unlike [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql], there
     * is no limit on the size of the returned result set. However, no
     * individual row in the result set can exceed 100 MiB, and no
     * column value can exceed 10 MiB.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedSession = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $sql = "";
     *     // Read all responses until the stream is complete
     *     $stream = $spannerClient->executeStreamingSql($formattedSession, $sql);
     *     foreach ($stream->readAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string $session      Required. The session in which the SQL query should be performed.
     * @param string $sql          Required. The SQL query string.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type TransactionSelector $transaction
     *          The transaction to use. If none is provided, the default is a
     *          temporary read-only transaction with strong concurrency.
     *     @type Struct $params
     *          The SQL query string can contain parameter placeholders. A parameter
     *          placeholder consists of `'&#64;'` followed by the parameter
     *          name. Parameter names consist of any combination of letters,
     *          numbers, and underscores.
     *
     *          Parameters can appear anywhere that a literal value is expected.  The same
     *          parameter name can be used more than once, for example:
     *            `"WHERE id > &#64;msg_id AND id < &#64;msg_id + 100"`
     *
     *          It is an error to execute an SQL query with unbound parameters.
     *
     *          Parameter values are specified using `params`, which is a JSON
     *          object whose keys are parameter names, and whose values are the
     *          corresponding parameter values.
     *     @type array $paramTypes
     *          It is not always possible for Cloud Spanner to infer the right SQL type
     *          from a JSON value.  For example, values of type `BYTES` and values
     *          of type `STRING` both appear in [params][google.spanner.v1.ExecuteSqlRequest.params] as JSON strings.
     *
     *          In these cases, `param_types` can be used to specify the exact
     *          SQL type for some or all of the SQL query parameters. See the
     *          definition of [Type][google.spanner.v1.Type] for more information
     *          about SQL types.
     *     @type string $resumeToken
     *          If this request is resuming a previously interrupted SQL query
     *          execution, `resume_token` should be copied from the last
     *          [PartialResultSet][google.spanner.v1.PartialResultSet] yielded before the interruption. Doing this
     *          enables the new SQL query execution to resume where the last one left
     *          off. The rest of the request parameters must exactly match the
     *          request that yielded this token.
     *     @type int $queryMode
     *          Used to control the amount of debugging information returned in
     *          [ResultSetStats][google.spanner.v1.ResultSetStats].
     *          For allowed values, use constants defined on {@see \Google\Spanner\V1\ExecuteSqlRequest_QueryMode}
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\GAX\ServerStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function executeStreamingSql($session, $sql, $optionalArgs = [])
    {
        $request = new ExecuteSqlRequest();
        $request->setSession($session);
        $request->setSql($sql);
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }
        if (isset($optionalArgs['params'])) {
            $request->setParams($optionalArgs['params']);
        }
        if (isset($optionalArgs['paramTypes'])) {
            $request->setParamTypes($optionalArgs['paramTypes']);
        }
        if (isset($optionalArgs['resumeToken'])) {
            $request->setResumeToken($optionalArgs['resumeToken']);
        }
        if (isset($optionalArgs['queryMode'])) {
            $request->setQueryMode($optionalArgs['queryMode']);
        }

        $mergedSettings = $this->defaultCallSettings['executeStreamingSql']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'ExecuteStreamingSql',
            $mergedSettings,
            $this->descriptors['executeStreamingSql']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Reads rows from the database using key lookups and scans, as a
     * simple key/value style alternative to
     * [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql].  This method cannot be used to
     * return a result set larger than 10 MiB; if the read matches more
     * data than that, the read fails with a `FAILED_PRECONDITION`
     * error.
     *
     * Reads inside read-write transactions might return `ABORTED`. If
     * this occurs, the application should restart the transaction from
     * the beginning. See [Transaction][google.spanner.v1.Transaction] for more details.
     *
     * Larger result sets can be yielded in streaming fashion by calling
     * [StreamingRead][google.spanner.v1.Spanner.StreamingRead] instead.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedSession = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $table = "";
     *     $columns = [];
     *     $keySet = new KeySet();
     *     $response = $spannerClient->read($formattedSession, $table, $columns, $keySet);
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string   $session Required. The session in which the read should be performed.
     * @param string   $table   Required. The name of the table in the database to be read.
     * @param string[] $columns The columns of [table][google.spanner.v1.ReadRequest.table] to be returned for each row matching
     *                          this request.
     * @param KeySet   $keySet  Required. `key_set` identifies the rows to be yielded. `key_set` names the
     *                          primary keys of the rows in [table][google.spanner.v1.ReadRequest.table] to be yielded, unless [index][google.spanner.v1.ReadRequest.index]
     *                          is present. If [index][google.spanner.v1.ReadRequest.index] is present, then [key_set][google.spanner.v1.ReadRequest.key_set] instead names
     *                          index keys in [index][google.spanner.v1.ReadRequest.index].
     *
     * Rows are yielded in table primary key order (if [index][google.spanner.v1.ReadRequest.index] is empty)
     * or index key order (if [index][google.spanner.v1.ReadRequest.index] is non-empty).
     *
     * It is not an error for the `key_set` to name rows that do not
     * exist in the database. Read yields nothing for nonexistent rows.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type TransactionSelector $transaction
     *          The transaction to use. If none is provided, the default is a
     *          temporary read-only transaction with strong concurrency.
     *     @type string $index
     *          If non-empty, the name of an index on [table][google.spanner.v1.ReadRequest.table]. This index is
     *          used instead of the table primary key when interpreting [key_set][google.spanner.v1.ReadRequest.key_set]
     *          and sorting result rows. See [key_set][google.spanner.v1.ReadRequest.key_set] for further information.
     *     @type int $limit
     *          If greater than zero, only the first `limit` rows are yielded. If `limit`
     *          is zero, the default is no limit.
     *     @type string $resumeToken
     *          If this request is resuming a previously interrupted read,
     *          `resume_token` should be copied from the last
     *          [PartialResultSet][google.spanner.v1.PartialResultSet] yielded before the interruption. Doing this
     *          enables the new read to resume where the last read left off. The
     *          rest of the request parameters must exactly match the request
     *          that yielded this token.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Spanner\V1\ResultSet
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function read($session, $table, $columns, $keySet, $optionalArgs = [])
    {
        $request = new ReadRequest();
        $request->setSession($session);
        $request->setTable($table);
        $request->setColumns($columns);
        $request->setKeySet($keySet);
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }
        if (isset($optionalArgs['index'])) {
            $request->setIndex($optionalArgs['index']);
        }
        if (isset($optionalArgs['limit'])) {
            $request->setLimit($optionalArgs['limit']);
        }
        if (isset($optionalArgs['resumeToken'])) {
            $request->setResumeToken($optionalArgs['resumeToken']);
        }

        $mergedSettings = $this->defaultCallSettings['read']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'Read',
            $mergedSettings,
            $this->descriptors['read']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Like [Read][google.spanner.v1.Spanner.Read], except returns the result set as a
     * stream. Unlike [Read][google.spanner.v1.Spanner.Read], there is no limit on the
     * size of the returned result set. However, no individual row in
     * the result set can exceed 100 MiB, and no column value can exceed
     * 10 MiB.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedSession = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $table = "";
     *     $columns = [];
     *     $keySet = new KeySet();
     *     // Read all responses until the stream is complete
     *     $stream = $spannerClient->streamingRead($formattedSession, $table, $columns, $keySet);
     *     foreach ($stream->readAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string   $session Required. The session in which the read should be performed.
     * @param string   $table   Required. The name of the table in the database to be read.
     * @param string[] $columns The columns of [table][google.spanner.v1.ReadRequest.table] to be returned for each row matching
     *                          this request.
     * @param KeySet   $keySet  Required. `key_set` identifies the rows to be yielded. `key_set` names the
     *                          primary keys of the rows in [table][google.spanner.v1.ReadRequest.table] to be yielded, unless [index][google.spanner.v1.ReadRequest.index]
     *                          is present. If [index][google.spanner.v1.ReadRequest.index] is present, then [key_set][google.spanner.v1.ReadRequest.key_set] instead names
     *                          index keys in [index][google.spanner.v1.ReadRequest.index].
     *
     * Rows are yielded in table primary key order (if [index][google.spanner.v1.ReadRequest.index] is empty)
     * or index key order (if [index][google.spanner.v1.ReadRequest.index] is non-empty).
     *
     * It is not an error for the `key_set` to name rows that do not
     * exist in the database. Read yields nothing for nonexistent rows.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type TransactionSelector $transaction
     *          The transaction to use. If none is provided, the default is a
     *          temporary read-only transaction with strong concurrency.
     *     @type string $index
     *          If non-empty, the name of an index on [table][google.spanner.v1.ReadRequest.table]. This index is
     *          used instead of the table primary key when interpreting [key_set][google.spanner.v1.ReadRequest.key_set]
     *          and sorting result rows. See [key_set][google.spanner.v1.ReadRequest.key_set] for further information.
     *     @type int $limit
     *          If greater than zero, only the first `limit` rows are yielded. If `limit`
     *          is zero, the default is no limit.
     *     @type string $resumeToken
     *          If this request is resuming a previously interrupted read,
     *          `resume_token` should be copied from the last
     *          [PartialResultSet][google.spanner.v1.PartialResultSet] yielded before the interruption. Doing this
     *          enables the new read to resume where the last read left off. The
     *          rest of the request parameters must exactly match the request
     *          that yielded this token.
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\GAX\ServerStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function streamingRead($session, $table, $columns, $keySet, $optionalArgs = [])
    {
        $request = new ReadRequest();
        $request->setSession($session);
        $request->setTable($table);
        $request->setColumns($columns);
        $request->setKeySet($keySet);
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }
        if (isset($optionalArgs['index'])) {
            $request->setIndex($optionalArgs['index']);
        }
        if (isset($optionalArgs['limit'])) {
            $request->setLimit($optionalArgs['limit']);
        }
        if (isset($optionalArgs['resumeToken'])) {
            $request->setResumeToken($optionalArgs['resumeToken']);
        }

        $mergedSettings = $this->defaultCallSettings['streamingRead']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'StreamingRead',
            $mergedSettings,
            $this->descriptors['streamingRead']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Begins a new transaction. This step can often be skipped:
     * [Read][google.spanner.v1.Spanner.Read], [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql] and
     * [Commit][google.spanner.v1.Spanner.Commit] can begin a new transaction as a
     * side-effect.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedSession = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $options = new TransactionOptions();
     *     $response = $spannerClient->beginTransaction($formattedSession, $options);
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string             $session      Required. The session in which the transaction runs.
     * @param TransactionOptions $options      Required. Options for the new transaction.
     * @param array              $optionalArgs {
     *                                         Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Spanner\V1\Transaction
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function beginTransaction($session, $options, $optionalArgs = [])
    {
        $request = new BeginTransactionRequest();
        $request->setSession($session);
        $request->setOptions($options);

        $mergedSettings = $this->defaultCallSettings['beginTransaction']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'BeginTransaction',
            $mergedSettings,
            $this->descriptors['beginTransaction']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Commits a transaction. The request includes the mutations to be
     * applied to rows in the database.
     *
     * `Commit` might return an `ABORTED` error. This can occur at any time;
     * commonly, the cause is conflicts with concurrent
     * transactions. However, it can also happen for a variety of other
     * reasons. If `Commit` returns `ABORTED`, the caller should re-attempt
     * the transaction from the beginning, re-using the same session.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedSession = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $mutations = [];
     *     $response = $spannerClient->commit($formattedSession, $mutations);
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string     $session      Required. The session in which the transaction to be committed is running.
     * @param Mutation[] $mutations    The mutations to be executed when this transaction commits. All
     *                                 mutations are applied atomically, in the order they appear in
     *                                 this list.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type string $transactionId
     *          Commit a previously-started transaction.
     *     @type TransactionOptions $singleUseTransaction
     *          Execute mutations in a temporary transaction. Note that unlike
     *          commit of a previously-started transaction, commit with a
     *          temporary transaction is non-idempotent. That is, if the
     *          `CommitRequest` is sent to Cloud Spanner more than once (for
     *          instance, due to retries in the application, or in the
     *          transport library), it is possible that the mutations are
     *          executed more than once. If this is undesirable, use
     *          [BeginTransaction][google.spanner.v1.Spanner.BeginTransaction] and
     *          [Commit][google.spanner.v1.Spanner.Commit] instead.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Spanner\V1\CommitResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function commit($session, $mutations, $optionalArgs = [])
    {
        $request = new CommitRequest();
        $request->setSession($session);
        $request->setMutations($mutations);
        if (isset($optionalArgs['transactionId'])) {
            $request->setTransactionId($optionalArgs['transactionId']);
        }
        if (isset($optionalArgs['singleUseTransaction'])) {
            $request->setSingleUseTransaction($optionalArgs['singleUseTransaction']);
        }

        $mergedSettings = $this->defaultCallSettings['commit']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'Commit',
            $mergedSettings,
            $this->descriptors['commit']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Rolls back a transaction, releasing any locks it holds. It is a good
     * idea to call this for any transaction that includes one or more
     * [Read][google.spanner.v1.Spanner.Read] or [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql] requests and
     * ultimately decides not to commit.
     *
     * `Rollback` returns `OK` if it successfully aborts the transaction, the
     * transaction was already aborted, or the transaction is not
     * found. `Rollback` never returns `ABORTED`.
     *
     * Sample code:
     * ```
     * try {
     *     $spannerClient = new SpannerClient();
     *     $formattedSession = SpannerClient::formatSessionName("[PROJECT]", "[INSTANCE]", "[DATABASE]", "[SESSION]");
     *     $transactionId = "";
     *     $spannerClient->rollback($formattedSession, $transactionId);
     * } finally {
     *     $spannerClient->close();
     * }
     * ```
     *
     * @param string $session       Required. The session in which the transaction to roll back is running.
     * @param string $transactionId Required. The transaction to roll back.
     * @param array  $optionalArgs  {
     *                              Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function rollback($session, $transactionId, $optionalArgs = [])
    {
        $request = new RollbackRequest();
        $request->setSession($session);
        $request->setTransactionId($transactionId);

        $mergedSettings = $this->defaultCallSettings['rollback']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->spannerStub,
            'Rollback',
            $mergedSettings,
            $this->descriptors['rollback']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     *
     * @experimental
     */
    public function close()
    {
        $this->spannerStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
