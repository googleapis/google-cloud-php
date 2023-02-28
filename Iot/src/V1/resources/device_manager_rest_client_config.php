<?php

return [
    'interfaces' => [
        'google.cloud.iot.v1.DeviceManager' => [
            'BindDeviceToGateway' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/registries/*}:bindDeviceToGateway',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/registries/*/groups/*}:bindDeviceToGateway',
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
            'CreateDevice' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/registries/*}/devices',
                'body' => 'device',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDeviceRegistry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/registries',
                'body' => 'device_registry',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteDevice' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/devices/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDeviceRegistry' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDevice' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/devices/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/groups/*/devices/*}',
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
            'GetDeviceRegistry' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/registries/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/registries/*/groups/*}:getIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'ListDeviceConfigVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/devices/*}/configVersions',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/groups/*/devices/*}/configVersions',
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
            'ListDeviceRegistries' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/registries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDeviceStates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/devices/*}/states',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/groups/*/devices/*}/states',
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
            'ListDevices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/registries/*}/devices',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/registries/*/groups/*}/devices',
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
            'ModifyCloudToDeviceConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/devices/*}:modifyCloudToDeviceConfig',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/groups/*/devices/*}:modifyCloudToDeviceConfig',
                        'body' => '*',
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
            'SendCommandToDevice' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/devices/*}:sendCommandToDevice',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/registries/*/groups/*/devices/*}:sendCommandToDevice',
                        'body' => '*',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/registries/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/registries/*/groups/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/registries/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/registries/*/groups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UnbindDeviceFromGateway' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/registries/*}:unbindDeviceFromGateway',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/registries/*/groups/*}:unbindDeviceFromGateway',
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
            'UpdateDevice' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{device.name=projects/*/locations/*/registries/*/devices/*}',
                'body' => 'device',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{device.name=projects/*/locations/*/registries/*/groups/*/devices/*}',
                        'body' => 'device',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                ],
                'placeholders' => [
                    'device.name' => [
                        'getters' => [
                            'getDevice',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDeviceRegistry' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{device_registry.name=projects/*/locations/*/registries/*}',
                'body' => 'device_registry',
                'placeholders' => [
                    'device_registry.name' => [
                        'getters' => [
                            'getDeviceRegistry',
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
