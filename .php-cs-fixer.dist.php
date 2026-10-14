<?php
/**
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'new_with_parentheses' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'single_quote' => true,
        'single_space_around_construct' => true,
        'cast_spaces' => true,
        'whitespace_after_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'binary_operator_spaces' => ['default' => 'at_least_single_space'],
        'no_extra_blank_lines' => true,
        'nullable_type_declaration_for_default_null_value' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->notPath([
                '#.*/src/V[0-9]+#',
                '#.*/src/.*/V[0-9]+#',
                '#.*/(tests|samples|metadata)#',
                'vendor',
                'dev',
                'docs',
                'AccessContextManager/src/Type',
                'Asset/external',
                'BigQueryDataExchange/src/Common',
                'CommonProtos',
                'Core/src/Testing',
                'GSuiteAddOns/external',
                'OsLogin/src/Common',
                'LongRunning/src/ApiCore/LongRunning',
                'LongRunning/src/LongRunning',
                'Translate/src/Connection',
                'Translate/src/TranslateClient.php',
            ])
    )
;
