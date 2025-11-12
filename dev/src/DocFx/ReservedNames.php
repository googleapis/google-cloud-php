<?php

namespace Google\Cloud\Dev\DocFx;

class ReservedNames
{
    /**
     * Copied from protocolbuffers `src/google/protobuf/compiler/php/names.cc`.
     * Keep this list up-to-date if modified for future PHP versions
     *
     * @see https://github.com/protocolbuffers/protobuf/blob/00a9043d0d79b65b47a048a20d01b16618c8396a/src/google/protobuf/compiler/php/names.cc#L18-L34
     */
    public const RESERVED_NAMES = [
        'abstract',     'and',        'array',        'as',         'break',
        'callable',     'case',       'catch',        'class',      'clone',
        'const',        'continue',   'declare',      'default',    'die',
        'do',           'echo',       'else',         'elseif',     'empty',
        'enddeclare',   'endfor',     'endforeach',   'endif',      'endswitch',
        'endwhile',     'eval',       'exit',         'extends',    'final',
        'finally',      'fn',         'for',          'foreach',    'function',
        'global',       'goto',       'if',           'implements', 'include',
        'include_once', 'instanceof', 'insteadof',    'interface',  'isset',
        'list',         'match',      'namespace',    'new',        'or',
        'parent',       'print',      'private',      'protected',  'public',
        'readonly',     'require',    'require_once', 'return',     'self',
        'static',       'switch',     'throw',        'trait',      'try',
        'unset',        'use',        'var',          'while',      'xor',
        'yield',        'int',        'float',        'bool',       'string',
        'true',         'false',      'null',         'void',       'iterable',
    ];
}