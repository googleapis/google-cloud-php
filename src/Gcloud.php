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

namespace Gcloud;

use Gcloud\Storage\Connection\REST;
use Gcloud\Storage\StorageClient;

/**
 * Gcloud is the official way to interact with the
 * [Google Cloud Platform](https://cloud.google.com/). Google Cloud Platform is
 * a set of modular cloud-based services that allow you to create anything from
 * simple websites to complex applications.
 *
 * This API aims to expose access to these services in a way that is intuitive
 * and easy to use for PHP enthusiasts. The Gcloud instance exposes factory
 * methods which grant access to the various services contained within the API.
 *
 * Configuration is simple. Pass in an array of configuration options to the
 * constructor up front which can be shared between clients or specify the
 * options for the specific services you wish to access, e.g. Datastore, or
 * Storage.
 */
class Gcloud
{
    const VERSION = '0.0.0';

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
     * use Gcloud\Gcloud;
     *
     * $gcloud = new Gcloud([
     *     'keyFilePath' => '/path/to/key/file.json',
     *     'projectId' => 'myAwesomeProject'
     * ]);
     * ```
     *
     * @param array $config {
     *     Configuration options.
     *
     *     @type callable $httpHandler Override the default http handler.
     *     @type callable $authHttpHandler Override the default http handler
     *           used to fetch credentials.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type string $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developers Console.
     *     @type string $projectId The project ID created in the Google
     *           Developers Console.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Google Cloud Storage client. Allows you to store and retrieve data on
     * Google's infrastructure. Find more information at
     * [Google Cloud Storage API docs](https://developers.google.com/storage).
     *
     * Example:
     * ```
     * use Gcloud\Gcloud;
     *
     * // Create a Gcloud instance using application default credentials.
     * $gcloud = new Gcloud([
     *     'projectId' => 'myAwesomeProject'
     * ]);
     *
     * $storage = $gcloud->storage();
     * ```
     *
     * @param array $config Configuration options. See
     *        {@see Gcloud\Gcloud::__construct()} for the available options.
     * @return StorageClient
     */
    public function storage(array $config = [])
    {
        if (!$config) {
            $config = $this->config;
        }

        if (!isset($config['projectId'])) {
            throw new \InvalidArgumentException('A projectId is required.');
        }

        $config = $config + [
            'keyFile' => null,
            'keyFilePath' => null,
            'httpHandler' => null,
            'authHttpHandler' => null
        ];

        $httpWrapper = new HttpRequestWrapper(
            $config['keyFile'],
            $config['keyFilePath'],
            [StorageClient::DEFAULT_SCOPE],
            $config['httpHandler'],
            $config['authHttpHandler']
        );

        return new StorageClient(
            new REST($httpWrapper),
            $config['projectId']
        );
    }
}
