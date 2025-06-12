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

use Google\ApiCore\ClientOptionsTrait;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\DetectProjectIdTrait;
use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\Client\SchemaServiceClient;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\CreateSchemaRequest;
use Google\Cloud\PubSub\V1\Encoding;
use Google\Cloud\PubSub\V1\ListSchemasRequest;
use Google\Cloud\PubSub\V1\ListSnapshotsRequest;
use Google\Cloud\PubSub\V1\ListSubscriptionsRequest;
use Google\Cloud\PubSub\V1\ListTopicsRequest;
use Google\Cloud\PubSub\V1\Schema as SchemaProto;
use Google\Cloud\PubSub\V1\Schema\Type;
use Google\Cloud\PubSub\V1\ValidateMessageRequest;
use Google\Cloud\PubSub\V1\ValidateSchemaRequest;

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
 * $pubsub = new PubSubClient(['projectId' => 'my-project']);
 * ```
 *
 * ```
 * // Using the Pub/Sub Emulator
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * // Be sure to use the port specified when starting the emulator.
 * // `8900` is used as an example only.
 * putenv('PUBSUB_EMULATOR_HOST=localhost:8900');
 *
 * $pubsub = new PubSubClient(['projectId' => 'my-project']);
 * ```
 */
class PubSubClient
{
    use DetectProjectIdTrait;
    use IncomingMessageTrait;
    use ResourceNameTrait;
    use ApiHelperTrait;
    use ClientOptionsTrait;

    const VERSION = '2.12.0';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/pubsub';

    private const GAPIC_KEYS = [
        PublisherClient::class,
        SubscriberClient::class,
        SchemaServiceClient::class
    ];

    // The name of the service. Used in debug logging.
    private const SERVICE_NAME = 'google.pubsub.v2.Pubsub';

    /**
     * @var RequestHandler
     * @internal
     * The request handler that is responsible for sending a request and
     * serializing responses into relevant classes.
     */
    private $requestHandler;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

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
     *     @type string $apiEndpoint The hostname with optional port to use in
     *           place of the default service endpoint. Example:
     *           `foobar.com` or `foobar.com:1234`.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *           *Important*: If you accept a credential configuration (credential
     *           JSON/File/Stream) from an external source for authentication to Google Cloud
     *           Platform, you must validate it before providing it to any Google API or library.
     *           Providing an unvalidated credential configuration to Google APIs can compromise
     *           the security of your systems and data. For more information {@see
     *           https://cloud.google.com/docs/authentication/external/externally-sourced-credentials}
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the
     *           client. For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()} .
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string
     *           `rest` or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already
     *           instantiated {@see \Google\ApiCore\Transport\TransportInterface} object. Note
     *           that when this object is provided, any settings in $transportConfig, and any
     *           $apiEndpoint setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...],
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        // configure custom client options
        $emulatorHost = getenv('PUBSUB_EMULATOR_HOST');
        $config += [
            'scopes' => [self::FULL_CONTROL_SCOPE],
            'projectIdRequired' => true,
            'hasEmulator' => (bool) $emulatorHost,
            'emulatorHost' => $emulatorHost,
            'transportConfig' => [
                'grpc' => [
                    // increase default limit to 4MB to prevent metadata exhausted errors
                    'stubOpts' => ['grpc.max_metadata_size' => 4 * 1024 * 1024, ]
                ]
            ]
        ];

        // Configure GAPIC client options
        $config = $this->buildClientOptions($config);
        $config['credentials'] = $this->createCredentialsWrapper(
            $config['credentials'],
            $config['credentialsConfig'],
            $config['universeDomain']
        );

        $this->projectId = $this->detectProjectId($config);

        $this->clientConfig = $config;
        $this->serializer = new Serializer([
            'publish_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'expiration_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [], [], [
            'google.protobuf.Duration' => function ($v) {
                return $this->formatDurationForApi($v);
            }
        ]);

        $this->requestHandler = new RequestHandler(
            $this->serializer,
            self::GAPIC_KEYS,
            $config
        );
    }

    /**
     * Create a topic.
     *
     * Unlike {@see PubSubClient::topic()}, this method will send an API call to
     * create the topic. If the topic already exists, an exception will be
     * thrown. When in doubt, use {@see PubSubClient::topic()}.
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
     * @param array $options [optional] Configuration Options. For available
     *        configuration options, refer to
     *        {@see Topic::create()} {
     *        @type bool $enableCompression Flag to enable compression of messages
     *              before publishing. Set the flag to `true` to enable compression.
     *              Defaults to `false`. Messsages are compressed if their total
     *              size >= `compressionBytesThreshold`, whose default value has
     *              been experimentally derived after performance evaluations.
     *        @type int $compressionBytesThreshold The threshold byte size
     *              above which messages are compressed. This only takes effect
     *              if `enableCompression` is set to `true`. Defaults to `240`.
     *              (This value is experiementally derived after performance evaluations.)
     * }.
     * @return Topic
     */
    public function createTopic($name, array $options = [])
    {
        $topic = $this->topicFactory($name, $options);
        $topic->create($options);

        return $topic;
    }

    /**
     * Lazily instantiate a topic with a topic name.
     *
     * No API requests are made by this method. If you want to create a new
     * topic, use {@see Topic::create()}.
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
     * @param array $options [optional] Configuration Options {
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

     * @return Topic
     */
    public function topic($name, $options = [])
    {
        return $this->topicFactory($name, $options);
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
     * @return ItemIterator<Topic>
     */
    public function topics(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $resultLimit = $this->pluck('resultLimit', $data, false);

        $data['project'] = $this->formatName('project', $this->projectId);
        $request = $this->serializer->decodeMessage(new ListTopicsRequest(), $data);

        return new ItemIterator(
            new PageIterator(
                function (array $topic) {
                    return $this->topicFactory($topic['name'], $topic);
                },
                function ($callOptions) use ($optionalArgs, $request) {
                    if (isset($callOptions['pageToken'])) {
                        $request->setPageToken($callOptions['pageToken']);
                    }

                    return $this->requestHandler->sendRequest(
                        PublisherClient::class,
                        'listTopics',
                        $request,
                        $optionalArgs
                    );
                },
                $optionalArgs,
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
     * Use {@see PubSubClient::subscription()} to create a subscription object
     * without any API requests. If the topic already exists, an exception will
     * be thrown. When in doubt, use {@see PubSubClient::subscription()}.
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
     * @param Topic|string $topic The topic to which the new subscription will be subscribed.
     * @param array  $options [optional] Please see {@see Subscription::create()}
     *        for configuration details.
     * @return Subscription
     */
    public function subscribe($name, $topic, array $options = [])
    {
        $subscription = $this->subscriptionFactory($name, $topic);
        $subscription->create($options);

        return $subscription;
    }

    /**
     * Lazily instantiate a subscription with a subscription name.
     *
     * This method will NOT perform any API calls. If you wish to create a new
     * subscription, use {@see PubSubClient::subscribe()}.
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
     * @return ItemIterator<Subscription>
     */
    public function subscriptions(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $resultLimit = $this->pluck('resultLimit', $data, false);

        $data['project'] = $this->formatName('project', $this->projectId);
        $request = $this->serializer->decodeMessage(new ListSubscriptionsRequest(), $data);

        return new ItemIterator(
            new PageIterator(
                function (array $subscription) {
                    return $this->subscriptionFactory(
                        $subscription['name'],
                        $subscription['topic'],
                        $subscription
                    );
                },
                function ($callOptions) use ($optionalArgs, $request) {
                    if (isset($callOptions['pageToken'])) {
                        $request->setPageToken($callOptions['pageToken']);
                    }

                    return $this->requestHandler->sendRequest(
                        SubscriberClient::class,
                        'listSubscriptions',
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
        return new Snapshot(
            $this->requestHandler,
            $this->serializer,
            $this->projectId,
            $name,
            $this->encode,
            $info,
            $this->clientConfig
        );
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
     * @return ItemIterator<Snapshot>
     */
    public function snapshots(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $resultLimit = $this->pluck('resultLimit', $data, false);

        $data['project'] = $this->formatName('project', $this->projectId);
        $request = $this->serializer->decodeMessage(new ListSnapshotsRequest(), $data);

        return new ItemIterator(
            new PageIterator(
                function (array $snapshot) {
                    return new Snapshot(
                        $this->requestHandler,
                        $this->serializer,
                        $this->projectId,
                        $this->pluckName('snapshot', $snapshot['name']),
                        $this->encode,
                        $snapshot
                    );
                },
                function ($callOptions) use ($optionalArgs, $request) {
                    if (isset($callOptions['pageToken'])) {
                        $request->setPageToken($callOptions['pageToken']);
                    }

                    return $this->requestHandler->sendRequest(
                        SubscriberClient::class,
                        'listSnapshots',
                        $request,
                        $optionalArgs
                    );
                },
                $options,
                [
                    'itemsKey' => 'snapshots',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Lazily instantiate a schema object.
     *
     * Example:
     * ```
     * $schema = $pubsub->schema('my-schema');
     * ```
     *
     * @param string $schemaId The schema ID. Must exist in the current project.
     * @param array $info [optional] The schema resource info.
     * @return Schema
     */
    public function schema($schemaId, array $info = [])
    {
        return new Schema(
            $this->requestHandler,
            $this->serializer,
            SchemaServiceClient::schemaName($this->projectId, $schemaId),
            $info
        );
    }

    /**
     * Creates and returns a new schema.
     *
     * Example:
     * ```
     * $definition = file_get_contents('my-schema.txt');
     * $schema = $pubsub->createSchema('my-schema', 'AVRO', $definition);
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas/create Create Schema
     *
     * @param string $schemaId The desired schema ID.
     * @param string $type The schema type. Allowed values are `AVRO` and `PROTOCOL_BUFFER`.
     * @param string $definition The definition of the schema. This should
     *     contain a string representing the full definition of the schema that
     *     is a valid schema definition of the type specified in `type`. See
     *     [Schema](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas#Schema)
     *     for details.
     * @param array $options [optional] Configuration options
     * @return Schema
     */
    public function createSchema($schemaId, $type, $definition, array $options = [])
    {
        $type = is_string($type) ? Type::value($type) : $type;
        $parent = SchemaServiceClient::projectName($this->projectId);
        $schema = new SchemaProto([
            'type' => $type,
            'definition' => $definition,
        ]);

        $data = ['parent' => $parent, 'schema' => $schema, 'schemaId' => $schemaId];
        $request = $this->serializer->decodeMessage(new CreateSchemaRequest(), $data);

        $res = $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'createSchema',
            $request,
            $options
        );

        return $this->schema($schemaId, $res);
    }

    /**
     * Lists all schemas in the current project.
     *
     * Please note that the schemas returned will not contain the entire resource.
     * If you need details on the full resource, call {@see Schema::reload()}
     * on the resource in question, or set `$options.view` to `FULL`.
     *
     * Example:
     * ```
     * $schemas = $pubsub->schemas();
     * foreach ($schemas as $schema) {
     *     $info = $schema->info();
     *     echo $info['name']; // `projects/my-awesome-project/schemas/my-new-schema`
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas/list List Schemas
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $view The set of Schema fields to return in the
     *           response. If not set, returns Schemas with `name` and `type`,
     *           but not `definition`. Set to `FULL` to retrieve all fields. For
     *           allowed values, use constants defined on
     *           {@see \Google\Cloud\PubSub\V1\SchemaView}.
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Schema>
     */
    public function schemas(array $options = [])
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $resultLimit = $this->pluck('resultLimit', $data, false);

        $data['parent'] = $this->formatName('project', $this->projectId);
        $request = $this->serializer->decodeMessage(new ListSchemasRequest(), $data);

        return new ItemIterator(
            new PageIterator(
                function (array $schema) {
                    $parts = SchemaServiceClient::parseName($schema['name'], 'schema');
                    return $this->schema($parts['schema'], $schema);
                },
                function ($callOptions) use ($optionalArgs, $request) {
                    if (isset($callOptions['pageToken'])) {
                        $request->setPageToken($callOptions['pageToken']);
                    }

                    return $this->requestHandler->sendRequest(
                        SchemaServiceClient::class,
                        'listSchemas',
                        $request,
                        $optionalArgs
                    );
                },
                $options,
                [
                    'itemsKey' => 'schemas',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Verify that a schema is valid.
     *
     * If the schema is valid, the response will be empty. If invalid, a
     * {@see \Google\Cloud\Core\Exception\BadRequestException} will be thrown.
     *
     * Example:
     * ```
     * use Google\Cloud\Core\Exception\BadRequestException;
     *
     * $definition = file_get_contents('my-schema.txt');
     * try {
     *     $pubsub->validateSchema([
     *         'type' => 'AVRO',
     *         'definition' => $definition
     *     ]);
     *
     *     echo "schema is valid!";
     * } catch (BadRequestException $e) {
     *     echo $e->getMessage();
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas/validate Validate Schema
     *
     * @param array $schema The schema to validate. See
     *     [Schema](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas#Schema)
     *     for available parameters.
     * @param array $options [optional] Configuration options
     * @return void
     * @throws BadRequestException if the schema is invalid.
     */
    public function validateSchema(array $schema, array $options = [])
    {
        $parent = SchemaServiceClient::projectName($this->projectId);
        $schemaObj = new SchemaProto([
            'definition' => $schema['definition'],
            'type' => Type::value($schema['type']),
        ]);

        $data = ['parent' => $parent, 'schema' => $schemaObj];
        $request = $this->serializer->decodeMessage(new ValidateSchemaRequest(), $data);

        return $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'validateSchema',
            $request,
            $options
        );
    }

    /**
     * Validate a given message against a schema.
     *
     * If the message is valid, the response will be empty. If invalid, a
     * {@see \Google\Cloud\Core\Exception\BadRequestException} will be thrown.
     *
     * Example:
     * ```
     * use Google\Cloud\Core\Exception\BadRequestException;
     *
     * $schema = $pubsub->schema('my-schema');
     *
     * try {
     *     $pubsub->validateMessage($schema, $message, 'JSON');
     *
     *     echo "message is valid!";
     * } catch (BadRequestException $e) {
     *     echo $e->getMessage();
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas/validateMessage Validate Message
     *
     * @param Schema|string|array $schema The schema to validate against. If a
     *     string is given, it should be a fully-qualified schema name, e.g.
     *     `projects/my-project/schemas/my-schema`. If an instance of
     *     {@see Schema} is provided, it must exist in the
     *     current project. If an array is given, see
     *     [Schema](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.schemas#Schema)
     *     for definition. The array representation allows for validation of
     *     messages using ad-hoc schema; these do not have to exist in the
     *     current project in order to be used for validation.
     * @param string $message The base64 encoded message to validate.
     * @param string $encoding Either `JSON` or `BINARY`.
     * @param array $options [optional] Configuration options
     * @return void
     * @throws BadRequestException if the message is invalid.
     */
    public function validateMessage($schema, $message, $encoding, array $options = [])
    {
        $parent = SchemaServiceClient::projectName($this->projectId);
        $data = ['parent' => $parent, 'message' => $message, 'encoding' => Encoding::value($encoding)];

        if (is_string($schema)) {
            $data['name'] = $schema;
        } elseif ($schema instanceof Schema) {
            $data['name'] = $schema->name();
        } elseif (is_array($schema)) {
            $data['schema'] = new SchemaProto([
                'definition' => $schema['definition'],
                'type' => Type::value($schema['type']),
            ]);
        } else {
            throw new \InvalidArgumentException(sprintf(
                'Schema must be a string, array, or instance of %s',
                Schema::class
            ));
        }
        $request = $this->serializer->decodeMessage(new ValidateMessageRequest(), $data);

        return $this->requestHandler->sendRequest(
            SchemaServiceClient::class,
            'validateMessage',
            $request,
            $options
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
        return $this->messageFactory($requestData, $this->projectId, $this->encode);
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
            $this->requestHandler,
            $this->serializer,
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
     * @param Topic|string $topic [optional] The topic name
     * @param array $info [optional] Information about the subscription. Used
     *        to populate subscriptons with an API result. Should be a
     *        representation of a [Subscription](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions#Subscription).
     * @return Subscription
     * @codingStandardsIgnoreEnd
     */
    private function subscriptionFactory($name, $topic = null, array $info = [])
    {
        $topic = $topic instanceof Topic
            ? $topic->name()
            : $topic;

        return new Subscription(
            $this->requestHandler,
            $this->serializer,
            $this->projectId,
            $name,
            $topic,
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
        $debugInfo = [];

        $debugInfo['projectId'] = $this->projectId;
        $debugInfo['encode'] = $this->encode;
        $debugInfo['requestHandler'] = $this->requestHandler;

        return $debugInfo;
    }
}
