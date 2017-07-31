<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Trace;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Trace\Connection\ConnectionInterface;
use Google\Cloud\Trace\Connection\Rest;
use Google\Cloud\Trace\Reporter\AsyncReporter;
use Google\Cloud\Trace\Reporter\ReporterInterface;

/**
 * Google Stackdriver Trace allows you to collect latency data from
 * your applications and display it in the Google Cloud Platform Console.
 * Find more information at [Stackdriver Trace API docs](https://cloud.google.com/trace/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\TraceClient;
 *
 * $trace = new TraceClient();
 * ```
 */
class TraceClient
{
    use ArrayTrait;
    use ClientTrait;

    const VERSION = '0.3.1';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';
    const READ_ONLY_SCOPE = 'https://www.googleapis.com/auth/trace.readonly';

    /**
     * @var ConnectionInterface $connection Represents a connection to Trace
     */
    protected $connection;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * Create a Trace client.
     *
     * @param array $config [optional] {
     *     Configuration options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache used storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->clientConfig = $config;
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Sends a Trace log in a simple fashion.
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/trace/docs/reference/v1/rest/v1/projects/patchTraces Project patchTraces API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param Trace $trace The trace log to send.
     * @param array $options [optional] Configuration Options
     * @return bool
     */
    public function insert(Trace $trace, array $options = [])
    {
        return $this->insertBatch([$trace], $options);
    }

    /**
     * Sends multiple Trace logs in a simple fashion.
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/trace/docs/reference/v1/rest/v1/projects/patchTraces Project patchTraces API documentation.
     * @codingStandardsIgnoreEnd
     *
     * @param Trace[] $traces The trace logs to send.
     * @param array $options [optional] Configuration Options
     * @return bool
     */
    public function insertBatch(array $traces, array $options = [])
    {
        // throws ServiceException on failure
        $this->connection->patchTraces([
            'projectId' => $this->projectId,
            'traces' => array_map(function ($trace) {
                return $trace->info();
            }, $traces)
        ] + $options);
        return true;
    }

    /**
     * Lazily find or instantiates a trace. There are no network requests made at this
     * point. To see the operations that can be performed on a trace please
     * see {@see Google\Cloud\Trace\Trace}. If no traceId is provided, one will be
     * generated for you.
     *
     * @param string $traceId [optional] The trace id of the trace to reference.
     * @return Trace
     */
    public function trace($traceId = null)
    {
        return new Trace($this->connection, $this->projectId, $traceId);
    }

    /**
     * Fetch all traces in the project.
     *
     * @see https://cloud.google.com/trace/docs/reference/v1/rest/v1/projects.traces/list Traces list API documentation.
     *
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $viewType Type of data returned for traces in the list.
     *            Can be one of 'VIEW_TYPE_UNSPECIFIED', 'MINIMAL', 'ROOTSPAN', or
     *            'COMPLETE'
     *      @type int $pageSize Maximum number of traces to return per page.
     *      @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *      @type string $pageToken Token identifying the page of results to return
     *      @type string $startTime Start of the time interval during which trace data
     *            was collected. This timestamp in nanoseconds should be in "Zulu" format.
     *            Example: '2014-10-02T15:01:23.045123456Z'
     *      @type string $endTime End of the time interval during which trace data was
     *            collected. This timestamp in nanoseconds should be in "Zulu" format.
     *            Example: '2014-10-02T15:01:23.045123456Z'
     *      @type string $filter An optional filter for the request
     *      @type string $orderBy Field used to sort the returned traces. Can be one
     *            of 'traceId', 'name', 'duration', 'start'. Descending order can be
     *            specified by appending 'desc' to the sort field (for example,
     *            'name desc'). Only one sort field is permitted.
     * }
     * @return ItemIterator<Trace>
     */
    public function traces(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $trace) {
                    $trace += ['spans' => null];
                    return new Trace($this->connection, $trace['projectId'], $trace['traceId'], $trace['spans']);
                },
                [$this->connection, 'listTraces'],
                ['projectId' => $this->projectId] + $options,
                [
                    'itemsKey' => 'traces',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Return a Trace reporter that utilizes this client's configuration
     *
     * @param  array $options [optional] Reporter options.
     *      {@see Google\Cloud\Trace\Reporter\AsyncReporter::__construct()}
     * @return ReporterInterface
     */
    public function reporter(array $options = [])
    {
        return new AsyncReporter($options + [
            'clientConfig' => $this->clientConfig
        ]);
    }
}
