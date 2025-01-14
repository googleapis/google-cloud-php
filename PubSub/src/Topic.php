<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\DeleteTopicRequest;
use Google\Cloud\PubSub\V1\Encoding;
use Google\Cloud\PubSub\V1\GetTopicRequest;
use Google\Cloud\PubSub\V1\ListTopicSubscriptionsRequest;
use Google\Cloud\PubSub\V1\MessageStoragePolicy;
use Google\Cloud\PubSub\V1\PublishRequest;
use Google\Cloud\PubSub\V1\PubsubMessage;
use Google\Cloud\PubSub\V1\SchemaSettings;
use Google\Cloud\PubSub\V1\Topic as TopicProto;
use Google\Cloud\PubSub\V1\UpdateTopicRequest;
use Google\Protobuf\FieldMask;
use InvalidArgumentException;

/**
 * A named resource to which messages are sent by publishers.
 *
 * Example:
 * ```
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient(['projectId' => 'my-awesome-project']);
 * $topic = $pubsub->topic('my-new-topic');
 * ```
 *
 * ```
 * // You can also pass a fully-qualified topic name:
 * $topic = $pubsub->topic('projects/my-awesome-project/topics/my-new-topic');
 * ```
 */
class Topic
{
    use ResourceNameTrait;
    use ApiHelperTrait;

    const DEFAULT_COMPRESSION_BYTES_THRESHOLD = 240;

    const DEFAULT_ENABLE_COMPRESSION = false;

    private const COMPRESSION_HEADER_KEY = 'grpc-internal-encoding-request';

    private const GZIP_COMPRESSION = 'gzip';

    /**
     * @internal
     * The request handler that is responsible for sending a request and
     * serializing responses into relevant classes.
     */
    private RequestHandler $requestHandler;
    private Serializer $serializer;

    /**
     * @var string The project ID
     */
    private $projectId;

    /**
     * @var string The topic name
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
     * @var Iam
     */
    private $iam;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * @var bool
     */
    private $enableCompression;

    /**
     * @var int
     */
    private $compressionBytesThreshold;

    /**
     * Create a PubSub topic.
     *
     * @param RequestHandler The request handler that is responsible for sending a request
     * and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $projectId The project Id
     * @param string $name The topic name
     * @param bool $encode Whether messages should be base64 encoded.
     * @param array $info {
     *        A [Topic](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics
     *
     *        @type string name The name of the topic.
     *        @type array $labels Key value pairs used to organize your resources.
     *        @type string $kmsKeyName The resource name of the Cloud KMS
     *              CryptoKey to be used to protect access to messages published on this
     *              topic. The expected format is
     *              `projects/my-project/locations/kr-location/keyRings/my-kr/cryptoKeys/my-key`.
     *        @type bool $enableCompression Flag to enable compression of messages
     *              before publishing. Set the flag to `true` to enable compression.
     *              Defaults to `false`. Messsages are compressed if their total
     *              size >= `compressionBytesThreshold`, whose default value has
     *              been experimentally derived after performance evaluations.
     *        @type int $compressionBytesThreshold The threshold byte size
     *              above which messages are compressed. This only takes effect
     *              if `enableCompression` is set to `true`. Defaults to `240`.
     *              (This value is experiementally derived after performance evaluations.)
     * }
     *
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
        $this->encode = (bool) $encode;
        $this->info = $info;
        $this->clientConfig = $clientConfig;

        if (isset($info['enableCompression']) && $info['enableCompression'] === true) {
            $this->enableCompression = true;
            $this->compressionBytesThreshold = $info['compressionBytesThreshold'] ??
                self::DEFAULT_COMPRESSION_BYTES_THRESHOLD;
        } else {
            $this->enableCompression = self::DEFAULT_ENABLE_COMPRESSION;
            $this->compressionBytesThreshold = self::DEFAULT_COMPRESSION_BYTES_THRESHOLD;
        }

        // Accept either a simple name or a fully-qualified name.
        if ($this->isFullyQualifiedName('topic', $name)) {
            $this->name = $name;
        } else {
            $this->name = $this->formatName('topic', $name, $projectId);
        }
    }

    /**
     * Get the topic name
     *
     * Example:
     * ```
     * echo $topic->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Create a topic.
     *
     * Example:
     * ```
     * $topicInfo = $topic->create();
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/create Create Topic
     *
     * @param array $options  {
     *     Configuration Options
     *
     *     @type array $labels Key value pairs used to organize your
     *           resources.
     *     @type string $kmsKeyName The resource name of the Cloud KMS
     *           CryptoKey to be used to protect access to messages published on
     *           this topic. The expected format is
     *          `projects/my-project/locations/kr-location/keyRings/my-kr/cryptoKeys/my-key`.
     *     @type array $messageStoragePolicy Policy constraining the set of
     *           Google Cloud Platform regions where messages published to the
     *           topic may be stored. If not present, then no constraints are in
     *           effect.
     *     @type string[] $messageStoragePolicy.allowedPersistenceRegions A list
     *           of IDs of GCP regions where messages that are published to the
     *           topic may be persisted in storage. Messages published by
     *           publishers running in non-allowed GCP regions (or running
     *           outside of GCP altogether) will be routed for storage in one of
     *           the allowed regions. An empty list means that no regions are
     *           allowed, and is not a valid configuration.
     *     @type string|Schema $schemaSettings.schema The name of a schema that
     *           messages published should be validated against, or an instance
     *           of {@see Schema}.
     *     @type string $schemaSettings.encoding The encoding of messages
     *           validated against schema. For allowed values, see constants
     *           defined on {@see Encoding}.
     * }
     *
     * @return array Topic information
     */
    public function create(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data['name'] = $this->name;

        $this->formatSchemaSettings($data);
        $data = $this->convertDataToProtos($data, ['messageStoragePolicy' => MessageStoragePolicy::class]);

        $request = $this->serializer->decodeMessage(new TopicProto(), $data);

        return $this->info = $this->requestHandler->sendRequest(
            PublisherClient::class,
            'createTopic',
            $request,
            $optionalArgs
        );
    }

