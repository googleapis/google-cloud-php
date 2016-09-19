# Google Cloud Pub/Sub

Google Cloud Pub/Sub allows you to send and receive messages between independent
applications.

## More Information

* [Google Cloud Pub/Sub docs](https://cloud.google.com/pubsub/docs/).

## Client Libraries

* [**PubSubClient**](https://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/pubsub/pubsubclient)
* [Subscription](https://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/pubsub/subscription)
* [Topic](https://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/pubsub/topic)

## Generated Client

[What are Generated Clients?](https://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/guides/generated-client)

### V1

* [PublisherApi](https://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/pubsub/v1/publisherapi)
* [SubscriberApi](https://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/pubsub/v1/subscriberapi)

## Using Pub/Sub

### Concepts

Pub/Sub is a way of sharing messages between independent applications. A
"Publisher" will push messages into a topic, while a "Subscriber" will retrieve
messages from a subscription.

Subscriptions are a named resource representing the stream of messages from a
single topic. Generally, each subscribing application would create a single
subscription to each topic which is applicable to that application.

Messages are a combination of data and optional attributes which a publisher
sends to a topic to be delivered to each subscriber.

Subscribers may elect to receive messages by pulling (i.e. sending a request,
to which the response contains all new messages), or by push (by supplying an
application endpoint which can consume incoming messages on demand).

### Examples

#### Obtaining an instance of `PubSubClient`

```php
<?php

use Google\Cloud\ServiceBuilder;

$cloud = new ServiceBuilder();

$pubsub = $cloud->pubsub();
```

#### Creating a new Topic

```php
$pubsub->createTopic('my-new-topic');
```

#### Publish a message

`PubSubClient::createTopic()` should be called *once* to create the named topic
in the service. To obtain a reference to an *existing* topic, use
`PubSubClient::topic()`.

```php
$topic = $pubsub->topic('my-new-topic');
$topic->publish([
    'data' => 'Hello world!',
    'attributes' => [
        'key' => 'val'
    ]
);
```

#### Subscribe to a topic

```php
$subscription = $pubsub->subscribe('my-new-subscription');
```

#### Retrieve messages

`PubSubClient::subscribe()` should be called *once* to create the named
subscription in the service. To obtain a reference to an *existing*
subscription, use `PubSubClient::subscription()`.

```php
$subscription = $pubsub->subscription('my-new-subscription');
$messages = $subscription->pull();

foreach ($messages as $message) {
    echo $message['message']['data'];
}
```

#### Acknowledge received message

Received messages should be *acknowledged* upon receipt, to prevent them from
being delivered multiple times.

```php
$subscription = $pubsub->subscription('my-new-subscription');
$messages = $subscription->pull();

$ackIds = [];
foreach ($messages as $message) {
    $ackIds[] = $message['ackId'];
}

$subscription->acknowledgeBatch($ackIds);
```

#### Configure Push Delivery

When Push Delivery is enabled, new messages will be delivered via HTTP to the
given endpoint.

For more information, refer to the [receive push](https://cloud.google.com/pubsub/docs/subscriber#receive_push)
guide.

To pause push delivery for a subscription, call
`Subscription::modifyPushConfig()`, supplying an empty string (`''`) as the
`pushEndpoint`.

```php
$subscription = $pubsub->subscription('my-new-subscription');
$subscription->modifyPushConfig([
    'pushEndpoint' => 'https://mysite.com/application/pubsub/push'
]);
```
