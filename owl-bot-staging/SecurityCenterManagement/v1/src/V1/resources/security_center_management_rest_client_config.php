<?php

return [
    'interfaces' => [
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.securitycentermanagement.v1.SecurityCenterManagement' => [
            'CreateEventThreatDetectionCustomModule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/eventThreatDetectionCustomModules',
                'body' => 'event_threat_detection_custom_module',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/eventThreatDetectionCustomModules',
                        'body' => 'event_threat_detection_custom_module',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/eventThreatDetectionCustomModules',
                        'body' => 'event_threat_detection_custom_module',
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
            'CreateSecurityHealthAnalyticsCustomModule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/securityHealthAnalyticsCustomModules',
                'body' => 'security_health_analytics_custom_module',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/securityHealthAnalyticsCustomModules',
                        'body' => 'security_health_analytics_custom_module',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/securityHealthAnalyticsCustomModules',
                        'body' => 'security_health_analytics_custom_module',
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
            'DeleteEventThreatDetectionCustomModule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/eventThreatDetectionCustomModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/eventThreatDetectionCustomModules/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/eventThreatDetectionCustomModules/*}',
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
            'DeleteSecurityHealthAnalyticsCustomModule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/securityHealthAnalyticsCustomModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/securityHealthAnalyticsCustomModules/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/securityHealthAnalyticsCustomModules/*}',
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
            'GetEffectiveEventThreatDetectionCustomModule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/effectiveEventThreatDetectionCustomModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/effectiveEventThreatDetectionCustomModules/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/effectiveEventThreatDetectionCustomModules/*}',
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
            'GetEffectiveSecurityHealthAnalyticsCustomModule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/effectiveSecurityHealthAnalyticsCustomModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/effectiveSecurityHealthAnalyticsCustomModules/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/effectiveSecurityHealthAnalyticsCustomModules/*}',
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
            'GetEventThreatDetectionCustomModule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/eventThreatDetectionCustomModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/eventThreatDetectionCustomModules/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/eventThreatDetectionCustomModules/*}',
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
            'GetSecurityHealthAnalyticsCustomModule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/securityHealthAnalyticsCustomModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/securityHealthAnalyticsCustomModules/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/securityHealthAnalyticsCustomModules/*}',
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
            'ListDescendantEventThreatDetectionCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/eventThreatDetectionCustomModules:listDescendant',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/eventThreatDetectionCustomModules:listDescendant',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/eventThreatDetectionCustomModules:listDescendant',
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
            'ListDescendantSecurityHealthAnalyticsCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/securityHealthAnalyticsCustomModules:listDescendant',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/securityHealthAnalyticsCustomModules:listDescendant',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/securityHealthAnalyticsCustomModules:listDescendant',
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
            'ListEffectiveEventThreatDetectionCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/effectiveEventThreatDetectionCustomModules',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/effectiveEventThreatDetectionCustomModules',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/effectiveEventThreatDetectionCustomModules',
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
            'ListEffectiveSecurityHealthAnalyticsCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/effectiveSecurityHealthAnalyticsCustomModules',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/effectiveSecurityHealthAnalyticsCustomModules',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/effectiveSecurityHealthAnalyticsCustomModules',
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
            'ListEventThreatDetectionCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/eventThreatDetectionCustomModules',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/eventThreatDetectionCustomModules',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/eventThreatDetectionCustomModules',
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
            'ListSecurityHealthAnalyticsCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/securityHealthAnalyticsCustomModules',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/securityHealthAnalyticsCustomModules',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/securityHealthAnalyticsCustomModules',
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
            'SimulateSecurityHealthAnalyticsCustomModule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/securityHealthAnalyticsCustomModules:simulate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/securityHealthAnalyticsCustomModules:simulate',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/securityHealthAnalyticsCustomModules:simulate',
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
            'UpdateEventThreatDetectionCustomModule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{event_threat_detection_custom_module.name=projects/*/locations/*/eventThreatDetectionCustomModules/*}',
                'body' => 'event_threat_detection_custom_module',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{event_threat_detection_custom_module.name=folders/*/locations/*/eventThreatDetectionCustomModules/*}',
                        'body' => 'event_threat_detection_custom_module',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{event_threat_detection_custom_module.name=organizations/*/locations/*/eventThreatDetectionCustomModules/*}',
                        'body' => 'event_threat_detection_custom_module',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                ],
                'placeholders' => [
                    'event_threat_detection_custom_module.name' => [
                        'getters' => [
                            'getEventThreatDetectionCustomModule',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSecurityHealthAnalyticsCustomModule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{security_health_analytics_custom_module.name=projects/*/locations/*/securityHealthAnalyticsCustomModules/*}',
                'body' => 'security_health_analytics_custom_module',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_health_analytics_custom_module.name=folders/*/locations/*/securityHealthAnalyticsCustomModules/*}',
                        'body' => 'security_health_analytics_custom_module',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_health_analytics_custom_module.name=organizations/*/locations/*/securityHealthAnalyticsCustomModules/*}',
                        'body' => 'security_health_analytics_custom_module',
                        'queryParams' => [
                            'update_mask',
                        ],
                    ],
                ],
                'placeholders' => [
                    'security_health_analytics_custom_module.name' => [
                        'getters' => [
                            'getSecurityHealthAnalyticsCustomModule',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'ValidateEventThreatDetectionCustomModule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/eventThreatDetectionCustomModules:validate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/eventThreatDetectionCustomModules:validate',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/eventThreatDetectionCustomModules:validate',
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
    'numericEnums' => true,
];
