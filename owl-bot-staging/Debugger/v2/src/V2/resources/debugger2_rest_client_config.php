<?php

return [
    'interfaces' => [
        'google.devtools.clouddebugger.v2.Debugger2' => [
            'DeleteBreakpoint' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/debugger/debuggees/{debuggee_id}/breakpoints/{breakpoint_id}',
                'placeholders' => [
                    'breakpoint_id' => [
                        'getters' => [
                            'getBreakpointId',
                        ],
                    ],
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
                'queryParams' => [
                    'client_version',
                ],
            ],
            'GetBreakpoint' => [
                'method' => 'get',
                'uriTemplate' => '/v2/debugger/debuggees/{debuggee_id}/breakpoints/{breakpoint_id}',
                'placeholders' => [
                    'breakpoint_id' => [
                        'getters' => [
                            'getBreakpointId',
                        ],
                    ],
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
                'queryParams' => [
                    'client_version',
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
                'queryParams' => [
                    'client_version',
                ],
            ],
            'ListDebuggees' => [
                'method' => 'get',
                'uriTemplate' => '/v2/debugger/debuggees',
                'queryParams' => [
                    'project',
                    'client_version',
                ],
            ],
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
                'queryParams' => [
                    'client_version',
                ],
            ],
        ],
    ],
];
