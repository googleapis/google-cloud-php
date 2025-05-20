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
            'BatchCreateAccessBindings' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/accessBindings:batchCreate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/accessBindings:batchCreate',
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
            'BatchDeleteAccessBindings' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/accessBindings:batchDelete',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/accessBindings:batchDelete',
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
            'BatchGetAccessBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/accessBindings:batchGet',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/accessBindings:batchGet',
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
            'BatchUpdateAccessBindings' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/accessBindings:batchUpdate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/accessBindings:batchUpdate',
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
            'CreateAccessBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/accessBindings',
                'body' => 'access_binding',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/accessBindings',
                        'body' => 'access_binding',
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
            'CreateAdSenseLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/adSenseLinks',
                'body' => 'adsense_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
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
            'CreateBigQueryLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/bigQueryLinks',
                'body' => 'bigquery_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCalculatedMetric' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/calculatedMetrics',
                'body' => 'calculated_metric',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'calculated_metric_id',
                ],
            ],
            'CreateChannelGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/channelGroups',
                'body' => 'channel_group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateConnectedSiteTag' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties:createConnectedSiteTag',
                'body' => '*',
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
            'CreateEventCreateRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/eventCreateRules',
                'body' => 'event_create_rule',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateEventEditRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/eventEditRules',
                'body' => 'event_edit_rule',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateExpandedDataSet' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/expandedDataSets',
                'body' => 'expanded_data_set',
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
            'CreateKeyEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/keyEvents',
                'body' => 'key_event',
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
            'CreateReportingDataAnnotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/reportingDataAnnotations',
                'body' => 'reporting_data_annotation',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRollupProperty' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties:createRollupProperty',
                'body' => '*',
            ],
            'CreateRollupPropertySourceLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/rollupPropertySourceLinks',
                'body' => 'rollup_property_source_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSKAdNetworkConversionValueSchema' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/sKAdNetworkConversionValueSchema',
                'body' => 'skadnetwork_conversion_value_schema',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSearchAds360Link' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/searchAds360Links',
                'body' => 'search_ads_360_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSubpropertyEventFilter' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/subpropertyEventFilters',
                'body' => 'subproperty_event_filter',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAccessBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=accounts/*/accessBindings/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1alpha/{name=properties/*/accessBindings/*}',
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
            'DeleteAdSenseLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/adSenseLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteBigQueryLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/bigQueryLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCalculatedMetric' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/calculatedMetrics/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteChannelGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/channelGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteConnectedSiteTag' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties:deleteConnectedSiteTag',
                'body' => '*',
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
            'DeleteEventCreateRule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/eventCreateRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEventEditRule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/eventEditRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExpandedDataSet' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/expandedDataSets/*}',
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
            'DeleteKeyEvent' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/keyEvents/*}',
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
            'DeleteReportingDataAnnotation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/reportingDataAnnotations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRollupPropertySourceLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/rollupPropertySourceLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSKAdNetworkConversionValueSchema' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/sKAdNetworkConversionValueSchema/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSearchAds360Link' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/searchAds360Links/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSubpropertyEventFilter' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=properties/*/subpropertyEventFilters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchAutomatedGa4ConfigurationOptOut' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties:fetchAutomatedGa4ConfigurationOptOut',
                'body' => '*',
            ],
            'FetchConnectedGa4Property' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/properties:fetchConnectedGa4Property',
            ],
            'GetAccessBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=accounts/*/accessBindings/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{name=properties/*/accessBindings/*}',
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
            'GetAdSenseLink' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/adSenseLinks/*}',
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
            'GetBigQueryLink' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/bigQueryLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCalculatedMetric' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/calculatedMetrics/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetChannelGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/channelGroups/*}',
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
            'GetDataRedactionSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/dataRedactionSettings}',
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
            'GetEnhancedMeasurementSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/enhancedMeasurementSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEventCreateRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/eventCreateRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEventEditRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/eventEditRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExpandedDataSet' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/expandedDataSets/*}',
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
            'GetKeyEvent' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/keyEvents/*}',
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
            'GetReportingDataAnnotation' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/reportingDataAnnotations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRollupPropertySourceLink' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/rollupPropertySourceLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSKAdNetworkConversionValueSchema' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/dataStreams/*/sKAdNetworkConversionValueSchema/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSearchAds360Link' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/searchAds360Links/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSubpropertyEventFilter' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=properties/*/subpropertyEventFilters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAccessBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=accounts/*}/accessBindings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha/{parent=properties/*}/accessBindings',
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
            'ListAccountSummaries' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/accountSummaries',
            ],
            'ListAccounts' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/accounts',
            ],
            'ListAdSenseLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/adSenseLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
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
            'ListBigQueryLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/bigQueryLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCalculatedMetrics' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/calculatedMetrics',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListChannelGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/channelGroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListConnectedSiteTags' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties:listConnectedSiteTags',
                'body' => '*',
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
            'ListEventCreateRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/eventCreateRules',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEventEditRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/eventEditRules',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExpandedDataSets' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/expandedDataSets',
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
            'ListKeyEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/keyEvents',
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
            'ListReportingDataAnnotations' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/reportingDataAnnotations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRollupPropertySourceLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/rollupPropertySourceLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSKAdNetworkConversionValueSchemas' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/sKAdNetworkConversionValueSchema',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSearchAds360Links' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/searchAds360Links',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSubpropertyEventFilters' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=properties/*}/subpropertyEventFilters',
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
            'ProvisionSubproperty' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties:provisionSubproperty',
                'body' => '*',
            ],
            'ReorderEventEditRules' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=properties/*/dataStreams/*}/eventEditRules:reorder',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RunAccessReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{entity=properties/*}:runAccessReport',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1alpha/{entity=accounts/*}:runAccessReport',
                        'body' => '*',
                    ],
                ],
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
            'SetAutomatedGa4ConfigurationOptOut' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/properties:setAutomatedGa4ConfigurationOptOut',
                'body' => '*',
            ],
            'SubmitUserDeletion' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{name=properties/*}:submitUserDeletion',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAccessBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{access_binding.name=accounts/*/accessBindings/*}',
                'body' => 'access_binding',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1alpha/{access_binding.name=properties/*/accessBindings/*}',
                        'body' => 'access_binding',
                    ],
                ],
                'placeholders' => [
                    'access_binding.name' => [
                        'getters' => [
                            'getAccessBinding',
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
            'UpdateBigQueryLink' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{bigquery_link.name=properties/*/bigQueryLinks/*}',
                'body' => 'bigquery_link',
                'placeholders' => [
                    'bigquery_link.name' => [
                        'getters' => [
                            'getBigqueryLink',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCalculatedMetric' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{calculated_metric.name=properties/*/calculatedMetrics/*}',
                'body' => 'calculated_metric',
                'placeholders' => [
                    'calculated_metric.name' => [
                        'getters' => [
                            'getCalculatedMetric',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateChannelGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{channel_group.name=properties/*/channelGroups/*}',
                'body' => 'channel_group',
                'placeholders' => [
                    'channel_group.name' => [
                        'getters' => [
                            'getChannelGroup',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateConversionEvent' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{conversion_event.name=properties/*/conversionEvents/*}',
                'body' => 'conversion_event',
                'placeholders' => [
                    'conversion_event.name' => [
                        'getters' => [
                            'getConversionEvent',
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
            'UpdateDataRedactionSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{data_redaction_settings.name=properties/*/dataStreams/*/dataRedactionSettings}',
                'body' => 'data_redaction_settings',
                'placeholders' => [
                    'data_redaction_settings.name' => [
                        'getters' => [
                            'getDataRedactionSettings',
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
            'UpdateEnhancedMeasurementSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{enhanced_measurement_settings.name=properties/*/dataStreams/*/enhancedMeasurementSettings}',
                'body' => 'enhanced_measurement_settings',
                'placeholders' => [
                    'enhanced_measurement_settings.name' => [
                        'getters' => [
                            'getEnhancedMeasurementSettings',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateEventCreateRule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{event_create_rule.name=properties/*/dataStreams/*/eventCreateRules/*}',
                'body' => 'event_create_rule',
                'placeholders' => [
                    'event_create_rule.name' => [
                        'getters' => [
                            'getEventCreateRule',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateEventEditRule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{event_edit_rule.name=properties/*/dataStreams/*/eventEditRules/*}',
                'body' => 'event_edit_rule',
                'placeholders' => [
                    'event_edit_rule.name' => [
                        'getters' => [
                            'getEventEditRule',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateExpandedDataSet' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{expanded_data_set.name=properties/*/expandedDataSets/*}',
                'body' => 'expanded_data_set',
                'placeholders' => [
                    'expanded_data_set.name' => [
                        'getters' => [
                            'getExpandedDataSet',
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
            'UpdateKeyEvent' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{key_event.name=properties/*/keyEvents/*}',
                'body' => 'key_event',
                'placeholders' => [
                    'key_event.name' => [
                        'getters' => [
                            'getKeyEvent',
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
                'queryParams' => [
                    'update_mask',
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
            'UpdateReportingDataAnnotation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{reporting_data_annotation.name=properties/*/reportingDataAnnotations/*}',
                'body' => 'reporting_data_annotation',
                'placeholders' => [
                    'reporting_data_annotation.name' => [
                        'getters' => [
                            'getReportingDataAnnotation',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSKAdNetworkConversionValueSchema' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{skadnetwork_conversion_value_schema.name=properties/*/dataStreams/*/sKAdNetworkConversionValueSchema/*}',
                'body' => 'skadnetwork_conversion_value_schema',
                'placeholders' => [
                    'skadnetwork_conversion_value_schema.name' => [
                        'getters' => [
                            'getSkadnetworkConversionValueSchema',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSearchAds360Link' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{search_ads_360_link.name=properties/*/searchAds360Links/*}',
                'body' => 'search_ads_360_link',
                'placeholders' => [
                    'search_ads_360_link.name' => [
                        'getters' => [
                            'getSearchAds360Link',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSubpropertyEventFilter' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha/{subproperty_event_filter.name=properties/*/subpropertyEventFilters/*}',
                'body' => 'subproperty_event_filter',
                'placeholders' => [
                    'subproperty_event_filter.name' => [
                        'getters' => [
                            'getSubpropertyEventFilter',
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
    'numericEnums' => true,
];
