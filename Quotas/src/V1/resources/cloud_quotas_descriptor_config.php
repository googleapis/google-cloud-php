<?php

return [
    'interfaces' => [
        'google.api.cloudquotas.v1.CloudQuotas' => [
            'CreateQuotaPreference' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\QuotaPreference',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetQuotaInfo' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\QuotaInfo',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetQuotaPreference' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\QuotaPreference',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListQuotaInfos' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getQuotaInfos',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\ListQuotaInfosResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListQuotaPreferences' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getQuotaPreferences',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\ListQuotaPreferencesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateQuotaPreference' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\QuotaPreference',
                'headerParams' => [
                    [
                        'keyName' => 'quota_preference.name',
                        'fieldAccessors' => [
                            'getQuotaPreference',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'folderLocation' => 'folders/{folder}/locations/{location}',
                'folderLocationQuotaPreference' => 'folders/{folder}/locations/{location}/quotaPreferences/{quota_preference}',
                'folderLocationService' => 'folders/{folder}/locations/{location}/services/{service}',
                'folderLocationServiceQuotaInfo' => 'folders/{folder}/locations/{location}/services/{service}/quotaInfos/{quota_info}',
                'location' => 'projects/{project}/locations/{location}',
                'organizationLocation' => 'organizations/{organization}/locations/{location}',
                'organizationLocationQuotaPreference' => 'organizations/{organization}/locations/{location}/quotaPreferences/{quota_preference}',
                'organizationLocationService' => 'organizations/{organization}/locations/{location}/services/{service}',
                'organizationLocationServiceQuotaInfo' => 'organizations/{organization}/locations/{location}/services/{service}/quotaInfos/{quota_info}',
                'projectLocation' => 'projects/{project}/locations/{location}',
                'projectLocationQuotaPreference' => 'projects/{project}/locations/{location}/quotaPreferences/{quota_preference}',
                'projectLocationService' => 'projects/{project}/locations/{location}/services/{service}',
                'projectLocationServiceQuotaInfo' => 'projects/{project}/locations/{location}/services/{service}/quotaInfos/{quota_info}',
                'quotaInfo' => 'projects/{project}/locations/{location}/services/{service}/quotaInfos/{quota_info}',
                'quotaPreference' => 'projects/{project}/locations/{location}/quotaPreferences/{quota_preference}',
                'service' => 'projects/{project}/locations/{location}/services/{service}',
            ],
        ],
    ],
];
