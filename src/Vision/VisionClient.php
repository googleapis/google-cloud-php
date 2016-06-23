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

namespace Google\Cloud\Vision;

use Google\Cloud\ClientTrait;
use Google\Cloud\Storage\Object as StorageObject;
use Google\Cloud\Vision\Connection\Rest;
use InvalidArgumentException;

/**
 * Google Cloud Vision client. Allows you to send and receive
 * messages between independent applications. Find more information at
 * [Google Cloud Vision docs](https://cloud.google.com/vision/docs/).
 */
class VisionClient
{
    use ClientTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Create a Vision client.
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * $vision = $cloud->vision();
     *
     * // The Vision client can also be instantianted directly.
     * use Google\Cloud\Vision\VisionClient;
     *
     * $vision = new VisionClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     * ```
     *
     * @param array $config {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
     *     @type array $scopes Scopes to be used for the request.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    public function image($image, array $features = [], array $options = [])
    {
        return new Image($image, $features, $options);
    }

    public function annotate(Image $image, array $options = [])
    {
        return $this->annotateBatch([$image], $options);
    }

    public function annotateBatch(array $images, array $options = [])
    {
        $requests = [];
        foreach ($images as $image) {
            $requests[] = $image->requestObject();
        }

        return $this->connection->annotate([
            'requests' => $requests
        ] + $options);
    }
}
