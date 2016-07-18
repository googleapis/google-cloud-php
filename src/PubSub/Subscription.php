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

use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Iam\Iam;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Connection\IamSubscription;
use InvalidArgumentException;

/**
 * A named resource representing the stream of messages from a single, specific
 * topic, to be delivered to the subscribing application.
 */
class Subscription
{
    use ResourceNameTrait;

    const MAX_MESSAGES = 1000;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $topicName;

    /**
     * @var string
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
     * Create a Subscription.
     *
     * The idiomatic way to use this class is through the PubSubClient or Topic,
     * but you can instantiate it directly as well.
     *
     * Example:
     * ```
     * // Create subscription through a topic
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * $pubsub = $cloud->pubsub();
     *
     * $topic = $pubsub->topic('my-topic-name');
     *
     * $subscription = $topic->subscription('my-new-subscription');
     *
     * // Create subscription through PubSubClient
     *
     * use Google\Cloud\PubSub\PubSubClient;
     *
     * $pubsub = new PubSubClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * $subscription = $pubsub->subscription(
     *     'my-new-subscription',
     *     'my-topic-name'
     * );
     *
     * // Create subscription directly
     * use Google\Cloud\Pubsub\Subscription;
     *
     * $subscription = new Subscription(
     *     $connection
     *     'my-new-subscription',
     *     'my-topic-name',
     *     'my-awesome-project'
     * );
     * ```
     *
     * @param  ConnectionInterface $connection The service connection object
     * @param  string $name The subscription name
     * @param  string $topicName The topic name the subscription is attached to
     * @param  string $projectId The current project
     * @param  array $info Subscription info. Used to pre-populate the object.
     */
    public function __construct(
        ConnectionInterface $connection,
        $name,
        $topicName,
        $projectId,
        array $info = null
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->info = $info;

        // Accept either a simple name or a fully-qualified name.
        if ($this->isFullyQualifiedName('subscription', $name)) {
            $this->name = $name;
        } else {
            $this->name = $this->formatName('subscription', $name, $projectId);
        }

        // Accept either a simple name or a fully-qualified name.
        if ($this->isFullyQualifiedName('topic', $topicName)) {
            $this->topicName = $topicName;
        } else {
            $this->topicName = !is_null($topicName)
                ? $this->formatName('topic', $topicName, $projectId)
                : null;
        }

        $iamConnection = new IamSubscription($this->connection);
        $this->iam = new Iam($iamConnection, $this->name);
    }

