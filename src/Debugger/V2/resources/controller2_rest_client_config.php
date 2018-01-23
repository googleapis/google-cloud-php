<?php

return [
    'interfaces' => [
        'google.devtools.clouddebugger.v2.Controller2' => [
            'RegisterDebuggee' => [
                'method' => 'post',
                'uriTemplate' => '/v2/controller/debuggees/register',
                'body' => '*',
            ],
            'ListActiveBreakpoints' => [
                'method' => 'get',
                'uriTemplate' => '/v2/controller/debuggees/{debuggee_id}/breakpoints',
                'placeholders' => [
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
            ],
            'UpdateActiveBreakpoint' => [
                'method' => 'put',
                'uriTemplate' => '/v2/controller/debuggees/{debuggee_id}/breakpoints/{breakpoint.id}',
                'body' => '*',
                'placeholders' => [
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                    'breakpoint.id' => [
                        'getters' => [
                            'getBreakpoint',
                            'getId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
