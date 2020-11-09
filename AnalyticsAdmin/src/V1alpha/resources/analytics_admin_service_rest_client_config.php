<?php

return [
    'interfaces' => [
        'google.analytics.admin.v1alpha.AnalyticsAdminService' => [
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
            'ListAccounts' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/accounts',
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
            'ProvisionAccountTicket' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/accounts:provisionAccountTicket',
                'body' => '*',
            ],
            'ListAccountSummaries' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/accountSummaries',
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
            'ListProperties' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/properties',
            ],
            'CreateProperty' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties',
                'body' => 'property',
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
            'CreateIosAppDataStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/iosAppDataStreams',
                'body' => 'ios_app_data_stream',
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
            'CreateAndroidAppDataStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/androidAppDataStreams',
                'body' => 'android_app_data_stream',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
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
        ],
    ],
];
