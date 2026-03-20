<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Logging;

use Google\ApiCore\ClientOptionsTrait;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\ClosureSerializerInterface;
use Google\Cloud\Core\DetectProjectIdTrait;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\Report\MetadataProviderInterface;
use Google\Cloud\Logging\Connection\Gapic;

/**
 * Google Stackdriver Logging allows you to store, search, analyze, monitor, and
 * alert on log data and events from Google Cloud Platform and Amazon Web
 * Services. Find more information at the
 * [Google Stackdriver Logging docs](https://cloud.google.com/logging/docs/).
 *
 * This client supports transport over
 * [REST](https://cloud.google.com/logging/docs/api/reference/rest/) or
 * gRPC.
 *
 * In order to enable gRPC support please make sure to install and enable
 * the gRPC extension through PECL:
 *
 * ```sh
 * $ pecl install grpc
 * ```
 *
 * NOTE: Support for gRPC is currently at an Alpha quality level, meaning it is still
 * a work in progress and is more likely to get backwards-incompatible updates.
 *
 * When using gRPC in production environments, it is highly recommended that you make use of the
 * Protobuf PHP extension for improved performance. Protobuf can be installed
 * via [PECL](https://pecl.php.net).
 *
 * ```
 * $ pecl install protobuf
 * ```
 *
 * Example:
 * ```
 * use Google\Cloud\Logging\LoggingClient;
 *
 * $logging = new LoggingClient();
 * ```
 */
class LoggingClient
{
    use DetectProjectIdTrait;
    use ClientOptionsTrait;

    const VERSION = '2.0.0-RC1';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/logging.admin';
    const READ_ONLY_SCOPE = 'https://www.googleapis.com/auth/logging.read';
    const WRITE_ONLY_SCOPE = 'https://www.googleapis.com/auth/logging.write';

    /**
     * @var Gapic Represents a connection to Stackdriver Logging.
     * @internal
     */
    protected Gapic $connection;

    /**
     * @var string The formatted name used in API requests.
     */
    private string $formattedProjectName;

    /**
     * Create a PsrLogger with batching enabled.
     *
     * @param string $name The name of the log to write entries to.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $apiEndpoint A hostname with optional port to use in
     *           place of the service's default endpoint.
     *     @type string $messageKey The key in the `jsonPayload` used to contain
     *           the logged message. **Defaults to** `message`.
     *     @type array $resource The
     *           [monitored resource](https://cloud.google.com/logging/docs/api/reference/rest/v2/MonitoredResource)
     *           to associate log entries with. **Defaults to** type global.
     *     @type array $labels A set of user-defined (key, value) data that
     *           provides additional information about the log entry.
     *     @type MetadataProviderInterface $metadataProvider **Defaults to** An
     *           automatically chosen provider, based on detected environment
     *           settings.
     *     @type bool $debugOutput Whether or not to output debug information.
     *           Please note debug output currently only applies in CLI based
     *           applications. **Defaults to** `false`.
     *     @type array $batchOptions A set of options for a BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()} for
     *           more details.
     *           **Defaults to** ['batchSize' => 1000,
     *                            'callPeriod' => 2.0,
     *                            'numWorkers' => 2].
     *     @type array $clientConfig Configuration options for the Logging client
     *           used to handle processing of batch items. For valid options
     *           please see
     *           {@see \Google\Cloud\Logging\LoggingClient::__construct()}.
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner.
     *     @type ClosureSerializerInterface $closureSerializer An implementation
     *           responsible for serializing closures used in the
     *           `$clientConfig`. This is especially important when using the
     *           batch daemon. **Defaults to**
     *           {@see \Google\Cloud\Core\Batch\OpisClosureSerializer} if the
     *           `opis/closure` library is installed.
     * }
     * @return PsrLogger
     * @experimental The experimental flag means that while we believe this method
     *      or class is ready for use, it may change before release in backwards-
     *      incompatible ways. Please use with caution, and test thoroughly when
     *      upgrading.
     **/
    public static function psrBatchLogger($name, array $options = [])
    {
        $client = new self($options['clientConfig'] ?? []);
        // Force enabling batch.
        $options['batchEnabled'] = true;
        return $client->psrLogger($name, $options);
    }