    /**
     * Get the subscription name
     *
     * Example:
     * ```
     * echo $subscription->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Execute a service request creating the subscription.
     *
     * The suggested way of creating a subscription is by calling through
     * {@see Google\Cloud\PubSub\Topic::subscribe()} or {@see Google\Cloud\PubSub\Topic::subscription()}.
     *
     * Returns subscription info in the format detailed in the documentation
     * for a [subscription](https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions#Subscription).
     *
     * **NOTE: Some methods of instantiation of a Subscription do not supply a
     * topic name. The topic name is required to create a subscription.**
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     *
     * $subscription = $topic->subscription('my-new-subscription');
     * $result = $subscription->create();
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/create Create Subscription API
     *      Documentation
     *
     * @param  array $options {
     *     Configuration Options
     *
     *     @type int $ackDeadlineSeconds This value is the maximum time after a
     *           subscriber receives a message before the subscriber should
     *           acknowledge the message. If not set, the default value of 10 is
     *           used.
     *     @type array $pushConfig See {@see Google\Cloud\PubSub\Subscription::modifyPushConfig()} or
     *           [PushConfig](https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions#PushConfig)
     *           for usage.
     * }
     * @return array An array of subscription info
     * @throws \InvalidArgumentException
     */
    public function create(array $options = [])
    {
        // If a subscription is created via PubSubClient::subscription(),
        // it may or may not have a topic name. This is fine for most API
        // interactions, but a topic name is required to create a subscription.
        if (!$this->topicName) {
            throw new InvalidArgumentException('A topic name is required to
                create a subscription.');
        }

        $this->info = $this->connection->createSubscription($options + [
            'name' => $this->name,
            'topic' => $this->topicName
        ]);

        return $this->info;
    }

    /**
     * Delete a subscription
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $subscription->delete();
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/delete Delete Subscription API
     *      Documentation
     *
     * @param  array $options Configuration Options.
     * @return void
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteSubscription($options + [
            'subscription' => $this->name
        ]);
    }

    /**
     * Check if a subscription exists.
     *
     * Service errors will NOT bubble up from this method. It will always return
     * a boolean value. If you want to check for errors, use
     * {@see Google\Cloud\PubSub\Subscription::info()}.
     *
     * If you need to re-check the existence of a subscription that is already
     * downloaded, call {@see Google\Cloud\PubSub\Subscription::reload()} first
     * to refresh the cached information.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * if ($subscription->exists()) {
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
     * Get info on a subscription
     *
     * If the info is already cached on the object, it will return that result.
     * To fetch a fresh result, use {@see Google\Cloud\PubSub\Subscription::reload()}.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $info = $subscription->info();
     * echo $info['name']; // `projects/my-awesome-project/subscriptions/my-new-subscription`
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/get Get Subscription API
     *      Documentation
     *
     * @param  array $options Configuration Options
     * @return array Subscription data
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Retrieve info on a subscription from the API.
     *
     * To use the previously cached result (if it exists), use
     * {@see Subscription::info()}.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $subscription->reload();
     * $info = $subscription->info();
     * echo $info['name']; // `projects/my-awesome-project/subscriptions/my-new-subscription`
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/get Get Subscription API
     *      Documentation
     *
     * @param  array $options Configuration Options
     * @return array Subscription data
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getSubscription($options + [
            'subscription' => $this->name
        ]);
    }

    /**
     * Retrieve new messages from the topic.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $messages = $subscription->pull();
     * foreach ($messages as $message) {
     *     echo $message['data'];
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/pull Pull Subscriptions API
     *      Documentation
     *
     * @param  array $options {
     *      Configuration Options
     *
     *      @type bool $returnImmediately If set, the system will respond
     *            immediately, even if no messages are available. Otherwise,
     *            wait until new messages are available.
     *      @type int  $maxMessages Limit the amount of messages pulled.
     * }
     * @return \Generator
     */
    public function pull(array $options = [])
    {
        $options['pageToken'] = null;
        $options['returnImmediately'] = isset($options['returnImmediately'])
            ? $options['returnImmediately']
            : false;

        $options['maxMessages'] = isset($options['maxMessages'])
            ? $options['maxMessages']
            : self::MAX_MESSAGES;

        do {
            $response = $this->connection->pull($options + [
                'subscription' => $this->name
            ]);

            if (isset($response['receivedMessages'])) {
                foreach ($response['receivedMessages'] as $message) {
                    yield $message;
                }
            }

            // If there's a page token, we'll request the next page.
            $options['pageToken'] = isset($response['nextPageToken'])
                ? $response['nextPageToken']
                : null;
        } while ($options['pageToken']);
    }

    /**
     * Acknowledge receipt of a message.
     *
     * Use {@see Google\Cloud\PubSub\Subscription::acknowledgeBatch()} to
     * acknowledge multiple messages at once.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $messages = $subscription->pull();
     *
     * $lastMessageAckId = null;
     *
     * foreach ($messages as $message) {
     *     $lastMessageAckId = $message['ackId'];
     * }
     *
     * if (!is_null($lastMessageAckId)) {
     *     $subscription->acknowledge($lastMessageAckId);
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/acknowledge Acknowledge Message API
     *      Documentation
     *
     * @param  int $ackId A message's ackId
     * @param  array $options Configuration Options
     * @return void
     */
    public function acknowledge($ackId, array $options = [])
    {
        $this->acknowledgeBatch([$ackId], $options);
    }

    /**
     * Acknowledge receipt of multiple messages at once.
     *
     * Use {@see Google\Cloud\PubSub\Subscription::acknowledge()} to acknowledge
     * a single message.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $messages = $subscription->pull();
     *
     * $ackIds = [];
     * foreach ($messages as $message) {
     *     $ackIds[] = $message['ackId'];
     * }
     *
     * if (!empty($lastMessageId)) {
     *     $subscription->acknowledgeBatch($ackIds);
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/acknowledge Acknowledge Message API
     *      Documentation
     *
     * @param  array $ackIds An array of message ackIds.
     * @param  array $options Configuration Options
     * @return void
     */
    public function acknowledgeBatch(array $ackIds, array $options = [])
    {
        $this->connection->acknowledge($options + [
            'subscription' => $this->name,
            'ackIds' => $ackIds
        ]);
    }

    /**
     * Set the acknowledge deadline for a single ackId.
     *
     * Use {@see Google\Cloud\PubSub\Subscription::modifyAckDeadlineBatch()} to
     * modify the ack deadline for multiple messages at once.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $messages = $subscription->pull();
     *
     * foreach ($messages as $message) {
     *     $subscription->modifyAckDeadline($message['ackId'], 90);
     *     sleep(80);
     *
     *     // Now we'll acknowledge!
     *     $subscription->acknowledge($message['ackId']);
     *
     *     break;
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/modifyAckDeadline Modify Ack
     *      Deadline API Documentation
     *
     * @param  string $ackId An acknowledgement ID
     * @param  int $seconds The new ack deadline with respect to the time
     *         this request was sent to the Pub/Sub system. Must be >= 0. For
     *         example, if the value is 10, the new ack deadline will expire 10
     *         seconds after the ModifyAckDeadline call was made. Specifying
     *         zero may immediately make the message available for another pull
     *         request.
     * @param  array $options Configuration Options
     * @return void
     */
    public function modifyAckDeadline($ackId, $seconds, array $options = [])
    {
        $this->modifyAckDeadlineBatch([$ackId], $seconds, $options);
    }

    /**
     * Set the acknowledge deadline for multiple ackIds.
     *
     * Use {@see Google\Cloud\PubSub\Subscription::modifyAckDeadline()} to
     * modify the ack deadline for a single message.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $messages = $subscription->pull();
     *
     * $ackIds = [];
     * foreach ($messages as $message) {
     *     $ackIds[] = $message['ackId'];
     * }
     *
     * // Set the ack deadline to a minute and a half from now for every message
     * $subscription->modifyAckDeadlineBatch($ackIds, 90);
     *
     * // Delay execution, or make a sandwich or something.
     * sleep(80);
     *
     * // Now we'll acknowledge
     * $subscription->acknowledge($ackIds);
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/modifyAckDeadline Modify Ack
     *      Deadline API Documentation
     *
     * @param  string $ackIds List of acknowledgment IDs.
     * @param  int $seconds The new ack deadline with respect to the time
     *         this request was sent to the Pub/Sub system. Must be >= 0. For
     *         example, if the value is 10, the new ack deadline will expire 10
     *         seconds after the ModifyAckDeadline call was made. Specifying
     *         zero may immediately make the message available for another pull
     *         request.
     * @param  array $options Configuration Options
     * @return void
     */
    public function modifyAckDeadlineBatch(array $ackIds, $seconds, array $options = [])
    {
        $this->connection->modifyAckDeadline($options + [
            'subscription' => $this->name,
            'ackIds' => $ackIds,
            'ackDeadlineSeconds' => $seconds
        ]);
    }

    /**
     * Set the push config for the subscription
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     * $subscription->modifyPushConfig([
     *     'pushEndpoint' => 'https://www.example.com/foo/bar'
     * ]);
     * ```
     *
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/modifyPushConfig Modify Push Config
     *      API Documentation
     *
     * @param  array $pushConfig {
     *     Push delivery configuration. See
     *     [PushConfig](https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions#PushConfig)
     *     for more details.
     *
     *     @type string $pushEndpoint A URL locating the endpoint to which
     *           messages should be pushed. For example, a Webhook endpoint
     *           might use "https://example.com/push".
     *     @type array $attributes Endpoint configuration attributes.
     * }
     * @param  array $options Configuration Options
     * @return void
     */
    public function modifyPushConfig(array $pushConfig, array $options = [])
    {
        $this->connection->modifyPushConfig($options + [
            'subscription' => $this->name,
            'pushConfig' => $pushConfig
        ]);
    }

    /**
     * Manage the IAM policy for the current Subscription.
     *
     * Example:
     * ```
     * $subscription = $pubsub->subscription('my-new-subscription');
     *
     * $currentPolicy = $subscription->iam()->policy();
     * ```
     *
     * @see https://cloud.google.com/pubsub/access_control PubSub Access Control Documentation
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/getIamPolicy Get Subscription IAM
     *      Policy API Documentation
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/setIamPolicy Set Subscription IAM
     *      Policy API Documentation
     * @see https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions/testIamPermissions Test
     *      Subscription Permissions API Documentation
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
            'topicName' => $this->topicName,
            'projectId' => $this->projectId,
            'info' => $this->info,
            'connection' => get_class($this->connection)
        ];
    }
}
