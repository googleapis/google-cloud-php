<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore;

use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Firestore\Connection\Grpc;

class FirestoreClient
{
    use ClientTrait;

    const VERSION = 'master';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/datastore';

    private $connection;

    private $database = 'default';

    /**
     * Create a Firestore client.
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache for storing access
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
     *     @type int $retries Number of retries for a failed request. **Defaults
     *           to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        $config += [
            'returnInt64AsObject' => false,
            'scopes' => [self::FULL_CONTROL_SCOPE]
        ];

        $this->connection = new Grpc($this->configureAuthentication($config));
    }

    public function collection($collectionPath, array $options = [])
    {}

    /**
     * List root-level collections in the database.
     *
     * Example:
     * ```
     * $collections = $firestore->collections();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.instance.v1#listinstancesrequest ListInstancesRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $filter An expression for filtering the results of the
     *           request.
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Collection>
     */
    public function collections(array $options = [])
    {}

    public function document($path)
    {
        return new Document($this->connection, $this->fullPath($path));
    }

    public function documents(array $references, array $options = [])
    {}

    public function runTransaction(callable $transaction, array $options = [])
    {}

    private function fullPath($relativePath)
    {
        $template = 'projects/%s/databases/%s/%s';
        return sprintf($template, $this->projectId, $this->database, $relativePath);
    }
}