    /**
     * Create a Logging client.
     *
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $projectId The Google Cloud project ID.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'logging.googleapis.com:443'.
     *     @type FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           This option should only be used with a pre-constructed
     *           {@see FetchAuthTokenInterface} or {@see CredentialsWrapper} object. Note that
     *           when one of these objects are provided, any settings in $credentialsConfig will
     *           be ignored.
     *           **Important**: If you are providing a path to a credentials file, or a decoded
     *           credentials file as a PHP array, this usage is now DEPRECATED. Providing an
     *           unvalidated credential configuration to Google APIs can compromise the security
     *           of your systems and data. It is recommended to create the credentials explicitly
     *           ```
     *           use Google\Auth\Credentials\ServiceAccountCredentials;
     *           use Google\Cloud\Logging\V2\LoggingServiceV2Client;
     *           $creds = new ServiceAccountCredentials($scopes, $json);
     *           $options = new LoggingServiceV2Client(['credentials' => $creds]);
     *           ```
     *           {@see
     *           https://cloud.google.com/docs/authentication/external/externally-sourced-credentials}
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the
     *           client. For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()} .
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either
     *           a path to a JSON file, or a PHP array containing the decoded JSON data. By
     *           default this settings points to the default client config file, which is
     *           provided in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string
     *           `rest` or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already
     *           instantiated {@see \Google\ApiCore\Transport\TransportInterface} object. Note
     *           that when this object is provided, any settings in $transportConfig, and any
     *           $apiEndpoint setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...],
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     *     @type callable $clientCertSource
     *           A callable which returns the client cert as a string. This can be used to
     *           provide a certificate and private key to the transport layer for mTLS.
     *     @type false|LoggerInterface $logger
     *           A PSR-3 compliant logger. If set to false, logging is disabled, ignoring the
     *           'GOOGLE_SDK_PHP_LOGGING' environment flag
     *     @type string $universeDomain
     *           The service domain for the client. Defaults to 'googleapis.com'.
     * }
     */
    public function __construct(private array $config = [])
    {
        $this->connection = new Gapic($config);

        // Detect the project ID
        $detectProjectIdConfig = $this->buildClientOptions($config);
        $detectProjectIdConfig['credentials'] = $this->createCredentialsWrapper(
            $detectProjectIdConfig['credentials'],
            $detectProjectIdConfig['credentialsConfig'],
            $detectProjectIdConfig['universeDomain']
        );

        $this->projectId = $this->detectProjectId($detectProjectIdConfig);
        $this->formattedProjectName = "projects/$this->projectId";
    }

    /**
     * Create a sink.
     *
     * Example:
     * ```
     * $sink = $logging->createSink('my-sink', 'storage.googleapis.com/my-bucket');
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.sinks/create projects.sinks create API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param string $name The name of the sink.
     * @param string $destination The export destination. Please see
     *        [Exporting Logs With Sinks](https://cloud.google.com/logging/docs/api/tasks/exporting-logs#about_sinks)
     *        for more information and examples.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $filter An [advanced logs filter](https://cloud.google.com/logging/docs/view/advanced_filters).
     * }
     * @return Sink
     */
    public function createSink($name, $destination, array $options = [])
    {
        $response =  $this->connection->createSink($options + [
            'parent' => $this->formattedProjectName,
            'name' => $name,
            'destination' => $destination,
        ]);

        return new Sink($this->connection, $name, $this->projectId, $response);
    }

    /**
     * Lazily instantiates a sink. There are no network requests made at this
     * point. To see the operations that can be performed on a sink please see
     * {@see \Google\Cloud\Logging\Sink}.
     *
     * Example:
     * ```
     * $sink = $logging->sink('my-sink');
     * echo $sink->name();
     * ```
     *
     * @param string $name The name of the sink.
     * @return Sink
     */
    public function sink($name)
    {
        return new Sink($this->connection, $name, $this->projectId);
    }

