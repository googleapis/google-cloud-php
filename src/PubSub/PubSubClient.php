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

namespace Google\Cloud\PubSub;

use Google\Cloud\PubSub\Connection\Rest;
use InvalidArgumentException;

/**
 * Google Cloud Pub/Sub client. Allows you to send and receive
 * messages between independent applications. Find more information at
 * [Google Cloud Pub/Sub docs](https://cloud.google.com/pubsub/docs/).
 */
class PubSubClient
{
    use ResourceNameTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/pubsub';

    /**
     * @var string The project ID created in the Google Developers Console.
     */
    private $projectId;

    /**
     * Create a PubSub client.
     *
     * Example:
     * ```php
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * $pubsub = $cloud->pubsub();
     *
     * // The PubSub client can also be instantianted directly.
     * use Google\Cloud\PubSub\PubSubClient;
     *
     * $pubsub = new PubSubClient([
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
        if (!isset($config['projectId'])) {
            throw new InvalidArgumentException('A projectId is required.');
        }

        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($config);
        $this->projectId = $config['projectId'];
    }

    /**
     * Create a topic.
     *
     * Unlike {@see PubSubClient::topic()}, this method will send an API call to
     * create the topic. If the topic already exists, an exception will be
     * thrown. When in doubt, use {@see PubSubClient::topic()}.
     *
     * Example:
     * ```php
     * use Google\Cloud\PubSub\StorageClient;
     *
     * $pubsub = new PubSubClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * $topic = $pubsub->createTopic('my-new-topic');
     * echo $topic->info()['name']; // `projects/my-awesome-project/topics/my-new-topic`
     * ```
     *
     * @param  string $name    The topic name
     * @param  array  $options Configuration Options
     * @return Topic
     */
    public function createTopic($name, array $options = [])
    {
        $topic = $this->topic($name);
        $topic->create($options);

        return $topic;
    }

    /**
     * Get a topic by its name.
     *
     * No API requests are made by this method. If you want to create a new
     * topic, use {@see Topic::createTopic()}.
     *
     * Example:
     * ```php
     * use Google\Cloud\PubSub\StorageClient;
     *
     * $pubsub = new PubSubClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * // No API request yet!
     * $topic = $pubsub->topic('my-new-topic');
     *
     * // This will execute an API call.
     * echo $topic->info()['name']; // `projects/my-awesome-project/topics/my-new-topic`
     * ```
     *
     * @param  string $name The topic name
     * @param  array  $info Information about the topic. Used internally to
     *         populate topic objects with an API result. Should be
     *         an instance of[https://cloud.google.com/pubsub/reference/rest/v1/projects.topics#Topic](Topic).
     * @return Topic
     */
    public function topic($name, array $info = null)
    {
        return new Topic($this->connection, $name, $this->projectId, $info);
    }

    /**
     * Get a list of the topics registered to your project.
     *
     * Example:
     * ```php
     * use Google\Cloud\PubSub\StorageClient;
     *
     * $pubsub = new PubSubClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * $topics = $pubsub->topics();
     * foreach ($topics as $topic) {
     *      $info = $topic->info();
     *      echo $info['name']; // `projects/my-awesome-project/topics/<topic-name>`
     * }
     * ```
     *
     * @param  array     $options {
     *     Configuration Options
     *
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     * }
     * @return Generator
     */
    public function topics(array $options = [])
    {
        $options['pageToken'] = null;

        do {
            $response = $this->connection->listTopics($options + [
                'project' => $this->formatName('project', $this->projectId)
            ]);

            foreach ($response['topics'] as $topic) {
                yield $this->topic($topic['name'], $topic);
            }

            // If there's a page token, we'll request the next page.
            $options['pageToken'] = isset($response['nextPageToken'])
                ? $response['nextPageToken']
                : null;
        } while ($options['pageToken']);
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
     * ```php
     * use Google\Cloud\ServiceBuilder;
     *
     * $pubsub = new PubSubClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * // Create a subscription. If it doesn't exist in the API, it will be created.
     * $subscription = $pubsub->subscribe('my-new-subscription', 'my-topic-name');
     * ```
     *
     * @param  string       $name      A subscription name
     * @param  string       $topicName The topic to which the new subscription will be subscribed.
     * @param  array        $options Please see {@see Subscription::create()} for configuration details.
     * @return Subscription
     */
    public function subscribe($name, $topicName, array $options = [])
    {
        $subscription = $this->subscription($name, $topicName);
        $subscription->create($options);

        return $subscription;
    }

    /**
     * Get a single subscription by its name.
     *
     * This method will NOT perform any API calls. If you wish to create a new
     * subscription, use {@see PubSubClient::subscribe()}.
     *
     * Example:
     * ```php
     * use Google\Cloud\PubSub\StorageClient;
     *
     * $pubsub = new PubSubClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * // Create a subscription object. You should check if it exists before
     * // using it, unless you're sure it's there.
     * $subscription = $pubsub->subscription('my-new-subscription');
     * ```
     *
     * @param  string       $name      The subscription name
     * @param  string       $topicName The topic name
     * @param  array        $info      Information about the subscription. Used
     *         to populate subscriptons with an api result. Should be an instance
     *         of [https://cloud.google.com/pubsub/reference/rest/v1/projects.subscriptions#Subscription](Subscription).
     * @return Subscription
     */
    public function subscription(
        $name,
        $topicName = null,
        array $info = null
    ) {
        return new Subscription(
            $this->connection,
            $name,
            $topicName,
            $this->projectId,
            $info
        );
    }

    /**
     * Get a list of the subscriptions registered to all of your project's
     * topics.
     *
     * Example:
     * ```php
     * use Google\Cloud\PubSub\StorageClient;
     *
     * $pubsub = new PubSubClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * $subscriptions = $pubsub->subscriptions();
     * foreach ($subscriptions as $subscription) {
     *      $info = $subscription->info();
     *      echo $info['name']; // `projects/my-awesome-project/subscriptions/<subscription-name>`
     * }
     * ```
     *
     * @param  array $options {
     *     Configuration Options
     *
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     * }
     * @return \Generator
     */
    public function subscriptions(array $options = [])
    {
        $options['pageToken'] = null;

        do {
            $response = $this->connection->listSubscriptions($options + [
                'project' => $this->formatName('project', $this->projectId)
            ]);

            foreach ($response['subscriptions'] as $subscription) {
                yield $this->subscription(
                    $subscription['name'],
                    $subscription['topic'],
                    $subscription
                );
            }

            // If there's a page token, we'll request the next page.
            $options['pageToken'] = isset($response['nextPageToken'])
                ? $response['nextPageToken']
                : null;
        } while ($options['pageToken']);
    }
}
