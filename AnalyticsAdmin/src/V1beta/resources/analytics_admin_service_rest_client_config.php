<?php

return [
    'interfaces' => [
        'google.analytics.admin.v1beta.AnalyticsAdminService' => [
            'AcknowledgeUserDataCollection' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{property=properties/*}:acknowledgeUserDataCollection',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'ArchiveCustomDimension' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=properties/*/customDimensions/*}:archive',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ArchiveCustomMetric' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=properties/*/customMetrics/*}:archive',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateConversionEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*}/conversionEvents',
                'body' => 'conversion_event',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCustomDimension' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*}/customDimensions',
                'body' => 'custom_dimension',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCustomMetric' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*}/customMetrics',
                'body' => 'custom_metric',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDataStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*}/dataStreams',
                'body' => 'data_stream',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateFirebaseLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*}/firebaseLinks',
                'body' => 'firebase_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateGoogleAdsLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*}/googleAdsLinks',
                'body' => 'google_ads_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateMeasurementProtocolSecret' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=properties/*/dataStreams/*}/measurementProtocolSecrets',
                'body' => 'measurement_protocol_secret',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProperty' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/properties',
                'body' => 'property',
            ],
            'DeleteAccount' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=accounts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteConversionEvent' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=properties/*/conversionEvents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDataStream' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=properties/*/dataStreams/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteFirebaseLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=properties/*/firebaseLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGoogleAdsLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=properties/*/googleAdsLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMeasurementProtocolSecret' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=properties/*/dataStreams/*/measurementProtocolSecrets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteProperty' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=properties/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAccount' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=accounts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConversionEvent' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/conversionEvents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCustomDimension' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/customDimensions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCustomMetric' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/customMetrics/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataRetentionSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/dataRetentionSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataSharingSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=accounts/*/dataSharingSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataStream' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/dataStreams/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMeasurementProtocolSecret' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*/dataStreams/*/measurementProtocolSecrets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProperty' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=properties/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAccountSummaries' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/accountSummaries',
            ],
            'ListAccounts' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/accounts',
            ],
            'ListConversionEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*}/conversionEvents',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCustomDimensions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*}/customDimensions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCustomMetrics' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*}/customMetrics',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDataStreams' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*}/dataStreams',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFirebaseLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*}/firebaseLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGoogleAdsLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*}/googleAdsLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMeasurementProtocolSecrets' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=properties/*/dataStreams/*}/measurementProtocolSecrets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProperties' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/properties',
                'queryParams' => [
                    'filter',
                ],
            ],
            'ProvisionAccountTicket' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/accounts:provisionAccountTicket',
                'body' => '*',
            ],
            'SearchChangeHistoryEvents' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{account=accounts/*}:searchChangeHistoryEvents',
                'body' => '*',
                'placeholders' => [
                    'account' => [
                        'getters' => [
                            'getAccount',
                        ],
                    ],
                ],
            ],
            'UpdateAccount' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{account.name=accounts/*}',
                'body' => 'account',
                'placeholders' => [
                    'account.name' => [
                        'getters' => [
                            'getAccount',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCustomDimension' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{custom_dimension.name=properties/*/customDimensions/*}',
                'body' => 'custom_dimension',
                'placeholders' => [
                    'custom_dimension.name' => [
                        'getters' => [
                            'getCustomDimension',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCustomMetric' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{custom_metric.name=properties/*/customMetrics/*}',
                'body' => 'custom_metric',
                'placeholders' => [
                    'custom_metric.name' => [
                        'getters' => [
                            'getCustomMetric',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDataRetentionSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{data_retention_settings.name=properties/*/dataRetentionSettings}',
                'body' => 'data_retention_settings',
                'placeholders' => [
                    'data_retention_settings.name' => [
                        'getters' => [
                            'getDataRetentionSettings',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDataStream' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{data_stream.name=properties/*/dataStreams/*}',
                'body' => 'data_stream',
                'placeholders' => [
                    'data_stream.name' => [
                        'getters' => [
                            'getDataStream',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateGoogleAdsLink' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{google_ads_link.name=properties/*/googleAdsLinks/*}',
                'body' => 'google_ads_link',
                'placeholders' => [
                    'google_ads_link.name' => [
                        'getters' => [
                            'getGoogleAdsLink',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateMeasurementProtocolSecret' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{measurement_protocol_secret.name=properties/*/dataStreams/*/measurementProtocolSecrets/*}',
                'body' => 'measurement_protocol_secret',
                'placeholders' => [
                    'measurement_protocol_secret.name' => [
                        'getters' => [
                            'getMeasurementProtocolSecret',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProperty' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{property.name=properties/*}',
                'body' => 'property',
                'placeholders' => [
                    'property.name' => [
                        'getters' => [
                            'getProperty',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
];
