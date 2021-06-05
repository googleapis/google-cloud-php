<?php

return [
    'interfaces' => [
        'google.analytics.admin.v1alpha.AnalyticsAdminService' => [
            'ArchiveCustomDimension' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/customDimensions/*}:archive',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/customMetrics/*}:archive',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'AuditUserLinks' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/userLinks:audit',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/userLinks:audit',
                        'body' => '*',
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
            'BatchCreateUserLinks' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/userLinks:batchCreate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/userLinks:batchCreate',
                        'body' => '*',
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
            'BatchDeleteUserLinks' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/userLinks:batchDelete',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/userLinks:batchDelete',
                        'body' => '*',
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
            'BatchGetUserLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/userLinks:batchGet',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/userLinks:batchGet',
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
            'BatchUpdateUserLinks' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/userLinks:batchUpdate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/userLinks:batchUpdate',
                        'body' => '*',
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
            'CreateConversionEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/conversionEvents',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*}/customDimensions',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*}/customMetrics',
                'body' => 'custom_metric',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*}/firebaseLinks',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*}/googleAdsLinks',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*/webDataStreams/*}/measurementProtocolSecrets',
                'body' => 'measurement_protocol_secret',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*/iosAppDataStreams/*}/measurementProtocolSecrets',
                        'body' => 'measurement_protocol_secret',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*/androidAppDataStreams/*}/measurementProtocolSecrets',
                        'body' => 'measurement_protocol_secret',
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
            'CreateProperty' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties',
                'body' => 'property',
            ],
            'CreateUserLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/userLinks',
                'body' => 'user_link',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/userLinks',
                        'body' => 'user_link',
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
            'CreateWebDataStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/webDataStreams',
                'body' => 'web_data_stream',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAccount' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=accounts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAndroidAppDataStream' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/androidAppDataStreams/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/conversionEvents/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/firebaseLinks/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/googleAdsLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteIosAppDataStream' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/iosAppDataStreams/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/webDataStreams/*/measurementProtocolSecrets/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1alpha/{name=properties/*/iosAppDataStreams/*/measurementProtocolSecrets/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1alpha/{name=properties/*/androidAppDataStreams/*/measurementProtocolSecrets/*}',
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
            'DeleteProperty' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUserLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=accounts/*/userLinks/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1alpha/{name=properties/*/userLinks/*}',
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
            'DeleteWebDataStream' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/webDataStreams/*}',
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
                'uriTemplate' => '/v1alpha/{name=accounts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAndroidAppDataStream' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/androidAppDataStreams/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/conversionEvents/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/customDimensions/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/customMetrics/*}',
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
                'uriTemplate' => '/v1alpha/{name=accounts/*/dataSharingSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEnhancedMeasurementSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/webDataStreams/*/enhancedMeasurementSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGlobalSiteTag' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/webDataStreams/*/globalSiteTag}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGoogleSignalsSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/googleSignalsSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIosAppDataStream' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/iosAppDataStreams/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/webDataStreams/*/measurementProtocolSecrets/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{name=properties/*/iosAppDataStreams/*/measurementProtocolSecrets/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{name=properties/*/androidAppDataStreams/*/measurementProtocolSecrets/*}',
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
            'GetProperty' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUserLink' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=accounts/*/userLinks/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{name=properties/*/userLinks/*}',
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
            'GetWebDataStream' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/webDataStreams/*}',
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
                'uriTemplate' => '/v1alpha/accountSummaries',
            ],
            'ListAccounts' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/accounts',
            ],
            'ListAndroidAppDataStreams' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/androidAppDataStreams',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListConversionEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/conversionEvents',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*}/customDimensions',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*}/customMetrics',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*}/firebaseLinks',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*}/googleAdsLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIosAppDataStreams' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/iosAppDataStreams',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*/webDataStreams/*}/measurementProtocolSecrets',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{parent=properties/*/iosAppDataStreams/*}/measurementProtocolSecrets',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{parent=properties/*/androidAppDataStreams/*}/measurementProtocolSecrets',
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
            'ListProperties' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/properties',
            ],
            'ListUserLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/userLinks',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/userLinks',
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
            'ListWebDataStreams' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/webDataStreams',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ProvisionAccountTicket' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/accounts:provisionAccountTicket',
                'body' => '*',
            ],
            'SearchChangeHistoryEvents' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{account=accounts/*}:searchChangeHistoryEvents',
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
                'uriTemplate' => '/v1alpha/{account.name=accounts/*}',
                'body' => 'account',
                'placeholders' => [
                    'account.name' => [
                        'getters' => [
                            'getAccount',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAndroidAppDataStream' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{android_app_data_stream.name=properties/*/androidAppDataStreams/*}',
                'body' => 'android_app_data_stream',
                'placeholders' => [
                    'android_app_data_stream.name' => [
                        'getters' => [
                            'getAndroidAppDataStream',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCustomDimension' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{custom_dimension.name=properties/*/customDimensions/*}',
                'body' => 'custom_dimension',
                'placeholders' => [
                    'custom_dimension.name' => [
                        'getters' => [
                            'getCustomDimension',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCustomMetric' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{custom_metric.name=properties/*/customMetrics/*}',
                'body' => 'custom_metric',
                'placeholders' => [
                    'custom_metric.name' => [
                        'getters' => [
                            'getCustomMetric',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateEnhancedMeasurementSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{enhanced_measurement_settings.name=properties/*/webDataStreams/*/enhancedMeasurementSettings}',
                'body' => 'enhanced_measurement_settings',
                'placeholders' => [
                    'enhanced_measurement_settings.name' => [
                        'getters' => [
                            'getEnhancedMeasurementSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateFirebaseLink' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{firebase_link.name=properties/*/firebaseLinks/*}',
                'body' => 'firebase_link',
                'placeholders' => [
                    'firebase_link.name' => [
                        'getters' => [
                            'getFirebaseLink',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGoogleAdsLink' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{google_ads_link.name=properties/*/googleAdsLinks/*}',
                'body' => 'google_ads_link',
                'placeholders' => [
                    'google_ads_link.name' => [
                        'getters' => [
                            'getGoogleAdsLink',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGoogleSignalsSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{google_signals_settings.name=properties/*/googleSignalsSettings}',
                'body' => 'google_signals_settings',
                'placeholders' => [
                    'google_signals_settings.name' => [
                        'getters' => [
                            'getGoogleSignalsSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateIosAppDataStream' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{ios_app_data_stream.name=properties/*/iosAppDataStreams/*}',
                'body' => 'ios_app_data_stream',
                'placeholders' => [
                    'ios_app_data_stream.name' => [
                        'getters' => [
                            'getIosAppDataStream',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMeasurementProtocolSecret' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{measurement_protocol_secret.name=properties/*/webDataStreams/*/measurementProtocolSecrets/*}',
                'body' => 'measurement_protocol_secret',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1alpha/{measurement_protocol_secret.name=properties/*/iosAppDataStreams/*/measurementProtocolSecrets/*}',
                        'body' => 'measurement_protocol_secret',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1alpha/{measurement_protocol_secret.name=properties/*/androidAppDataStreams/*/measurementProtocolSecrets/*}',
                        'body' => 'measurement_protocol_secret',
                    ],
                ],
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
                'uriTemplate' => '/v1alpha/{property.name=properties/*}',
                'body' => 'property',
                'placeholders' => [
                    'property.name' => [
                        'getters' => [
                            'getProperty',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateUserLink' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{user_link.name=accounts/*/userLinks/*}',
                'body' => 'user_link',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1alpha/{user_link.name=properties/*/userLinks/*}',
                        'body' => 'user_link',
                    ],
                ],
                'placeholders' => [
                    'user_link.name' => [
                        'getters' => [
                            'getUserLink',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateWebDataStream' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{web_data_stream.name=properties/*/webDataStreams/*}',
                'body' => 'web_data_stream',
                'placeholders' => [
                    'web_data_stream.name' => [
                        'getters' => [
                            'getWebDataStream',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