    /**
     * Update the topic.
     *
     * Note that the topic's name and kms key name are immutable properties and may not be modified.
     *
     * Example:
     * ```
     * $topic->update([
     *     'messageStoragePolicy' => [
     *         'allowedPersistenceRegions' => ['us-central1']
     *     ]
     * ]);
     * ```
     *
     * ```
     * // Updating labels with an explicit update mask
     * $topic->update([
     *     'labels' => [
     *         'foo' => 'bar'
     *     ]
     * ], [
     *     'updateMask' => [
     *         'labels'
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/UpdateTopicRequest Update Topic
     *
     * @param array $data {
     *    The Topic data.
     *
     *     @type array $labels Key value pairs used to organize your resources.
     *     @type array $messageStoragePolicy Policy constraining the set of
     *          Google Cloud Platform regions where messages published to the
     *          topic may be stored. If not present, then no constraints are in
     *          effect.
     *     @type string[] $messageStoragePolicy.allowedPersistenceRegions A list
     *          of IDs of GCP regions where messages that are published to the
     *          topic may be persisted in storage. Messages published by
     *          publishers running in non-allowed GCP regions (or running
     *          outside of GCP altogether) will be routed for storage in one of
     *          the allowed regions. An empty list means that no regions are
     *          allowed, and is not a valid configuration.
     *     @type string|Schema $schemaSettings.schema The name of a schema that
     *           messages published should be validated against, or an instance
     *           of {@see Schema}.
     *     @type string $schemaSettings.encoding The encoding of messages
     *           validated against schema. For allowed values, see constants
     *           defined on {@see V1\Encoding}.
     * }
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $updateMask A list of field paths to be modified. Nested
     *           key names should be dot-separated, e.g.
     *           `messageStoragePolicy.allowedPersistenceRegions`. Google Cloud
     *           PHP will attempt to infer this value on your behalf, however
     *           modification of map fields with arbitrary keys (such as labels
     *           or message storage policy) requires an explicit update mask.
     * }
     *
     * @return array The topic info.
     */
    public function update(array $data, array $options = [])
    {
        $updateMaskPaths = $this->pluck('updateMask', $options, false) ?: [];

        if (!$updateMaskPaths) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($data));
            foreach ($iterator as $leafValue) {
                $excludes = ['name'];
                $keys = [];
                foreach (range(0, $iterator->getDepth()) as $depth) {
                    $key = $iterator->getSubIterator($depth)->key();
                    if (!is_string($key)) {
                        break;
                    }
                    $keys[] = $key;
                }

                $path = implode('.', $keys);
                if (!in_array($path, $excludes)) {
                    $updateMaskPaths[] = $path;
                }
            }
        }

        $maskPaths = [];
        foreach ($updateMaskPaths as $path) {
            $maskPaths[] = Serializer::toSnakeCase($path);
        }

        $fieldMask = new FieldMask([
            'paths' => $maskPaths
        ]);

        $data['name'] = $this->name;
        $this->formatSchemaSettings($data);

        $proto = $this->serializer->decodeMessage(new TopicProto(), $data);

        $request = $this->serializer->decodeMessage(
            new UpdateTopicRequest(),
            ['topic' => $proto, 'updateMask' => $fieldMask]
        );

        return $this->info = $this->requestHandler->sendRequest(
            PublisherClient::class,
            'updateTopic',
            $request,
            $options
        );
    }

    /**
     * Delete a topic.
     *
     * Example:
     * ```
     * $topic->delete();
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/delete Delete Topic
     *
     * @param array $options [optional] Configuration Options
     * @return void
     */
    public function delete(array $options = [])
    {
        $data = ['topic' => $this->name];
        $request = $this->serializer->decodeMessage(new DeleteTopicRequest(), $data);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'deleteTopic',
            $request,
            $options
        );
    }

    /**
     * Check if a topic exists.
     *
     * Service errors will NOT bubble up from this method. It will always return
     * a boolean value. If you want to check for errors, use
     * {@see Topic::info()}.
     *
     * Example:
     * ```
     * if ($topic->exists()) {
     *     echo 'Topic exists';
     * }
     * ```
     *
     * @param array $options [optional] Configuration Options
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->info($options);
            return true;
        } catch (NotFoundException $e) {
            return false;
        }
    }

    /**
     * Get topic information.
     *
     * Currently this resource returns only the topic name, if the topic exists.
     * It is mostly useful therefore for checking if a topic exists.
     *
     * Since this method will throw an exception if the topic is not found, you
     * may find that Topic::exists() is a better fit for a true/false check.
     *
     * This method will use the previously cached result, if available. To force
     * a refresh from the API, use {@see Topic::reload()}.
     *
     * Example:
     * ```
     * $info = $topic->info();
     * echo $info['name']; // projects/my-awesome-project/topics/my-new-topic
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/get Get Topic
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] Configuration Options
     * @return array [A representation of a Topic](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics)
     * @codingStandardsIgnoreEnd
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Get topic information from the API.
     *
     * Currently this resource returns only the topic name, if the topic exists.
     * It is mostly useful therefore for checking if a topic exists.
     *
     * Since this method will throw an exception if the topic is not found, you
     * may find that Topic::exists() is a better fit for a true/false check.
     *
     * This method will retrieve a new result from the API. To use a previously
     * cached result, if one exists, use {@see Topic::info()}.
     *
     * Example:
     * ```
     * $topic->reload();
     * $info = $topic->info();
     * echo $info['name']; // projects/my-awesome-project/topics/my-new-topic
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/get Get Topic
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] Configuration Options
     * @return array [A representation of a Topic](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics)
     * @codingStandardsIgnoreEnd
     */
    public function reload(array $options = [])
    {
        $data = ['topic' => $this->name];
        $request = $this->serializer->decodeMessage(new GetTopicRequest(), $data);

        return $this->info = $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            $request,
            $options
        );
    }

    /**
     * Publish a new message to the topic.
     *
     * $message must provide at least one of `data` and `attributes` members.
     *
     * Example:
     * ```
     * $topic->publish([
     *     'data' => 'New User Registered',
     *     'attributes' => [
     *         'id' => '1',
     *         'userName' => 'John',
     *         'location' => 'Detroit'
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/publish Publish Message
     *
     * @param Message|array $message An instance of
     *        {@see Message}, or an array in the correct
     *        [Message Format](https://cloud.google.com/pubsub/docs/reference/rest/v1/PubsubMessage).
     * @param array $options [optional] Configuration Options
     * @return array A list of message IDs
     */
    public function publish($message, array $options = [])
    {
        return $this->publishBatch([$message], $options);
    }

    /**
     * Publish multiple messages at once.
     *
     * Note that if ordering keys are provided, all members of given messages
     * set must provide the same ordering key. Multiple ordering keys in a
     * single publish call is not supported.
     *
     * Example:
     * ```
     * $topic->publishBatch([
     *     [
     *         'data' => 'New User Registered',
     *         'attributes' => [
     *             'id' => '1',
     *             'userName' => 'John',
     *             'location' => 'Detroit'
     *         ]
     *     ], [
     *         'data' => 'New User Registered',
     *         'attributes' => [
     *             'id' => '2',
     *             'userName' => 'Steve',
     *             'location' => 'Mountain View'
     *         ]
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/publish Publish Message
     *
     * @param Message[]|array[] $messages A list of messages. Each message must be in the correct
     *        [Message Format](https://cloud.google.com/pubsub/docs/reference/rest/v1/PubsubMessage),
     *        or be an instance of {@see Message}.
     * @param array $options [optional] Configuration Options
     * @return array A list of message IDs.
     */
    public function publishBatch(array $messages, array $options = [])
    {
        $totalMessagesSize = 0;
        foreach ($messages as &$message) {
            $message = $this->formatMessage($message);
            $totalMessagesSize += strlen($message->serializeToString());
        }

        if ($this->enableCompression &&
            $totalMessagesSize >= $this->compressionBytesThreshold) {
            $headers = $options['headers'] ?? [];
            $headers[self::COMPRESSION_HEADER_KEY] = [self::GZIP_COMPRESSION];
            $options['headers'] = $headers;
        }

        $request = $this->serializer->decodeMessage(
            new PublishRequest(),
            ['topic' => $this->name, 'messages' => $messages]
        );

        return $this->requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            $request,
            $options
        );
    }

    /**
     * Push a message into a batch queue, to be processed at a later point.
     *
     * Example:
     * ```
     * $topic->batchPublisher()
     *     ->publish([
     *         'data' => 'New User Registered',
     *         'attributes' => [
     *             'id' => '2',
     *             'userName' => 'Dave',
     *             'location' => 'Detroit'
     *         ]
     *     ]);
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $debugOutput Whether or not to output debug information.
     *           Please note debug output currently only applies in CLI based
     *           applications. **Defaults to** `false`.
     *     @type resource $debugOutputResource A resource to output debug output
     *           to. **Defaults to** Resource for `php://stderr`.
     *     @type array $batchOptions A set of options for a BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()} for
     *           more details.
     *           **Defaults to** ['batchSize' => 1000,
     *                            'callPeriod' => 2.0,
     *                            'numWorkers' => 2].
     *     @type array $clientConfig Configuration options for the PubSub client
     *           used to handle processing of batch items. For valid options
     *           please see
     *           {@see \Google\Cloud\PubSub\PubSubClient::__construct()}.
     *           **Defaults to** the options provided to the client associated
     *           with the current `Topic` instance.
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner.
     *     @type string $identifier An identifier for the batch job.
     *           **Defaults to** `pubsub-topic-{topic-name}`.
     *           Example: `pubsub-topic-mytopic`.
     *     @type ClosureSerializerInterface $closureSerializer An implementation
     *           responsible for serializing closures used in the
     *           `$clientConfig`. This is especially important when using the
     *           batch daemon. **Defaults to**
     *           {@see \Google\Cloud\Core\Batch\OpisClosureSerializer} if the
     *           `opis/closure` library is installed.
     *     @type bool $enableCompression Flag to enable compression of messages
     *           before publishing. Set the flag to `true` to enable compression.
     *           Defaults to `false`. Messsages are compressed if their total
     *           size >= `compressionBytesThreshold`, whose default value has
     *           been experimentally derived after performance evaluations.
     *     @type int $compressionBytesThreshold The threshold byte size
     *           above which messages are compressed. This only takes effect
     *           if `enableCompression` is set to `true`. Defaults to `240`.
     *           (This value is experiementally derived after performance evaluations.)
     * }
     * @return BatchPublisher
     * @experimental The experimental flag means that while we believe this method
     *      or class is ready for use, it may change before release in backwards-
     *      incompatible ways. Please use with caution, and test thoroughly when
     *      upgrading.
     */
    public function batchPublisher(array $options = [])
    {
        return new BatchPublisher(
            $this->name,
            $options + [
                'clientConfig' => $this->clientConfig
            ]
        );
    }

    /**
     * Create a subscription to the topic.
     *
     * Example:
     * ```
     * $subscription = $topic->subscribe('my-new-subscription');
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/create Create Subscription
     *
     * @param string $name The subscription name
     * @param array $options [optional] Please see {@see Subscription::create()}
     *        for configuration details.
     * @return Subscription
     */
    public function subscribe($name, array $options = [])
    {
        $subscription = $this->subscriptionFactory($name);
        $subscription->create($options);

        return $subscription;
    }

    /**
     * This method will not run any API requests. You will receive a
     * Subscription object that you can use to interact with the API.
     *
     * Example:
     * ```
     * $subscription = $topic->subscription('my-new-subscription');
     * ```
     *
     * @param string $name The subscription name
     * @return Subscription
     */
    public function subscription($name)
    {
        return $this->subscriptionFactory($name);
    }

    /**
     * Retrieve a list of active subscriptions to the current topic.
     *
     * Example:
     * ```
     * $subscriptions = $topic->subscriptions();
     * foreach ($subscriptions as $subscription) {
     *     echo $subscription->name();
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics.subscriptions/list List Topic Subscriptions
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type int $pageSize Maximum number of subscriptions to return.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Subscription>
     */
    public function subscriptions(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $resultLimit = $this->pluck('resultLimit', $data, false);

        $data['topic'] = $this->name;
        $request = $this->serializer->decodeMessage(new ListTopicSubscriptionsRequest(), $data);

        return new ItemIterator(
            new PageIterator(
                function ($subscription) {
                    return $this->subscriptionFactory($subscription);
                },
                function ($callOptions) use ($optionalArgs, $request) {
                    if (isset($callOptions['pageToken'])) {
                        $request->setPageToken($callOptions['pageToken']);
                    }

                    return $this->requestHandler->sendRequest(
                        PublisherClient::class,
                        'listTopicSubscriptions',
                        $request,
                        $optionalArgs
                    );
                },
                $options,
                [
                    'itemsKey' => 'subscriptions',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Manage the IAM policy for the current Topic.
     *
     * Example:
     * ```
     * $iam = $topic->iam();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/access_control PubSub Access Control Documentation
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/getIamPolicy Get Topic IAM Policy
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/setIamPolicy Set Topic IAM Policy
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/testIamPermissions Test Topic Permissions
     * @codingStandardsIgnoreEnd
     *
     * @return IamManager
     */
    public function iam()
    {
        if (!$this->iam) {
            $this->iam = new IamManager($this->requestHandler, $this->serializer, PublisherClient::class, $this->name);
        }

        return $this->iam;
    }

    /**
     * Present a nicer debug result to people using php 5.6 or greater.
     *
     * @return array
     * @codeCoverageIgnore
     * @access private
     */
    public function __debugInfo()
    {
        return [
            'name' => $this->name,
            'projectId' => $this->projectId,
            'info' => $this->info,
            'requestHandler' => $this->requestHandler
        ];
    }

    /**
     * Ensure that the message is in a correct format,
     * base64_encode the data, and error if the input is too wrong to proceed.
     *
     * @param Message|array $message
     * @return PubsubMessage The message protobuf object
     * @throws \InvalidArgumentException
     */
    private function formatMessage($message)
    {
        $message = $message instanceof Message
            ? $message->toArray()
            : $message;

        if (isset($message['data']) && $this->encode) {
            $message['data'] = base64_encode($message['data']);
        }

        if (!array_key_exists('data', $message) && !array_key_exists('attributes', $message)) {
            throw new InvalidArgumentException(
                'At least one of $data or $attributes must be specified on each
                message, but neither was given.'
            );
        }

        return $this->serializer->decodeMessage(
            new PubsubMessage(),
            $message
        );
    }

    private function formatSchemaSettings(array &$data)
    {
        if (isset($data['schemaSettings'])) {
            $enc = $data['schemaSettings']['encoding'] ?? Encoding::ENCODING_UNSPECIFIED;

            if (is_string($enc)) {
                $data['schemaSettings']['encoding'] = Encoding::value($enc);
            }

            if (isset($data['schemaSettings']['schema']) && $data['schemaSettings']['schema'] instanceof Schema) {
                $data['schemaSettings']['schema'] = $data['schemaSettings']['schema']->name();
            }

            $data['schemaSettings'] = $this->serializer->decodeMessage(
                new SchemaSettings(),
                $data['schemaSettings']
            );
        }
    }

    /**
     * Create a new subscription instance with the given name and optional
     * subscription data.
     *
     * @codingStandardsIgnoreStart
     * @param  string $name
     * @param  array $info [optional] A representation of a
     *         [Subscription](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions#Subscription)
     * @return Subscription
     * @codingStandardsIgnoreEnd
     */
    private function subscriptionFactory($name, array $info = [])
    {
        return new Subscription(
            $this->requestHandler,
            $this->serializer,
            $this->projectId,
            $name,
            $this->name,
            $this->encode,
            $info,
            $this->clientConfig
        );
    }
}
