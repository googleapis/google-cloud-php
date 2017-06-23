<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Unit\PubSub\Connection;

use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\PubSub\Connection\Grpc;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\GAX\Serializer;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp;
use Prophecy\Argument;
use Google\Iam\V1\Binding;
use Google\Iam\V1\Policy;
use Google\Pubsub\V1\PubsubMessage;
use Google\Pubsub\V1\PushConfig;
use Google\Pubsub\V1\Subscription;

/**
 * @group pubsub
 */
class GrpcTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    private $requestWrapper;
    private $successMessage;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
    }

    /**
     * @dataProvider methodProvider
     */
    public function testCallBasicMethods($method, $args, $expectedArgs)
    {
        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($this->successMessage);

        $grpc = new Grpc();
        $grpc->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($this->successMessage, $grpc->$method($args));
    }

    public function methodProvider()
    {
        if ($this->shouldSkipGrpcTests()) {
            return [];
        }

        $value = 'value';
        $pageSizeSetting = ['pageSize' => 3];
        $messageData = '123';
        $attributeKey = 'testing';
        $attributeValue = '123';
        $attributes = ['testing' => 123];
        $pbMessage = new PubsubMessage();
        $pbMessage->setData('123');
        $pbMessage->setAttributes($attributes);
        $bindingRole = 'test_role';
        $bindingMember = 'test_member';
        $bindingMembers = [$bindingMember];
        $pbBinding = new Binding();
        $pbBinding->setRole($bindingRole);
        $pbBinding->setMembers($bindingMembers);
        $pbBindings = [$pbBinding];
        $pbPolicy = new Policy();
        $pbPolicy->setBindings($pbBindings);
        $permissions = ['fake' => 'permissions'];
        $pbPushConfig = new PushConfig();
        $pushEndpoint = 'http://www.example.com';
        $pbPushConfig->setPushEndpoint($pushEndpoint);
        $pbPushAttributes = ['testing' => 123];
        $pbPushConfig->setAttributes($pbPushAttributes);
        $ackIds = ['1', '2', '3'];
        $maxMessages = 100;
        $ackDeadlineSeconds = 1;

        $snapshotName = 'projects/foo/snapshots/bar';
        $subscriptionName = 'projects/foo/subscriptions/bar';
        $subscription = new Subscription;
        $subscription->setName($subscriptionName);
        $subscription->setRetainAckedMessages(true);

        $serializer = new Serializer();
        $fieldMask = $serializer->decodeMessage(new FieldMask(), ['paths' => ['retainAckedMessages']]);

        $time = (new \DateTime)->format('Y-m-d\TH:i:s.u\Z');
        $timestamp = $serializer->decodeMessage(new Timestamp(), $this->formatTimestampForApi($time));

        return [
            [
                'updateSubscription',
                ['name' => 'projects/foo/subscriptions/bar', 'retainAckedMessages' => true],
                [$subscription, $fieldMask, []]
            ],
            [
                'listSnapshots',
                ['project' => 'projectId'],
                ['projectId', []]
            ],
            [
                'createSnapshot',
                ['name' => $snapshotName, 'subscription' => $subscriptionName],
                [$snapshotName, $subscriptionName, []]
            ],
            [
                'deleteSnapshot',
                ['snapshot' => $snapshotName],
                [$snapshotName, []]
            ],
            [
                'seek',
                ['subscription' => $subscriptionName, 'time' => $time],
                [$subscriptionName, ['time' => $timestamp]]
            ],
            [
                'createTopic',
                ['name' => $value],
                [$value, []]
            ],
            [
                'getTopic',
                ['topic' => $value],
                [$value, []]
            ],
            [
                'deleteTopic',
                ['topic' => $value],
                [$value, []]
            ],
            [
                'listTopics',
                ['project' => $value],
                [$value, []]
            ],
            [
                'publishMessage',
                [
                    'topic' => $value,
                    'messages' => [
                        [
                            'data' => $messageData,
                            'attributes' => [$attributeKey => $attributeValue]
                        ]
                    ]
                ],
                [$value, [$pbMessage], []]
            ],
            [
                'listSubscriptionsByTopic',
                ['topic' => $value] + $pageSizeSetting,
                [$value, $pageSizeSetting]
            ],
            [
                'getTopicIamPolicy',
                ['resource' => $value],
                [$value, []]
            ],
            [
                'setTopicIamPolicy',
                [
                    'resource' => $value,
                    'policy' => [
                        'bindings' => [
                            [
                                'role' => $bindingRole,
                                'members' => [$bindingMember]
                            ]
                        ]
                    ]
                ],
                [$value, $pbPolicy, []]
            ],
            [
                'testTopicIamPermissions',
                ['resource' => $value, 'permissions' => $permissions],
                [$value, $permissions, []]
            ],
            [
                'createSubscription',
                [
                    'name' => $value,
                    'topic' => strtoupper($value),
                    'pushConfig' => [
                        'pushEndpoint' => $pushEndpoint,
                        'attributes' => [$attributeKey => $attributeValue]
                    ]
                ],
                [$value, strtoupper($value), ['pushConfig' => $pbPushConfig]]
            ],
            [
                'getSubscription',
                ['subscription' => $value],
                [$value, []]
            ],
            [
                'listSubscriptions',
                ['project' => $value] + $pageSizeSetting,
                [$value, $pageSizeSetting]
            ],
            [
                'deleteSubscription',
                ['subscription' => $value],
                [$value, []]
            ],
            [
                'modifyPushConfig',
                [
                    'subscription' => $value,
                    'pushConfig' => [
                        'pushEndpoint' => $pushEndpoint,
                        'attributes' => [$attributeKey => $attributeValue]
                    ]
                ],
                [$value, $pbPushConfig, []]
            ],
            [
                'pull',
                ['subscription' => $value, 'maxMessages' => $maxMessages] + $pageSizeSetting,
                [$value, $maxMessages, $pageSizeSetting]
            ],
            [
                'modifyAckDeadline',
                ['subscription' => $value, 'ackIds' => $ackIds, 'ackDeadlineSeconds' => $ackDeadlineSeconds],
                [$value, $ackIds, $ackDeadlineSeconds, []]
            ],
            [
                'acknowledge',
                ['subscription' => $value, 'ackIds' => $ackIds],
                [$value, $ackIds, []]
            ],
            [
                'getSubscriptionIamPolicy',
                ['resource' => $value],
                [$value, []]
            ],
            [
                'setSubscriptionIamPolicy',
                [
                    'resource' => $value,
                    'policy' => [
                        'bindings' => [
                            [
                                'role' => $bindingRole,
                                'members' => [$bindingMember]
                            ]
                        ]
                    ]
                ],
                [$value, $pbPolicy, []]
            ],
            [
                'testSubscriptionIamPermissions',
                ['resource' => $value, 'permissions' => $permissions],
                [$value, $permissions, []]
            ]
        ];
    }
}
