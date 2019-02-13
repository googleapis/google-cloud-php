<?php

return [
    'interfaces' => [
        'google.cloud.irm.v1alpha2.IncidentService' => [
            'CreateIncident' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*}/incidents',
                'body' => 'incident',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetIncident' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchIncidents' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*}/incidents:search',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateIncident' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha2/{incident.name=projects/*/incidents/*}',
                'body' => 'incident',
                'placeholders' => [
                    'incident.name' => [
                        'getters' => [
                            'getIncident',
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchSimilarIncidents' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*}:searchSimilar',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha2/{name=projects/*/signals/*}:searchSimilarIncidents',
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
            'CreateAnnotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/annotations',
                'body' => 'annotation',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAnnotations' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/annotations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAnnotation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha2/{annotation.name=projects/*/incidents/*/annotations/*}',
                'body' => 'annotation',
                'placeholders' => [
                    'annotation.name' => [
                        'getters' => [
                            'getAnnotation',
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateTag' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/tags',
                'body' => 'tag',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteTag' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*/tags/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTags' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/tags',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSignal' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*}/signals',
                'body' => 'signal',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSignals' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*}/signals',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetSignal' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{name=projects/*/signals/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSignal' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha2/{signal.name=projects/*/signals/*}',
                'body' => 'signal',
                'placeholders' => [
                    'signal.name' => [
                        'getters' => [
                            'getSignal',
                            'getName',
                        ],
                    ],
                ],
            ],
            'AcknowledgeSignal' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{name=projects/*/signals/*}:ack',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EscalateIncident' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{incident.name=projects/*/incidents/*}:escalate',
                'body' => '*',
                'placeholders' => [
                    'incident.name' => [
                        'getters' => [
                            'getIncident',
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateArtifact' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/artifacts',
                'body' => 'artifact',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListArtifacts' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/artifacts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateArtifact' => [
                'method' => 'patch',
                'uriTemplate' => '/v1alpha2/{artifact.name=projects/*/incidents/*/artifacts/*}',
                'body' => 'artifact',
                'placeholders' => [
                    'artifact.name' => [
                        'getters' => [
                            'getArtifact',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteArtifact' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*/artifacts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetShiftHandoffPresets' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*}/shiftHandoffPresets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SendShiftHandoff' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*}/shiftHandoff:send',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/subscriptions',
                'body' => 'subscription',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSubscriptions' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/subscriptions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteSubscription' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*/subscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateIncidentRoleAssignment' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/roleAssignments',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteIncidentRoleAssignment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*/roleAssignments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListIncidentRoleAssignments' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha2/{parent=projects/*/incidents/*}/roleAssignments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RequestIncidentRoleHandover' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*/roleAssignments/*}:requestHandover',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ConfirmIncidentRoleHandover' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*/roleAssignments/*}:confirmHandover',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ForceIncidentRoleHandover' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*/roleAssignments/*}:forceHandover',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelIncidentRoleHandover' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha2/{name=projects/*/incidents/*/roleAssignments/*}:cancelHandover',
                'body' => '*',
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
