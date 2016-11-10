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

namespace Google\Cloud\Tests\PubSub\Connection;

use Google\Cloud\PubSub\Connection\Grpc;
use Google\Cloud\GrpcRequestWrapper;
use Prophecy\Argument;
use google\iam\v1\Binding;
use google\iam\v1\Policy;
use google\pubsub\v1\PubsubMessage;
use google\pubsub\v1\PubsubMessage\AttributesEntry as MessageAttributesEntry;
use google\pubsub\v1\PushConfig\AttributesEntry as PushConfigAttributesEntry;
use google\pubsub\v1\PushConfig;

/**
 * @group pubsub
 */
class GrpcTest extends \PHPUnit_Framework_TestCase
{
    private $requestWrapper;
    private $successMessage;

    public function setUp()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }

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
        $value = 'value';
        $pageSizeSetting = ['pageSize' => 3];
        $messageData = '123';
        $attributeKey = 'testing';
        $attributeValue = '123';
        $pbMessage = new PubsubMessage();
        $pbMessage->setData('123');
        $pbMessageAttribute = new MessageAttributesEntry();
        $pbMessageAttribute->setKey($attributeKey);
        $pbMessageAttribute->setValue($attributeValue);
        $pbMessage->addAttributes($pbMessageAttribute);
        $bindingRole = 'test_role';
        $bindingMember = 'test_member';
        $pbPolicy = new Policy();
        $pbBinding = new Binding();
        $pbBinding->setRole($bindingRole);
        $pbBinding->addMembers($bindingMember);
        $pbPolicy->addBindings($pbBinding);
        $permissions = ['fake' => 'permissions'];
        $pbPushConfig = new PushConfig();
        $pushEndpoint = 'http://www.example.com';
        $pbPushConfig->setPushEndpoint($pushEndpoint);
        $pbPushAttribute = new PushConfigAttributesEntry();
        $pbPushAttribute->setKey($attributeKey);
        $pbPushAttribute->setValue($attributeValue);
        $pbPushConfig->addAttributes($pbPushAttribute);
        $ackIds = ['1', '2', '3'];
        $maxMessages = 100;
        $ackDeadlineSeconds = 1;

        return [
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
