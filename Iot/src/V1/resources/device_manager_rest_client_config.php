<?php

return [
    'interfaces' => [
        'google.cloud.iot.v1.DeviceManager' => [
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
            'UpdateDevice' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{device.name=projects/*/locations/*/registries/*/devices/*}',
                'body' => 'device',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{device.name=projects/*/locations/*/registries/*/groups/*/devices/*}',
                        'body' => 'device',
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
        ],
    ],
];
