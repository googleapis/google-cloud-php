<?php

return [
    'interfaces' => [
        'google.analytics.admin.v1alpha.AnalyticsAdminService' => [
            'AcknowledgeUserDataCollection' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{property=properties/*}:acknowledgeUserDataCollection',
                'body' => '*',
                'placeholders' => [
                    'property' => [
                        'getters' => [
                            'getProperty',
                        ],
                    ],
                ],
            ],
            'ApproveDisplayVideo360AdvertiserLinkProposal' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/displayVideo360AdvertiserLinkProposals/*}:approve',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ArchiveAudience' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/audiences/*}:archive',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
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
            'CancelDisplayVideo360AdvertiserLinkProposal' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*/displayVideo360AdvertiserLinkProposals/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateAudience' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/audiences',
                'body' => 'audience',
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
            'CreateDataStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/dataStreams',
                'body' => 'data_stream',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDisplayVideo360AdvertiserLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/displayVideo360AdvertiserLinks',
                'body' => 'display_video_360_advertiser_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDisplayVideo360AdvertiserLinkProposal' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/displayVideo360AdvertiserLinkProposals',
                'body' => 'display_video_360_advertiser_link_proposal',
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
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/measurementProtocolSecrets',
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
            'DeleteDataStream' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDisplayVideo360AdvertiserLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/displayVideo360AdvertiserLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDisplayVideo360AdvertiserLinkProposal' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/displayVideo360AdvertiserLinkProposals/*}',
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
            'DeleteMeasurementProtocolSecret' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/measurementProtocolSecrets/*}',
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
            'GetAttributionSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/attributionSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAudience' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/audiences/*}',
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
            'GetDataRetentionSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataRetentionSettings}',
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
            'GetDataStream' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDisplayVideo360AdvertiserLink' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/displayVideo360AdvertiserLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDisplayVideo360AdvertiserLinkProposal' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/displayVideo360AdvertiserLinkProposals/*}',
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
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/globalSiteTag}',
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
            'GetMeasurementProtocolSecret' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/measurementProtocolSecrets/*}',
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
            'ListAccountSummaries' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/accountSummaries',
            ],
            'ListAccounts' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/accounts',
            ],
            'ListAudiences' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/audiences',
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
            'ListDataStreams' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/dataStreams',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDisplayVideo360AdvertiserLinkProposals' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/displayVideo360AdvertiserLinkProposals',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDisplayVideo360AdvertiserLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/displayVideo360AdvertiserLinks',
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
            'ListMeasurementProtocolSecrets' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/measurementProtocolSecrets',
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
                'queryParams' => [
                    'filter',
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
            'ProvisionAccountTicket' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/accounts:provisionAccountTicket',
                'body' => '*',
            ],
            'RunAccessReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{entity=properties/*}:runAccessReport',
                'body' => '*',
                'placeholders' => [
                    'entity' => [
                        'getters' => [
                            'getEntity',
                        ],
                    ],
                ],
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
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateAttributionSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{attribution_settings.name=properties/*/attributionSettings}',
                'body' => 'attribution_settings',
                'placeholders' => [
                    'attribution_settings.name' => [
                        'getters' => [
                            'getAttributionSettings',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateAudience' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{audience.name=properties/*/audiences/*}',
                'body' => 'audience',
                'placeholders' => [
                    'audience.name' => [
                        'getters' => [
                            'getAudience',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDataRetentionSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{data_retention_settings.name=properties/*/dataRetentionSettings}',
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
                'uriTemplate' => '/v1alpha/{data_stream.name=properties/*/dataStreams/*}',
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
            'UpdateDisplayVideo360AdvertiserLink' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{display_video_360_advertiser_link.name=properties/*/displayVideo360AdvertiserLinks/*}',
                'body' => 'display_video_360_advertiser_link',
                'placeholders' => [
                    'display_video_360_advertiser_link.name' => [
                        'getters' => [
                            'getDisplayVideo360AdvertiserLink',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateMeasurementProtocolSecret' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{measurement_protocol_secret.name=properties/*/dataStreams/*/measurementProtocolSecrets/*}',
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
                'queryParams' => [
                    'update_mask',
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
        ],
    ],
];
