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

use Google\Cloud\ArrayTrait;
use Google\Cloud\ClientTrait;
use Google\Cloud\Trace\Connection\ConnectionInterface;
use Google\Cloud\Trace\Connection\Rest;

/**
 * Google Stackdriver Trace client. Allows you to collect latency data from
 * your applications and display it in the Google Cloud Platform Console.
 * Find more information at [Stackdriver Trace API docs](https://cloud.google.com/trace/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 *
 * $trace = $cloud->trace();
 * ```
 *
 * ```
 * // TraceClient can be instantiated directly
 * use Google\Cloud\Trace\TraceClient;
 *
 * $trace = new TraceClient();
 * ```
 */
class TraceClient
{
    use ArrayTrait;
    use ClientTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';
    const READ_ONLY_SCOPE = 'https://www.googleapis.com/auth/trace.readonly';

    /**
     * @var ConnectionInterface $connection Represents a connection to Trace
     */
    protected $connection;

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
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Returns the projectId for this client.
     *
     * @return string
     */
    public function projectId()
    {
        return $this->projectId;
    }

    /**
     * Sends a Trace log in a simple fashion.
     *
     * @param  Trace $trace The trace log to send.
     * @return Trace
     */
    public function insertTrace(Trace $trace)
    {
        $traces = $this->insertTraceBatch([$trace]);
        return $traces[0];
    }

    /**
     * Sends multiple Trace logs in a simple fashion.
     *
     * @param Trace[] $traces The trace logs to send.
     * @return Trace[] Array of new or updated traces.
     */
    public function insertTraceBatch(array $traces)
    {
        $response = $this->connection->patchTraces([
            'projectId' => $this->projectId,
            'traces' => array_map(function ($trace) {
                return $trace->info();
            }, $traces)
        ]);

        $traces = array_key_exists('traces', $response)
            ? $response['traces']
            : [];
        return array_map(function ($trace) {
            return new Trace($this->pluck('projectId', $trace), $trace);
        }, $traces);
    }

    /**
     * Fetch a single trace by traceId.
     *
     * @param  string $traceId The ID of the trace to return
     * @return Trace
     */
    public function getTrace($traceId)
    {
        $trace = $this->connection->getTrace([
            'projectId' => $this->projectId,
            'traceId' => $traceId
        ]);

        if (empty($trace)) {
            return null;
        };

        return new Trace($this->pluck('projectId', $trace), $trace);
    }

    /**
     * Lazily find or instantiates a trace. There are no network requests made at this
     * point. To see the operations that can be performed on a trace please
     * see {@see Google\Cloud\Trace\Trace}.
     *
     * Example:
     * ```
     * // Generate a new trace
     * $trace = $traceClient->trace();
     *
     * // Lazily find a trace id
     * $trace = $traceClient->trace('123456abcdef');
     * $trace->info();
     * ```
     * @param  string $traceId [optional] The trace id of the trace to reference.
     * @return Trace
     */
    public function trace($traceId = null)
    {
        return new Trace($this->projectId, ['traceId' => $traceId]);
    }

    /**
     * Fetch all traces in the project
     *
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $viewType Type of data returned for traces in the list.
     *            Can be one of 'VIEW_TYPE_UNSPECIFIED', 'MINIMAL', 'ROOTSPAN', or
     *            'COMPLETE'
     *      @type integer $pageSize Maximum number of traces to return
     *      @type string $pageToken Token identifying the page of results to return
     *      @type string $startTime Start of the time interval during which trace data
     *            was collected
     *      @type string $endTime End of the time interval during which trace data was
     *            collected
     *      @type sring $filter An optional filter for the request
     *      @type string $orderBy Field used to sort the returned traces. Can be one
     *            of 'traceId', 'name', 'duration', 'start'. Descending order
     * }
     * @return \Generator<Trace>
     */
    public function traces(array $options = [])
    {
        $options['pageToken'] = null;

        do {
            $response = $this->connection->listTraces($options + ['projectId' => $this->projectId]);
            $traces = array_key_exists('traces', $response)
                ? $response['traces']
                : [];
            foreach ($traces as $trace) {
                yield new Trace($this->pluck('projectId', $trace), $trace);
            }

            $options['pageToken'] = isset($response['nextPageToken']) ? $response['nextPageToken'] : null;
        } while ($options['pageToken']);
    }
}
