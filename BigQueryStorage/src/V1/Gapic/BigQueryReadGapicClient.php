<?php
/*
 * Copyright 2020 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/cloud/bigquery/storage/v1/storage.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\BigQuery\Storage\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\BigQuery\Storage\V1\CreateReadSessionRequest;
use Google\Cloud\BigQuery\Storage\V1\ReadRowsRequest;
use Google\Cloud\BigQuery\Storage\V1\ReadRowsResponse;
use Google\Cloud\BigQuery\Storage\V1\ReadSession;
use Google\Cloud\BigQuery\Storage\V1\SplitReadStreamRequest;
use Google\Cloud\BigQuery\Storage\V1\SplitReadStreamResponse;

/**
 * Service Description: BigQuery Read API.
 *
 * The Read API can be used to read data from BigQuery.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $bigQueryReadClient = new BigQueryReadClient();
 * try {
 *     $response = $bigQueryReadClient->createReadSession();
 * } finally {
 *     $bigQueryReadClient->close();
 * }
 * ```
 *
 * @experimental
 */
class BigQueryReadGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.bigquery.storage.v1.BigQueryRead';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'bigquerystorage.googleapis.com';

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
        'https://www.googleapis.com/auth/bigquery',
        'https://www.googleapis.com/auth/bigquery.readonly',
        'https://www.googleapis.com/auth/cloud-platform',
    ];

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/big_query_read_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/big_query_read_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/big_query_read_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/big_query_read_rest_client_config.php',
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
     *           as "<uri>:<port>". Default 'bigquerystorage.googleapis.com:443'.
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
     * Creates a new read session. A read session divides the contents of a
     * BigQuery table into one or more streams, which can then be used to read
     * data from the table. The read session also specifies properties of the
     * data to be read, such as a list of columns or a push-down filter describing
     * the rows to be returned.
     *
     * A particular row can be read by at most one stream. When the caller has
     * reached the end of each stream in the session, then all the data in the
     * table has been read.
     *
     * Data is assigned to each stream such that roughly the same number of
     * rows can be read from each stream. Because the server-side unit for
     * assigning data is collections of rows, the API does not guarantee that
     * each stream will return the same number or rows. Additionally, the
     * limits are enforced based on the number of pre-filtered rows, so some
     * filters can lead to lopsided assignments.
     *
     * Read sessions automatically expire 24 hours after they are created and do
     * not require manual clean-up by the caller.
     *
     * Sample code:
     * ```
     * $bigQueryReadClient = new BigQueryReadClient();
     * try {
     *     $response = $bigQueryReadClient->createReadSession();
     * } finally {
     *     $bigQueryReadClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $parent
     *          Required. The request project that owns the session, in the form of
     *          `projects/{project_id}`.
     *     @type ReadSession $readSession
     *          Required. Session to be created.
     *     @type int $maxStreamCount
     *          Max initial number of streams. If unset or zero, the server will
     *          provide a value of streams so as to produce reasonable throughput. Must be
     *          non-negative. The number of streams may be lower than the requested number,
     *          depending on the amount parallelism that is reasonable for the table. Error
     *          will be returned if the max count is greater than the current system
     *          max limit of 1,000.
     *
     *          Streams must be read starting from offset 0.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\BigQuery\Storage\V1\ReadSession
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createReadSession(array $optionalArgs = [])
    {
        $request = new CreateReadSessionRequest();
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
        }
        if (isset($optionalArgs['readSession'])) {
            $request->setReadSession($optionalArgs['readSession']);
        }
        if (isset($optionalArgs['maxStreamCount'])) {
            $request->setMaxStreamCount($optionalArgs['maxStreamCount']);
        }

        $descriptorData = [];

        if ($request->getReadSession()) {
            $descriptorData['read_session.table'] = $request->getReadSession()
                ->getTable();
        }

        $requestParams = new RequestParamsHeaderDescriptor($descriptorData);

        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateReadSession',
            ReadSession::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Reads rows from the stream in the format prescribed by the ReadSession.
     * Each response contains one or more table rows, up to a maximum of 100 MiB
     * per response; read requests which attempt to read individual rows larger
     * than 100 MiB will fail.
     *
     * Each request also returns a set of stream statistics reflecting the current
     * state of the stream.
     *
     * Sample code:
     * ```
     * $bigQueryReadClient = new BigQueryReadClient();
     * try {
     *     // Read all responses until the stream is complete
     *     $stream = $bigQueryReadClient->readRows();
     *     foreach ($stream->readAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $bigQueryReadClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $readStream
     *          Required. Stream to read rows from.
     *     @type int $offset
     *          The offset requested must be less than the last row read from Read.
     *          Requesting a larger offset is undefined. If not specified, start reading
     *          from offset zero.
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\ApiCore\ServerStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function readRows(array $optionalArgs = [])
    {
        $request = new ReadRowsRequest();
        if (isset($optionalArgs['readStream'])) {
            $request->setReadStream($optionalArgs['readStream']);
        }
        if (isset($optionalArgs['offset'])) {
            $request->setOffset($optionalArgs['offset']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'read_stream' => $request->getReadStream(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ReadRows',
            ReadRowsResponse::class,
            $optionalArgs,
            $request,
            Call::SERVER_STREAMING_CALL
        );
    }

    /**
     * Splits a given `ReadStream` into two `ReadStream` objects. These
     * `ReadStream` objects are referred to as the primary and the residual
     * streams of the split. The original `ReadStream` can still be read from in
     * the same manner as before. Both of the returned `ReadStream` objects can
     * also be read from, and the rows returned by both child streams will be
     * the same as the rows read from the original stream.
     *
     * Moreover, the two child streams will be allocated back-to-back in the
     * original `ReadStream`. Concretely, it is guaranteed that for streams
     * original, primary, and residual, that original[0-j] = primary[0-j] and
     * original[j-n] = residual[0-m] once the streams have been read to
     * completion.
     *
     * Sample code:
     * ```
     * $bigQueryReadClient = new BigQueryReadClient();
     * try {
     *     $response = $bigQueryReadClient->splitReadStream();
     * } finally {
     *     $bigQueryReadClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $name
     *          Required. Name of the stream to split.
     *     @type float $fraction
     *          A value in the range (0.0, 1.0) that specifies the fractional point at
     *          which the original stream should be split. The actual split point is
     *          evaluated on pre-filtered rows, so if a filter is provided, then there is
     *          no guarantee that the division of the rows between the new child streams
     *          will be proportional to this fractional value. Additionally, because the
     *          server-side unit for assigning data is collections of rows, this fraction
     *          will always map to a data storage boundary on the server side.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\BigQuery\Storage\V1\SplitReadStreamResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function splitReadStream(array $optionalArgs = [])
    {
        $request = new SplitReadStreamRequest();
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }
        if (isset($optionalArgs['fraction'])) {
            $request->setFraction($optionalArgs['fraction']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'SplitReadStream',
            SplitReadStreamResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
