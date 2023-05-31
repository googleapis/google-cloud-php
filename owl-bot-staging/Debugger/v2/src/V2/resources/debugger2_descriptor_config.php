<?php

return [
    'interfaces' => [
        'google.devtools.clouddebugger.v2.Debugger2' => [
            'DeleteBreakpoint' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'debuggee_id',
                        'fieldAccessors' => [
                            'getDebuggeeId',
                        ],
                    ],
                    [
                        'keyName' => 'breakpoint_id',
                        'fieldAccessors' => [
                            'getBreakpointId',
                        ],
                    ],
                ],
            ],
            'GetBreakpoint' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Debugger\V2\GetBreakpointResponse',
                'headerParams' => [
                    [
                        'keyName' => 'debuggee_id',
                        'fieldAccessors' => [
                            'getDebuggeeId',
                        ],
                    ],
                    [
                        'keyName' => 'breakpoint_id',
                        'fieldAccessors' => [
                            'getBreakpointId',
                        ],
                    ],
                ],
            ],
            'ListBreakpoints' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Debugger\V2\ListBreakpointsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'debuggee_id',
                        'fieldAccessors' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
            ],
            'ListDebuggees' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Debugger\V2\ListDebuggeesResponse',
            ],
            'SetBreakpoint' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Debugger\V2\SetBreakpointResponse',
                'headerParams' => [
                    [
                        'keyName' => 'debuggee_id',
                        'fieldAccessors' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
