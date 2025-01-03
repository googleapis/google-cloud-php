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

namespace Google\Cloud\PubSub;

use Google\ApiCore\ArrayTrait;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\CreateSnapshotRequest;
use Google\Cloud\PubSub\V1\DeleteSnapshotRequest;

/**
 * Represents a Pub/Sub Snapshot
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient(['projectId' => 'my-project']);
 *
 * $snapshot = $pubsub->snapshot($snapshotName);
 * ```
 */
class Snapshot
{
    use ResourceNameTrait;
    use ArrayTrait;

    /**
     * @internal
     * The request handler that is responsible for sending a request and
     * serializing responses into relevant classes.
     */
    private RequestHandler $requestHandler;
    private Serializer $serializer;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $encode;

    /**
     * @var array
     */
    private $info;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * @param RequestHandler The request handler that is responsible for sending a request
     * and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $projectId The current Project ID.
     * @param string $name The snapshot name.
     * @param bool $encode Whether certain request arguments should be base64-encoded.
     * @param array $info [optional] The snapshot data. When creating a
     *        Snapshot, this array **must** contain a `$info.subscription`
     *        argument with a fully-qualified subscription name.
     * @param array $clientConfig [optional] Configuration options for the
     *        PubSub client used to handle processing of batch items through the
     *        daemon. For valid options please see
     *        {@see \Google\Cloud\PubSub\PubSubClient::__construct()}.
     *        **Defaults to** the options provided to the PubSub client
     *        associated with this instance.
     */
    public function __construct(
        RequestHandler $requestHandler,
        Serializer $serializer,
        $projectId,
        $name,
        $encode,
        array $info = [],
        array $clientConfig = []
    ) {
        $this->requestHandler = $requestHandler;
        $this->serializer = $serializer;
        $this->projectId = $projectId;
        $this->encode = $encode;
        $this->clientConfig = $clientConfig;

        // Accept either a simple name or a fully-qualified name.
        if ($this->isFullyQualifiedName('snapshot', $name)) {
            $this->name = $name;
        } else {
            $this->name = $this->formatName('snapshot', $name, $projectId);
        }

        $this->info = $info + [
            'name' => $this->name,
            'subscription' => null,
            'topic' => null,
            'expirationTime' => null
        ];
    }

    /**
     * Get the Snapshot name.
     *
     * Example:
     * ```
     * echo $snapshot->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get the snapshot info.
     *
     * Example:
     * ```
     * $info = $snapshot->info();
     * ```
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * Create a new Snapshot.
     *
     * When creating a snapshot, a subscription name must be supplied at
     * instantiation.
     *
     * Please note that this method may not yet be available in your project.
     *
     * Example:
     * ```
     * $info = $snapshot->create();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     * @throws \BadMethodCallException If a subscription name cannot be found.
     */
    public function create(array $options = [])
    {
        if (!$this->info['subscription']) {
            throw new \BadMethodCallException('A subscription is required to create a snapshot.');
        }

        $data = [
            'name' => $this->name,
            'subscription' => $this->info['subscription'],
            'labels' => $this->pluck('labels', $options, false) ?: []
        ];

        $request = $this->serializer->decodeMessage(new CreateSnapshotRequest(), $data);

        return $this->info = $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSnapshot',
            $request,
            $options,
            true
        );
    }

    /**
     * Delete the snapshot.
     *
     * Please note that this method may not yet be available in your project.
     *
     * Example:
     * ```
     * $snapshot->delete();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function delete(array $options = [])
    {
        $request = $this->serializer->decodeMessage(
            new DeleteSnapshotRequest(),
            ['snapshot' => $this->name]
        );
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'deleteSnapshot',
            $request,
            $options
        );
    }

    /**
     * Get the Topic attached to the snapshot, if one exists.
     *
     * Example:
     * ```
     * $topic = $snapshot->topic();
     * ```
     *
     * @return Topic|null
     */
    public function topic()
    {
        if ($this->info['topic']) {
            return new Topic(
                $this->requestHandler,
                $this->serializer,
                $this->projectId,
                $this->info['topic'],
                $this->encode,
                [],
                $this->clientConfig
            );
        }

        return null;
    }

    /**
     * Get the Subscription attached to the snapshot, if one exists.
     *
     * Example:
     * ```
     * $subscription = $snapshot->subscription();
     * ```
     *
     * @return Subscription|null
     */
    public function subscription()
    {
        return $this->info['subscription']
            ? new Subscription(
                $this->requestHandler,
                $this->serializer,
                $this->projectId,
                $this->info['subscription'],
                null,
                $this->encode
            )
            : null;
    }

    /**
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'requestHandler' => $this->requestHandler,
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info
        ];
    }
}
