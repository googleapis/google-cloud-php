<?php

return [
    'interfaces' => [
        'google.devtools.clouddebugger.v2.Controller2' => [
            'ListActiveBreakpoints' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Debugger\V2\ListActiveBreakpointsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'debuggee_id',
                        'fieldAccessors' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
            ],
            'RegisterDebuggee' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Debugger\V2\RegisterDebuggeeResponse',
            ],
            'UpdateActiveBreakpoint' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Debugger\V2\UpdateActiveBreakpointResponse',
                'headerParams' => [
                    [
                        'keyName' => 'debuggee_id',
                        'fieldAccessors' => [
                            'getDebuggeeId',
                        ],
                    ],
                    [
                        'keyName' => 'breakpoint.id',
                        'fieldAccessors' => [
                            'getBreakpoint',
                            'getId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
