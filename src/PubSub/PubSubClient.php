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

namespace Google\Cloud\PubSub;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\Connection\Grpc;
use Google\Cloud\PubSub\Connection\Rest;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Google Cloud Pub/Sub allows you to send and receive
 * messages between independent applications. Find more information at the
 * [Google Cloud Pub/Sub docs](https://cloud.google.com/pubsub/docs/).
 *
 * To enable the [Google Cloud Pub/Sub Emulator](https://cloud.google.com/pubsub/emulator),
 * set the [`PUBSUB_EMULATOR_HOST`](https://cloud.google.com/pubsub/emulator#env)
 * environment variable.
 *
 * This client supports transport over
 * [REST](https://cloud.google.com/pubsub/docs/reference/rest/) or
 * [gRPC](https://cloud.google.com/pubsub/docs/reference/rpc/).
 *
 * In order to enable gRPC support please make sure to install and enable
 * the gRPC extension through PECL:
 *
 * ```sh
 * $ pecl install grpc
 * ```
 *
 * NOTE: Support for gRPC is currently at an Alpha quality level, meaning it is still
 * a work in progress and is more likely to get backwards-incompatible updates.
 *
 * When using gRPC in production environments, it is highly recommended that you make use of the
 * Protobuf PHP extension for improved performance. Protobuf can be installed
 * via [PECL](https://pecl.php.net).
 *
 * ```
 * $ pecl install protobuf
 * ```
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 * ```
 *
 * ```
 * // Using the Pub/Sub Emulator
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * // Be sure to use the port specified when starting the emulator.
 * // `8900` is used as an example only.
 * putenv('PUBSUB_EMULATOR_HOST=http://localhost:8900');
 *
 * $pubsub = new PubSubClient();
 * ```
 */
class PubSubClient
{
    use ArrayTrait;
    use ClientTrait;
    use IncomingMessageTrait;
    use ResourceNameTrait;

    const VERSION = '0.11.2';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/pubsub';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var bool
     */
    private $encode;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * Create a PubSub client.
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
     *     @type string $transport The transport type used for requests. May be
     *           either `grpc` or `rest`. **Defaults to** `grpc` if gRPC support
     *           is detected on the system.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        $this->clientConfig = $config;
        $connectionType = $this->getConnectionType($config);
        $emulatorHost = getenv('PUBSUB_EMULATOR_HOST');
        $config += [
            'scopes' => [self::FULL_CONTROL_SCOPE],
            'projectIdRequired' => true,
            'hasEmulator' => (bool) $emulatorHost,
            'emulatorHost' => $emulatorHost
        ];

        if ($connectionType === 'grpc') {
            $this->connection = new Grpc($this->configureAuthentication($config));
            $this->encode = false;
        } else {
            $this->connection = new Rest($this->configureAuthentication($config));
            $this->encode = true;
        }
    }

    /**
     * Create a topic.
     *
     * Unlike {@see Google\Cloud\PubSub\PubSubClient::topic()}, this method will send an API call to
     * create the topic. If the topic already exists, an exception will be
     * thrown. When in doubt, use {@see Google\Cloud\PubSub\PubSubClient::topic()}.
     *
     * Example:
     * ```
     * $topic = $pubsub->createTopic('my-new-topic');
     * echo $topic->info()['name']; // `projects/my-awesome-project/topics/my-new-topic`
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/create Create Topic
     *
     * @param string $name The topic name
     * @param array $options [optional] Configuration Options
     * @return Topic
     */
    public function createTopic($name, array $options = [])
    {
        $topic = $this->topicFactory($name);
        $topic->create($options);

        return $topic;
    }

    /**
     * Lazily instantiate a topic with a topic name.
     *
     * No API requests are made by this method. If you want to create a new
     * topic, use {@see Google\Cloud\PubSub\Topic::createTopic()}.
     *
     * Example:
     * ```
     * // No API request yet!
     * $topic = $pubsub->topic('my-new-topic');
     *
     * // This will execute an API call.
     * echo $topic->info()['name']; // `projects/my-awesome-project/topics/my-new-topic`
     * ```
     *
     * @param string $name The topic name
     * @return Topic
     */
    public function topic($name)
    {
        return $this->topicFactory($name);
    }

    /**
     * Get a list of the topics registered to your project.
     *
     * Example:
     * ```
     * $topics = $pubsub->topics();
     * foreach ($topics as $topic) {
     *     $info = $topic->info();
     *     echo $info['name']; // `projects/my-awesome-project/topics/my-new-topic`
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/list List Topics
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Google\Cloud\PubSub\Topic>
     */
    public function topics(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $topic) {
                    return $this->topicFactory($topic['name'], $topic);
                },
                [$this->connection, 'listTopics'],
                $options + ['project' => $this->formatName('project', $this->projectId)],
                [
                    'itemsKey' => 'topics',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Create a Subscription. If the subscription does not exist, it will be
     * created.
     *
     * Use {@see Google\Cloud\PubSub\PubSubClient::subscription()} to create a subscription object
     * without any API requests. If the topic already exists, an exception will
     * be thrown. When in doubt, use {@see Google\Cloud\PubSub\PubSubClient::subscription()}.
     *
     * Example:
     * ```
     * // Create a subscription. If it doesn't exist in the API, it will be created.
     * $subscription = $pubsub->subscribe('my-new-subscription', 'my-topic-name');
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/create Create Subscription
     *
     * @param string $name A subscription name
     * @param string $topicName The topic to which the new subscription will be subscribed.
     * @param array  $options [optional] Please see {@see Google\Cloud\PubSub\Subscription::create()}
     *        for configuration details.
     * @return Subscription
     */
    public function subscribe($name, $topicName, array $options = [])
    {
        $subscription = $this->subscriptionFactory($name, $topicName);
        $subscription->create($options);

        return $subscription;
    }

    /**
     * Lazily instantiate a subscription with a subscription name.
     *
     * This method will NOT perform any API calls. If you wish to create a new
     * subscription, use {@see Google\Cloud\PubSub\PubSubClient::subscribe()}.
     *
     * Unless you are sure the subscription exists, you should check its
     * existence before using it.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * ```
     *
     * @param string $name The subscription name
     * @param string $topicName [optional] The topic name
     * @return Subscription
     */
    public function subscription($name, $topicName = null)
    {
        return $this->subscriptionFactory($name, $topicName);
    }

    /**
     * Get a list of the subscriptions registered to all of your project's
     * topics.
     *
     * Example:
     * ```
     * $subscriptions = $pubsub->subscriptions();
     * foreach ($subscriptions as $subscription) {
     *      $info = $subscription->info();
     *      echo $info['name']; // `projects/my-awesome-project/subscriptions/<subscription-name>`
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/list List Subscriptions
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Google\Cloud\PubSub\Subscription>
     */
    public function subscriptions(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $subscription) {
                    return $this->subscriptionFactory(
                        $subscription['name'],
                        $subscription['topic'],
                        $subscription
                    );
                },
                [$this->connection, 'listSubscriptions'],
                $options + ['project' => $this->formatName('project', $this->projectId)],
                [
                    'itemsKey' => 'subscriptions',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Create a snapshot.
     *
     * Please note that this method may not yet be available in your project.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription($subscriptionName);
     * $snapshot = $pubsub->createSnapshot('my-snapshot', $subscription);
     * ```
     *
     * @param string $name The snapshot name.
     * @param Subscription $subscription The subscription to take a snapshot of.
     * @param array $options [optional] Configuration options.
     * @return Snapshot
     */
    public function createSnapshot($name, Subscription $subscription, array $options = [])
    {
        $snapshot = $this->snapshot($name, [
            'subscription' => $subscription->name()
        ]);

        $snapshot->create($options);

        return $snapshot;
    }

    /**
     * Lazily create a snapshot instance.
     *
     * Example:
     * ```
     * $snapshot = $pubsub->snapshot('my-snapshot');
     * ```
     *
     * @param string $name The snapshot name.
     * @param array $info [optional] Snapshot info.
     * @return Snapshot
     */
    public function snapshot($name, array $info = [])
    {
        return new Snapshot($this->connection, $this->projectId, $name, $this->encode, $info);
    }

    /**
     * Get a list of the snapshots in the project.
     *
     * Please note that this method may not yet be available in your project.
     *
     * Example:
     * ```
     * $snapshots = $pubsub->snapshots();
     * foreach ($snapshots as $snapshot) {
     *      $info = $snapshot->info();
     *      echo $info['name'];
     * }
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Google\Cloud\PubSub\Snapshot>
     */
    public function snapshots(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $snapshot) {
                    return new Snapshot(
                        $this->connection,
                        $this->projectId,
                        $this->pluckName('snapshot', $snapshot['name']),
                        $this->encode,
                        $snapshot
                    );
                },
                [$this->connection, 'listSnapshots'],
                ['project' => $this->formatName('project', $this->projectId)] + $options,
                [
                    'itemsKey' => 'snapshots',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Consume an incoming message and return a PubSub Message.
     *
     * This method is for use with push delivery only.
     *
     * Example:
     * ```
     * $httpPostRequestBody = file_get_contents('php://input');
     * $requestData = json_decode($httpPostRequestBody, true);
     *
     * $message = $pubsub->consume($requestData);
     * ```
     *
     * @param array $requestBody The HTTP Request body
     * @return Message
     */
    public function consume(array $requestData)
    {
        return $this->messageFactory($requestData, $this->connection, $this->projectId, $this->encode);
    }

    /**
     * Create a Timestamp object.
     *
     * Example:
     * ```
     * $timestamp = $pubsub->timestamp(new \DateTime('2003-02-05 11:15:02.421827Z'));
     * ```
     *
     * @param \DateTimeInterface $value The timestamp value.
     * @param int $nanoSeconds [optional] The number of nanoseconds in the timestamp.
     * @return Timestamp
     */
    public function timestamp(\DateTimeInterface $timestamp, $nanoSeconds = null)
    {
        return new Timestamp($timestamp, $nanoSeconds);
    }

    /**
     * Create a Duration object.
     *
     * Example:
     * ```
     * $duration = $pubsub->duration(100, 00001);
     * ```
     *
     * @param int $seconds The number of seconds in the duration.
     * @param int $nanos [optional] The number of nanoseconds in the duration.
     *        **Defaults to** `0`.
     * @return Duration
     */
    public function duration($seconds, $nanos = 0)
    {
        return new Duration($seconds, $nanos);
    }


    /**
     * Create an instance of a topic
     *
     * @codingStandardsIgnoreStart
     * @param string $name The topic name
     * @param array  $info [optional] Information about the topic. Used internally to
     *        populate topic objects with an API result. Should be
     *        a representation of a [Topic](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics#Topic).
     * @return Topic
     * @codingStandardsIgnoreEnd
     */
    private function topicFactory($name, array $info = [])
    {
        return new Topic(
            $this->connection,
            $this->projectId,
            $name,
            $this->encode,
            $info,
            $this->clientConfig
        );
    }

    /**
     * Create a subscription instance.
     *
     * @codingStandardsIgnoreStart
     * @param string $name The subscription name
     * @param string $topicName [optional] The topic name
     * @param array  $info [optional] Information about the subscription. Used
     *        to populate subscriptons with an API result. Should be a
     *        representation of a [Subscription](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions#Subscription).
     * @return Subscription
     * @codingStandardsIgnoreEnd
     */
    private function subscriptionFactory($name, $topicName = null, array $info = [])
    {
        return new Subscription(
            $this->connection,
            $this->projectId,
            $name,
            $topicName,
            $this->encode,
            $info
        );
    }

    /**
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'projectId' => $this->projectId,
            'encode' => $this->encode
        ];
    }
}
