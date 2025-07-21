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
        'google.chat.v1.ChatService' => [
            'CompleteImportSpace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=spaces/*}:completeImport',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateCustomEmoji' => [
                'method' => 'post',
                'uriTemplate' => '/v1/customEmojis',
                'body' => 'custom_emoji',
            ],
            'CreateMembership' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=spaces/*}/members',
                'body' => 'membership',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateMessage' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=spaces/*}/messages',
                'body' => 'message',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateReaction' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=spaces/*/messages/*}/reactions',
                'body' => 'reaction',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSpace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/spaces',
                'body' => 'space',
            ],
            'DeleteCustomEmoji' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=customEmojis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMembership' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=spaces/*/members/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMessage' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=spaces/*/messages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteReaction' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=spaces/*/messages/*/reactions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSpace' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=spaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FindDirectMessage' => [
                'method' => 'get',
                'uriTemplate' => '/v1/spaces:findDirectMessage',
            ],
            'GetAttachment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=spaces/*/messages/*/attachments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCustomEmoji' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=customEmojis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMembership' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=spaces/*/members/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMessage' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=spaces/*/messages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpace' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=spaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpaceEvent' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=spaces/*/spaceEvents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpaceNotificationSetting' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*/spaces/*/spaceNotificationSetting}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpaceReadState' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*/spaces/*/spaceReadState}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetThreadReadState' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*/spaces/*/threads/*/threadReadState}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCustomEmojis' => [
                'method' => 'get',
                'uriTemplate' => '/v1/customEmojis',
            ],
            'ListMemberships' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=spaces/*}/members',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMessages' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=spaces/*}/messages',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReactions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=spaces/*/messages/*}/reactions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSpaceEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=spaces/*}/spaceEvents',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'filter',
                ],
            ],
            'ListSpaces' => [
                'method' => 'get',
                'uriTemplate' => '/v1/spaces',
            ],
            'SearchSpaces' => [
                'method' => 'get',
                'uriTemplate' => '/v1/spaces:search',
            ],
            'SetUpSpace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/spaces:setup',
                'body' => '*',
            ],
            'UpdateMembership' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{membership.name=spaces/*/members/*}',
                'body' => 'membership',
                'placeholders' => [
                    'membership.name' => [
                        'getters' => [
                            'getMembership',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateMessage' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{message.name=spaces/*/messages/*}',
                'body' => 'message',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{message.name=spaces/*/messages/*}',
                        'body' => 'message',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                ],
                'placeholders' => [
                    'message.name' => [
                        'getters' => [
                            'getMessage',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSpace' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{space.name=spaces/*}',
                'body' => 'space',
                'placeholders' => [
                    'space.name' => [
                        'getters' => [
                            'getSpace',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSpaceNotificationSetting' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{space_notification_setting.name=users/*/spaces/*/spaceNotificationSetting}',
                'body' => 'space_notification_setting',
                'placeholders' => [
                    'space_notification_setting.name' => [
                        'getters' => [
                            'getSpaceNotificationSetting',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSpaceReadState' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{space_read_state.name=users/*/spaces/*/spaceReadState}',
                'body' => 'space_read_state',
                'placeholders' => [
                    'space_read_state.name' => [
                        'getters' => [
                            'getSpaceReadState',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UploadAttachment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=spaces/*}/attachments:upload',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
