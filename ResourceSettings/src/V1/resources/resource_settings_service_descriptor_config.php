<?php

return [
    'interfaces' => [
        'google.cloud.resourcesettings.v1.ResourceSettingsService' => [
            'GetSetting' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ResourceSettings\V1\Setting',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSettings' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSettings',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ResourceSettings\V1\ListSettingsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSetting' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ResourceSettings\V1\Setting',
                'headerParams' => [
                    [
                        'keyName' => 'setting.name',
                        'fieldAccessors' => [
                            'getSetting',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'folderSettingName' => 'folders/{folder}/settings/{setting_name}',
                'organizationSettingName' => 'organizations/{organization}/settings/{setting_name}',
                'projectNumberSettingName' => 'projects/{project_number}/settings/{setting_name}',
                'setting' => 'projects/{project_number}/settings/{setting_name}',
            ],
        ],
    ],
];
