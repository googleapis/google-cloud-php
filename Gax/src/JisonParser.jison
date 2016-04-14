/*
 * Copyright 2016, Google Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/* description: Parses a path template string and returns an array of
 * Segment objects.
 */

/* lexical grammar */
%lex
%%

\s+                     /* skip whitespace */
"/"                     return 'FORWARD_SLASH'
"{"                     return 'LEFT_BRACE'
"}"                     return 'RIGHT_BRACE'
"="                     return 'EQUALS'
"**"                    return 'PATH_WILDCARD'
"*"                     return 'WILDCARD'
[^*=}{}\/]+             return 'LITERAL'
<<EOF>>                 /* skip EOF */

/lex

%token 'FORWARD_SLASH'
%token 'LEFT_BRACE'
%token 'RIGHT_BRACE'
%token 'EQUALS'
%token 'LITERAL'
%token 'PATH_WILDCARD'
%token 'WILDCARD'

%% /* language grammar */

/* This file is used by a php port of Jison (https://github.com/zaach/jison).
 * However, the port to php uses the Jison tool to generate the parser before
 * converting the generated Node.js parser to php. This means that the code
 * fragments written below are parsed by Jison as Node.js, and if they are not
 * valid Node.js syntax the generation will fail.
 *
 * In order to work around this, we do the following:
 *  - object properties are accessed using get_object_vars(foo)['bar']
 *      instead of foo->bar
 *  - global variables are defined in GLOBALS to avoid using backslash to
 *      reference the global namespace
 */

template
    : FORWARD_SLASH bound_segments
        {
            return get_object_vars($2)['text'];
        }
    | bound_segments
        {
            return get_object_vars($1)['text'];
        }
    ;

bound_segments
    : bound_segment FORWARD_SLASH bound_segments
        {
            $t1 = get_object_vars($1)['text'];
            $t3 = get_object_vars($3)['text'];
            $$ = array_merge($t1, $t3);
        }
    | bound_segment
        {
            $$ = get_object_vars($1)['text'];
        }
    ;

unbound_segments
    : unbound_terminal FORWARD_SLASH unbound_segments
        {
            $t1 = get_object_vars($1)['text'];
            $t3 = get_object_vars($3)['text'];
            $$ = array_merge($t1, $t3);
        }
    | unbound_terminal
        {
            $$ = get_object_vars($1)['text'];
        }
    ;

bound_segment
    : bound_terminal
        {
            $$ = get_object_vars($1)['text'];
        }
    | variable
        {
            $$ = get_object_vars($1)['text'];
        }
    ;

unbound_terminal
    : WILDCARD
        {
            $t1 = get_object_vars($1)['text'];
            $GLOBALS['gax_path_template_segment_count'] += 1;
            $$ = [new Segment(GAX_PATH_TEMPLATE_TERMINAL, $t1)];
        }
    | PATH_WILDCARD
        {
            $t1 = get_object_vars($1)['text'];
            $GLOBALS['gax_path_template_segment_count'] += 1;
            $$ = [new Segment(GAX_PATH_TEMPLATE_TERMINAL, $t1)];
        }
    | LITERAL
        {
            $t1 = get_object_vars($1)['text'];
            $GLOBALS['gax_path_template_segment_count'] += 1;
            $$ = [new Segment(GAX_PATH_TEMPLATE_TERMINAL, $t1)];
        }
    ;

bound_terminal
    : unbound_terminal
        {
            $t1 = get_object_vars($1)['text'];
            if (in_array($t1[0]['literal'], ['*', '**'])) {
                $$ = [
                        new Segment(GAX_PATH_TEMPLATE_BINDING,
                            sprintf('$%d', $GLOBALS['gax_path_template_binding_count'])),
                        $t1[0],
                        new Segment(GAX_PATH_TEMPLATE_END_BINDING, '')
                    ];
                $GLOBALS['gax_path_template_binding_count'] += 1;
            } else {
                $$ = $t1;
            }
        }
    ;

variable
    : LEFT_BRACE LITERAL EQUALS unbound_segments RIGHT_BRACE
        {
            $t2 = get_object_vars($2)['text'];
            $t4 = get_object_vars($4)['text'];
            $tmp = [new Segment(GAX_PATH_TEMPLATE_BINDING, $t2)];
            $tmp = array_merge($tmp, $t4);
            array_push($tmp, new Segment(GAX_PATH_TEMPLATE_END_BINDING, ''));
            $$ = $tmp;
        }
    | LEFT_BRACE LITERAL RIGHT_BRACE
        {
            $t2 = get_object_vars($2)['text'];
            $$ = [
                    new Segment(GAX_PATH_TEMPLATE_BINDING, $t2),
                    new Segment(GAX_PATH_TEMPLATE_TERMINAL, '*'),
                    new Segment(GAX_PATH_TEMPLATE_END_BINDING, '')];
            $GLOBALS['gax_path_template_segment_count'] += 1;
        }
    ;

