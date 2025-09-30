<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

return [
    'interfaces' => [
        'google.cloud.eventarc.v1.Eventarc' => [
            'CreateChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/channels',
                'body' => 'channel',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'channel_id',
                ],
            ],
            'CreateChannelConnection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/channelConnections',
                'body' => 'channel_connection',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'channel_connection_id',
                ],
            ],
            'CreateEnrollment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/enrollments',
                'body' => 'enrollment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'enrollment_id',
                ],
            ],
            'CreateGoogleApiSource' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/googleApiSources',
                'body' => 'google_api_source',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'google_api_source_id',
                ],
            ],
            'CreateMessageBus' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/messageBuses',
                'body' => 'message_bus',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'message_bus_id',
                ],
            ],
            'CreatePipeline' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/pipelines',
                'body' => 'pipeline',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'pipeline_id',
                ],
            ],
            'CreateTrigger' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/triggers',
                'body' => 'trigger',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'trigger_id',
                ],
            ],
            'DeleteChannel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteChannelConnection' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channelConnections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEnrollment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/enrollments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGoogleApiSource' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/googleApiSources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMessageBus' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/messageBuses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePipeline' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelines/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTrigger' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/triggers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetChannel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetChannelConnection' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channelConnections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEnrollment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/enrollments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGoogleApiSource' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/googleApiSources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGoogleChannelConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/googleChannelConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMessageBus' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/messageBuses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPipeline' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelines/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProvider' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/providers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTrigger' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/triggers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListChannelConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/channelConnections',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListChannels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/channels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEnrollments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/enrollments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGoogleApiSources' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/googleApiSources',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMessageBusEnrollments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/messageBuses/*}:listEnrollments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMessageBuses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/messageBuses',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPipelines' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/pipelines',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProviders' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/providers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTriggers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/triggers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateChannel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{channel.name=projects/*/locations/*/channels/*}',
                'body' => 'channel',
                'placeholders' => [
                    'channel.name' => [
                        'getters' => [
                            'getChannel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateEnrollment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{enrollment.name=projects/*/locations/*/enrollments/*}',
                'body' => 'enrollment',
                'placeholders' => [
                    'enrollment.name' => [
                        'getters' => [
                            'getEnrollment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGoogleApiSource' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{google_api_source.name=projects/*/locations/*/googleApiSources/*}',
                'body' => 'google_api_source',
                'placeholders' => [
                    'google_api_source.name' => [
                        'getters' => [
                            'getGoogleApiSource',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGoogleChannelConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{google_channel_config.name=projects/*/locations/*/googleChannelConfig}',
                'body' => 'google_channel_config',
                'placeholders' => [
                    'google_channel_config.name' => [
                        'getters' => [
                            'getGoogleChannelConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMessageBus' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{message_bus.name=projects/*/locations/*/messageBuses/*}',
                'body' => 'message_bus',
                'placeholders' => [
                    'message_bus.name' => [
                        'getters' => [
                            'getMessageBus',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePipeline' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{pipeline.name=projects/*/locations/*/pipelines/*}',
                'body' => 'pipeline',
                'placeholders' => [
                    'pipeline.name' => [
                        'getters' => [
                            'getPipeline',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTrigger' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{trigger.name=projects/*/locations/*/triggers/*}',
                'body' => 'trigger',
                'placeholders' => [
                    'trigger.name' => [
                        'getters' => [
                            'getTrigger',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/triggers/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/channels/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/channelConnections/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/messageBuses/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/enrollments/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/pipelines/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/kafkaSources/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/googleApiSources/*}:getIamPolicy',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/triggers/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/channels/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/channelConnections/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/messageBuses/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/enrollments/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/pipelines/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/kafkaSources/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/googleApiSources/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/triggers/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/channels/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/channelConnections/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/messageBuses/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/enrollments/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/pipelines/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/kafkaSources/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/googleApiSources/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
