<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
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

namespace Google\Cloud;

use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\Storage\StorageClient;

/**
 * Google Cloud Platform is a set of modular cloud-based services that allow you
 * to create anything from simple websites to complex applications.
 *
 * This API aims to expose access to these services in a way that is intuitive
 * and easy to use for PHP enthusiasts. The ServiceBuilder instance exposes
 * factory methods which grant access to the various services contained within
 * the API.
 *
 * Configuration is simple. Pass in an array of configuration options to the
 * constructor up front which can be shared between clients or specify the
 * options for the specific services you wish to access, e.g. Datastore, or
 * Storage.
 */
class ServiceBuilder
{
    const VERSION = '0.3.0';

    /**
     * @var array Configuration options to be used between clients.
     */
    private $config;

    /**
     * Pass in an array of configuration options which will be shared between
     * clients.
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * $builder = new ServiceBuilder([
     *     'keyFilePath' => '/path/to/key/file.json',
     *     'projectId' => 'myAwesomeProject'
     * ]);
     * ```
     *
     * @param array $config {
     *     Configuration options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developer's
     *           Console.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
     *     @type array $scopes Scopes to be used for the request.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->config = $this->resolveConfig($config);
    }

    /**
     * Google Cloud Storage client. Allows you to store and retrieve data on
     * Google's infrastructure. Find more information at
     * [Google Cloud Storage API docs](https://developers.google.com/storage).
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * // Create a storage client using application default credentials.
     * $builder = new ServiceBuilder([
     *     'projectId' => 'myAwesomeProject'
     * ]);
     *
     * $storage = $builder->storage();
     * ```
     *
     * @param array $config Configuration options. See
     *        {@see Google\Cloud\ServiceBuilder::__construct()} for the available options.
     * @return StorageClient
     */
    public function storage(array $config = [])
    {
        return new StorageClient($config ? $this->resolveConfig($config) : $this->config);
    }

    /**
     * Google Cloud BigQuery client. Allows you to create, manage, share and query
     * data. Find more information at
     * [Google Cloud BigQuery Docs](https://cloud.google.com/bigquery/what-is-bigquery).
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * // Create a BigQuery client using application default credentials.
     * $builder = new ServiceBuilder([
     *     'projectId' => 'myAwesomeProject'
     * ]);
     *
     * $bigQuery = $builder->bigQuery();
     * ```
     *
     * @param array $config Configuration options. See
     *        {@see Google\Cloud\ServiceBuilder::__construct()} for the available options.
     * @return BigQueryClient
     */
    public function bigQuery(array $config = [])
    {
        return new BigQueryClient($config ? $this->resolveConfig($config) : $this->config);
    }

    /**
     * Google Cloud Pub/Sub client. Allows you to send and receive
     * messages between independent applications. Find more information at
     * [Google Cloud Pub/Sub docs](https://cloud.google.com/pubsub/docs/).
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * // Create a storage client using application default credentials.
     * $builder = new ServiceBuilder([
     *     'projectId' => 'myAwesomeProject'
     * ]);
     *
     * $pubsub = $builder->pubsub();
     * ```
     *
     * @param array $config Configuration options. See
     *        {@see Google\Cloud\ServiceBuilder::__construct()} for the available options.
     * @return PubSubClient
     */
    public function pubsub(array $config = [])
    {
        return new PubSubClient($config ? $this->resolveConfig($config) : $this->config);
    }

    /**
     * Resolves configuration options.
     *
     * @param array $config
     * @return array
     */
    private function resolveConfig(array $config)
    {
        if (!isset($config['httpHandler'])) {
            $config['httpHandler'] = HttpHandlerFactory::build();
        }

        return $config;
    }
}
