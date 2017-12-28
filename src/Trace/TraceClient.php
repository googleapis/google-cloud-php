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
    use ClientTrait;

    const VERSION = '0.5.1';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

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
     * }
     */
    public function __construct(array $config = [])
    {
        $this->clientConfig = $config;
        $config += [
            'scopes' => [self::FULL_CONTROL_SCOPE],
            'projectIdRequired' => true
        ];

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Sends a Trace log in a simple fashion.
     *
     * Example:
     * ```
     * $trace = $traceClient->trace();
     * $result = $traceClient->insert($trace);
     * ```
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
     * Example:
     * ```
     * $trace = $traceClient->trace();
     * $result = $traceClient->insertBatch([$trace]);
     * ```
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
        $this->connection->traceBatchWrite([
            'projectsId' => $this->projectId,
            'spans' => array_map([$this, 'transformSpan'], $traces)
        ] + $options);
        return true;
    }

    /**
     * Lazily find or instantiates a trace. There are no network requests made at this
     * point. To see the operations that can be performed on a trace please
     * see {@see Google\Cloud\Trace\Trace}. If no traceId is provided, one will be
     * generated for you.
     *
     * Example:
     * ```
     * // Create a trace with a generated traceId
     * $trace = $traceClient->trace();
     * ```
     *
     * ```
     * // Create a trace with a specific traceId
     * $trace = $traceClient->trace('1234abcd');
     * ```
     *
     * @param string $traceId [optional] The trace id of the trace to reference.
     * @return Trace
     */
    public function trace($traceId = null)
    {
        return new Trace($this->projectId, $traceId);
    }

    private function transformSpan($trace)
    {
        return array_map(function ($span) {
            $data = $span->jsonSerialize();
            $data['name'] = sprintf(
                'projects/%s/traces/%s/spans/%s',
                $this->projectId,
                $span->traceId(),
                $span->spanId()
            );
            return $data;
        }, $trace->spans());
    }
}
