<?php

return [
    'interfaces' => [
        'google.devtools.clouddebugger.v2.Debugger2' => [
            'SetBreakpoint' => [
                'method' => 'post',
                'uriTemplate' => '/v2/debugger/debuggees/{debuggee_id}/breakpoints/set',
                'body' => 'breakpoint',
                'placeholders' => [
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
            ],
            'GetBreakpoint' => [
                'method' => 'get',
                'uriTemplate' => '/v2/debugger/debuggees/{debuggee_id}/breakpoints/{breakpoint_id}',
                'placeholders' => [
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                    'breakpoint_id' => [
                        'getters' => [
                            'getBreakpointId',
                        ],
                    ],
                ],
            ],
            'DeleteBreakpoint' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/debugger/debuggees/{debuggee_id}/breakpoints/{breakpoint_id}',
                'placeholders' => [
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                    'breakpoint_id' => [
                        'getters' => [
                            'getBreakpointId',
                        ],
                    ],
                ],
            ],
            'ListBreakpoints' => [
                'method' => 'get',
                'uriTemplate' => '/v2/debugger/debuggees/{debuggee_id}/breakpoints',
                'placeholders' => [
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
            ],
            'ListDebuggees' => [
                'method' => 'get',
                'uriTemplate' => '/v2/debugger/debuggees',
            ],
        ],
    ],
];
