<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

use Google\Cloud\Iam\Iam;
use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Connection\IamTopic;
use InvalidArgumentException;

/**
 * A named resource to which messages are sent by publishers.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $client = new ServiceBuilder();
 *
 * $pubsub = $client->pubsub();
 * $topic = $pubsub->topic('my-topic-name');
 * ```
 *
 * ```
 * // You can also pass a fully-qualified topic name:
 * $topic = $pubsub->topic('projects/my-awesome-project/topics/my-topic-name');
 * ```
 */
class Topic
{
    use ResourceNameTrait;

    /**
     * @var ConnectionInterface A connection to the Google Cloud Platform API
     */
    protected $connection;

    /**
     * @var string The topic name
     */
    private $name;

    /**
     * @var string The project ID
     */
    private $projectId;

    /**
     * @var array
     */
    private $info;

    /**
     * @var Iam
     */
    private $iam;

    /**
     * Create a PubSub topic.
     *
     * @param  ConnectionInterface $connection A connection to the Google Cloud
     *         Platform service
     * @param  string $name The topic name
     * @param  string $projectId The project Id
     * @param  array $info [optional] A [Topic](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics)
     */
    public function __construct(
        ConnectionInterface $connection,
        $name,
        $projectId,
        array $info = null
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->info = $info;

        // Accept either a simple name or a fully-qualified name.
        if ($this->isFullyQualifiedName('topic', $name)) {
            $this->name = $name;
        } else {
            $this->name = $this->formatName('topic', $name, $projectId);
        }

        $iamConnection = new IamTopic($this->connection);
        $this->iam = new Iam($iamConnection, $this->name);
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
     * $topic = $pubsub->topic('my-topic-name');
     * if ($topic->create()) {
     *     echo 'Topic Created!';
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/create Create Topic
     *
     * @param  array $options Configuration Options
     * @return array Topic information
     */
    public function create(array $options = [])
    {
        $this->info = $this->connection->createTopic($options + [
            'name' => $this->name
        ]);

        return $this->info;
    }

    /**
     * Delete a topic.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     *
     * $topic->delete();
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/delete Delete Topic
     *
     * @param  array $options Configuration Options
     * @return void
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteTopic($options + [
            'topic' => $this->name
        ]);
    }

    /**
     * Check if a topic exists.
     *
     * Service errors will NOT bubble up from this method. It will always return
     * a boolean value. If you want to check for errors, use
     * {@see Google\Cloud\PubSub\Topic::info()}.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     * if ($topic->exists()) {
     *     // do stuff
     * }
     * ```
     *
     * @param  array $options Configuration Options
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
     * a refresh from the API, use {@see Google\Cloud\Pubsub\Topic::reload()}.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     * $info = $topic->info();
     * echo $info['name']; // projects/my-awesome-project/topics/my-topic-name
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/get Get Topic
     *
     * @codingStandardsIgnoreStart
     * @param  array $options Configuration Options
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
     * cached result, if one exists, use {@see Google\Cloud\Pubsub\Topic::info()}.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     * $topic->reload();
     * $info = $topic->info();
     * echo $info['name']; // projects/my-awesome-project/topics/my-topic-name
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/get Get Topic
     *
     * @codingStandardsIgnoreStart
     * @param  array $options Configuration Options
     * @return array [A representation of a Topic](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics)
     * @codingStandardsIgnoreEnd
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getTopic($options + [
            'topic' => $this->name
        ]);
    }

    /**
     * Publish a new message to the topic.
     *
     * $message must provide at least one of `data` and `attributes` members.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     * $topic->publish([
     *     'data' => 'New User Registered',
     *     'attributes' => [
     *         'id' => 1,
     *         'userName' => 'John',
     *         'location' => 'Detroit'
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/publish Publish Message
     *
     * @param  string $message [Message Format](https://cloud.google.com/pubsub/docs/reference/rest/v1/PubsubMessage)
     * @param  array $options {
     *      Configuration Options
     *
     *      @type bool $encode If set to false, the message data will not be
     *            base64-encoded. Only turn this off if you have already encoded
     *            your message data. **Defaults to** `false`.
     * }
     * @return array A list of message IDs
     */
    public function publish(array $message, array $options = [])
    {
        return $this->publishBatch([$message], $options);
    }

    /**
     * Publish multiple messages at once.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     * $topic->publishBatch([
     *     [
     *         'data' => 'New User Registered',
     *         'attributes' => [
     *             'id' => 1,
     *             'userName' => 'John',
     *             'location' => 'Detroit'
     *         ]
     *     ], [
     *         'data' => 'New User Registered',
     *         'attributes' => [
     *             'id' => 2,
     *             'userName' => 'Steve',
     *             'location' => 'Mountain View'
     *         ]
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/publish Publish Message
     *
     * @param  array $messages A list of messages. Each message must be in the correct
     *         [Message Format](https://cloud.google.com/pubsub/docs/reference/rest/v1/PubsubMessage).
     *         If provided, $data will be base64 encoded before being published,
     *         unless `$options['encode']` is set to false. (See below for more
     *         details.)
     * @param  array $options {
     *     Configuration Options
     *
     *     @type bool $encode If set to false, the message data will not be
     *            base64-encoded. Only turn this off if you have already encoded
     *            your message data. **Defaults to** `false`.
     * }
     * @return array A list of message IDs.
     */
    public function publishBatch(array $messages, array $options = [])
    {
        $encode = (isset($options['encode'])) ? $options['encode'] : true;

        foreach ($messages as &$message) {
            $message = $this->formatMessage($message, $encode);
        }

        return $this->connection->publishMessage($options + [
            'topic' => $this->name,
            'messages' => $messages
        ]);
    }

    /**
     * Create a subscription to the topic.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     *
     * $topic->subscribe('my-new-subscription');
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/create Create Subscription
     *
     * @param  string $name The subscription name
     * @param  array  $options Please see {@see Google\Cloud\PubSub\Subscription::create()} for configuration details.
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
     * $topic = $pubsub->topic('my-topic-name');
     *
     * $topic->subscribe('my-new-subscription');
     * ```
     *
     * @param  string $name The subscription name
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
     * $topic = $pubsub->topic('my-topic-name');
     *
     * $subscriptions = $topic->subscriptions();
     * foreach ($subscriptions as $subscription) {
     *     var_dump($subscription->info());
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics.subscriptions/list List Topic Subscriptions
     * @codingStandardsIgnoreEnd
     *
     * @param  array $options {
     *     Configuration Options
     *
     *     @type int $pageSize Maximum number of subscriptions to return.
     * }
     * @return \Generator<Google\Cloud\PubSub\Subscription>
     */
    public function subscriptions(array $options = [])
    {
        $options['pageToken'] = null;

        do {
            $response = $this->connection->listSubscriptionsByTopic($options + [
                'topic' => $this->name
            ]);

            foreach ($response['subscriptions'] as $subscription) {
                yield $this->subscriptionFactory($subscription);
            }

            // If there's a page token, we'll request the next page.
            $options['pageToken'] = isset($response['nextPageToken'])
                ? $response['nextPageToken']
                : null;
        } while ($options['pageToken']);
    }

    /**
     * Manage the IAM policy for the current Topic.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     *
     * $currentPolicy = $topic->iam()->policy();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/access_control PubSub Access Control Documentation
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/getIamPolicy Get Topic IAM Policy
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/setIamPolicy Set Topic IAM Policy
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.topics/testIamPermissions Test Topic Permissions
     * @codingStandardsIgnoreEnd
     *
     * @return Iam
     */
    public function iam()
    {
        return $this->iam;
    }

    /**
     * Present a nicer debug result to people using php 5.6 or greater.
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
            'connection' => get_class($this->connection)
        ];
    }

    /**
     * Ensure that the message is in a correct format,
     * base64_encode the data, and error if the input is too wrong to proceed.
     * @param  array $message
     * @param  bool $encode [optional]
     * @return array The message data
     * @throws \InvalidArgumentException
     */
    private function formatMessage(array $message, $encode = true)
    {
        if (isset($message['data']) && $encode) {
            $message['data'] = base64_encode($message['data']);
        }

        if (!array_key_exists('data', $message) &&
            !array_key_exists('attributes', $message)) {
            throw new InvalidArgumentException('At least one of $data or
                $attributes must be specified on each message, but neither
                was given.');
        }

        return $message;
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
    private function subscriptionFactory($name, array $info = null)
    {
        return new Subscription(
            $this->connection,
            $name,
            $this->name,
            $this->projectId,
            $info
        );
    }
}
