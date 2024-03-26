<?php

return [
    'interfaces' => [
        'google.api.cloudquotas.v1.CloudQuotas' => [
            'CreateQuotaPreference' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/quotaPreferences',
                'body' => 'quota_preference',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/quotaPreferences',
                        'body' => 'quota_preference',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/quotaPreferences',
                        'body' => 'quota_preference',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetQuotaInfo' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/services/*/quotaInfos/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/services/*/quotaInfos/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/services/*/quotaInfos/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetQuotaPreference' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/quotaPreferences/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/quotaPreferences/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/quotaPreferences/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListQuotaInfos' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/services/*}/quotaInfos',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*/services/*}/quotaInfos',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*/services/*}/quotaInfos',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListQuotaPreferences' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/quotaPreferences',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/quotaPreferences',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/quotaPreferences',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateQuotaPreference' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{quota_preference.name=projects/*/locations/*/quotaPreferences/*}',
                'body' => 'quota_preference',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{quota_preference.name=folders/*/locations/*/quotaPreferences/*}',
                        'body' => 'quota_preference',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{quota_preference.name=organizations/*/locations/*/quotaPreferences/*}',
                        'body' => 'quota_preference',
                    ],
                ],
                'placeholders' => [
                    'quota_preference.name' => [
                        'getters' => [
                            'getQuotaPreference',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
