<?php

return [
    'interfaces' => [
        'google.devtools.clouddebugger.v2.Controller2' => [
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
            'RegisterDebuggee' => [
                'method' => 'post',
                'uriTemplate' => '/v2/controller/debuggees/register',
                'body' => '*',
            ],
            'UpdateActiveBreakpoint' => [
                'method' => 'put',
                'uriTemplate' => '/v2/controller/debuggees/{debuggee_id}/breakpoints/{breakpoint.id}',
                'body' => '*',
                'placeholders' => [
                    'breakpoint.id' => [
                        'getters' => [
                            'getBreakpoint',
                            'getId',
                        ],
                    ],
                    'debuggee_id' => [
                        'getters' => [
                            'getDebuggeeId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