    /**
     * Fetches sinks associated with your project.
     *
     * Example:
     * ```
     * $sinks = $logging->sinks();
     *
     * foreach ($sinks as $sink) {
     *     echo $sink->name() . PHP_EOL;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.sinks/list projects.sinks list API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $pageSize The maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Sink>
     */
    public function sinks(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $sink) {
                    return new Sink($this->connection, $sink['name'], $this->projectId, $sink);
                },
                [$this->connection, 'listSinks'],
                $options + ['parent' => $this->formattedProjectName],
                [
                    'itemsKey' => 'sinks',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Create a metric.
     *
     * Example:
     * ```
     * $metric = $logging->createMetric(
     *     'my-metric',
     *     'logName = projects/my-project/logs/my-log'
     * );
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.metrics/create projects.metrics create API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param string $name The name of the metric.
     * @param string $filter An [advanced logs filter](https://cloud.google.com/logging/docs/view/advanced_filters).
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $description A description of the metric.
     * }
     * @return Metric
     */
    public function createMetric($name, $filter, array $options = [])
    {
        $response =  $this->connection->createLogMetric($options + [
            'parent' => $this->formattedProjectName,
            'name' => $name,
            'filter' => $filter
        ]);

        return new Metric($this->connection, $name, $this->projectId, $response);
    }

    /**
     * Lazily instantiates a metric. There are no network requests made at this
     * point. To see the operations that can be performed on a metric please see
     * {@see \Google\Cloud\Logging\Metric}.
     *
     * Example:
     * ```
     * $metric = $logging->metric('my-metric');
     * echo $metric->name();
     * ```
     *
     * @param string $name The name of the metric.
     * @return Metric
     */
    public function metric($name)
    {
        return new Metric($this->connection, $name, $this->projectId);
    }

    /**
     * Fetches metrics associated with your project.
     *
     * Example:
     * ```
     * $metrics = $logging->metrics();
     *
     * foreach ($metrics as $metric) {
     *     echo $metric->name() . PHP_EOL;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/projects.metrics/list projects.metrics list API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $pageSize The maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Metric>
     */
    public function metrics(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $metric) {
                    return new Metric($this->connection, $metric['name'], $this->projectId, $metric);
                },
                [$this->connection, 'listLogMetrics'],
                $options + ['parent' => $this->formattedProjectName],
                [
                    'itemsKey' => 'metrics',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Fetches log entries.
     *
     * Example:
     * ```
     * $entries = $logging->entries();
     *
     * foreach ($entries as $entry) {
     *     echo $entry->info()['textPayload'] . PHP_EOL;
     * }
     * ```
     *
     * ```
     * // Use an advanced logs filter to fetch only entries from a specified log.
     * $entries = $logging->entries([
     *     'filter' => 'logName = projects/my-project/logs/my-log'
     * ]);
     *
     * foreach ($entries as $entry) {
     *     echo $entry->info()['textPayload'] . PHP_EOL;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/logging/docs/api/reference/rest/v2/entries/list Entries list API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string[] $projectIds A list of projectIds to fetch
     *           entries from in addition to entries found in the project bound
     *           to this client.
     *     @type string[] $resourceNames One or more cloud resources from which
     *           to retrieve log entries. Projects listed in projectIds are
     *           added to this list.
     *           Example: "projects/my-project-1A", "projects/1234567890".
     *     @type string $filter An [advanced logs filter](https://cloud.google.com/logging/docs/view/advanced_filters).
     *     @type string $orderBy How the results should be sorted. Presently,
     *           the only permitted values are `timestamp asc` and
     *           `timestamp desc`. **Defaults to** `"timestamp asc"`.
     *     @type int $pageSize The maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Entry>
     */
    public function entries(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        $resourceNames = ['projects/' . $this->projectId];
        if (isset($options['projectIds'])) {
            foreach ($options['projectIds'] as $projectId) {
                $resourceNames[] = 'projects/' . $projectId;
            }
            unset($options['projectIds']);
        }
        if (isset($options['resourceNames'])) {
            $options['resourceNames'] = array_merge($resourceNames, $options['resourceNames']);
        } else {
            $options['resourceNames'] = $resourceNames;
        }

        return new ItemIterator(
            new PageIterator(
                function (array $entry) {
                    return new Entry($entry);
                },
                [$this->connection, 'listLogEntries'],
                $options,
                [
                    'itemsKey' => 'entries',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Fetches a logger which will write log entries to Stackdriver Logging and
     * implements the PSR-3 specification.
     *
     * Example:
     * ```
     * $psrLogger = $logging->psrLogger('my-log');
     * ```
     *
     * ```
     * // Write entries with background batching.
     * $psrLogger = $logging->psrLogger('my-log', [
     *     'batchEnabled' => true
     * ]);
     * ```
     *
     * @param string $name The name of the log to write entries to.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $messageKey The key in the `jsonPayload` used to contain
     *           the logged message. **Defaults to** `message`.
     *     @type array $resource The
     *           [monitored resource](https://cloud.google.com/logging/docs/api/reference/rest/v2/MonitoredResource)
     *           to associate log entries with. **Defaults to** type global.
     *     @type array $labels A set of user-defined (key, value) data that
     *           provides additional information about the log entry.
     *     @type MetadataProviderInterface $metadataProvider **Defaults to** An
     *           automatically chosen provider, based on detected environment
     *           settings.
     *     @type bool $batchEnabled Determines whether or not to use background
     *           batching. **Defaults to** `false`.
     *     @type bool $debugOutput Whether or not to output debug information.
     *           Please note debug output currently only applies in CLI based
     *           applications. **Defaults to** `false`. Applies only when
     *           `batchEnabled` is set to `true`.
     *     @type resource $debugOutputResource A resource to output debug output
     *           to. Applies only when `batchEnabled` is set to `true`.
     *     @type array $batchOptions A set of options for a BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()} for
     *           more details.
     *           **Defaults to** ['batchSize' => 1000,
     *                            'callPeriod' => 2.0,
     *                            'numWorkers' => 2]. Applies only when
     *           `batchEnabled` is set to `true`. Note that this option is
     *           currently considered **experimental** and is subject to change.
     *     @type array $clientConfig Configuration options for the Logging client
     *           used to handle processing of batch items. For valid options
     *           please see
     *           {@see \Google\Cloud\Logging\LoggingClient::__construct()}.
     *           **Defaults to** the options provided to the current client.
     *           Applies only when `batchEnabled` is set to `true`.
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner. Applies only when `batchEnabled` is set to `true`.
     *     @type ClosureSerializerInterface $closureSerializer An implementation
     *           responsible for serializing closures used in the
     *           `$clientConfig`. This is especially important when using the
     *           batch daemon. **Defaults to**
     *           {@see \Google\Cloud\Core\Batch\OpisClosureSerializer} if the
     *           `opis/closure` library is installed.
     * }
     * @return PsrLogger
     */
    public function psrLogger($name, array $options = [])
    {
        $messageKey = null;

        if (isset($options['messageKey'])) {
            $messageKey = $options['messageKey'];
            unset($options['messageKey']);
        }

        $psrLoggerOptions = $this->pluckArray([
            'metadataProvider',
            'batchEnabled',
            'debugOutput',
            'batchOptions',
            'clientConfig',
            'batchRunner',
            'closureSerializer',
            'debugOutputResource'
        ], $options);

        return new PsrLogger(
            $this->logger($name, $options),
            $messageKey,
            $psrLoggerOptions + [
                'clientConfig' => $this->config
            ]
        );
    }

    /**
     * Fetches a logger which will write log entries to Stackdriver Logging.
     *
     * Example:
     * ```
     * $logger = $logging->logger('my-log');
     * ```
     *
     * @param string $name The name of the log to write entries to.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $resource The
     *           [monitored resource](https://cloud.google.com/logging/docs/api/reference/rest/v2/MonitoredResource)
     *           to associate log entries with. **Defaults to** type global.
     *     @type array $labels A set of user-defined (key, value) data that
     *           provides additional information about the log entry.
     * }
     * @return Logger
     */
    public function logger($name, array $options = [])
    {
        return new Logger(
            $this->connection,
            $name,
            $this->projectId,
            isset($options['resource']) ? $options['resource'] : null,
            isset($options['labels']) ? $options['labels'] : null
        );
    }
}
