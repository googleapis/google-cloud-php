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

use Google\ApiCore\Veneer\RequestHandler;
use Google\Cloud\PubSub\V1\SubscriberClient;

/**
 * Represents a Pub/Sub Snapshot
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 *
 * $snapshot = $pubsub->snapshot($snapshotName);
 * ```
 */
class Snapshot
{
    use ResourceNameTrait;

    /**
     * The request handler that is responsible for sending a req and
     * serializing responses into relevant classes.
     */
    private $requestHandler;

    /**
     * The GAPIC class to call under the hood.
     */
    private $gapic;

    /**
     * @var Google\ApiCore\Serializer The serializer to be used for PubSub
     */
    private $serializer;

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
        $projectId,
        $name,
        $encode,
        array $info = [],
        array $clientConfig = []
    ) {
        $this->gapic = new SubscriberClient($clientConfig);
        $this->serializer = new PubSubSerializer();
        $this->requestHandler = new RequestHandler(
            $this->serializer,
            $clientConfig + ['libVersion' => PubSubClient::VERSION]
        );
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

        $options['project'] = $this->formatName('project', $this->projectId);

        $this->info = $this->requestHandler->sendReq(
            $this->gapic,
            'createSnapshot',
            [$this->name, $this->info['subscription']],
            $options,
            true
        );

        return $this->info;
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
        $this->requestHandler->sendReq(
            $this->gapic,
            'deleteSnapshot',
            [$this->name],
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
            ? new Subscription($this->projectId, $this->info['subscription'], null, $this->encode)
            : null;
    }

    /**
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'projectId' => $this->projectId,
            'name' => $this->name,
            'info' => $this->info,
            'request_handler' => $this->requestHandler
        ];
    }
}
