<?php
/*
 * Copyright 2026 Google LLC
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
        'google.ads.admanager.v1.LineItemCreativeAssociationService' => [
            'BatchActivateLineItemCreativeAssociations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*/lineItems/*}/creatives:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateLineItemCreativeAssociations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*/lineItems/*}/creatives:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateLineItemCreativeAssociations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*/lineItems/*}/creatives:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteLineItemCreativeAssociations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*/lineItems/*}/creatives:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateLineItemCreativeAssociations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*/lineItems/*}/creatives:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateLineItemCreativeAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*/lineItems/*}/creatives',
                'body' => 'line_item_creative_association',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetLineItemCreativeAssociation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/lineItems/*/creatives/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLineItemCreativeAssociations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*/lineItems/*}/creatives',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewLineItemCreativeAssociation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/lineItems/*/creatives/*}:preview',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateLineItemCreativeAssociation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{line_item_creative_association.name=networks/*/lineItems/*/creatives/*}',
                'body' => 'line_item_creative_association',
                'placeholders' => [
                    'line_item_creative_association.name' => [
                        'getters' => [
                            'getLineItemCreativeAssociation',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}:cancel',
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
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
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
