<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

return [
    'interfaces' => [
        'google.shopping.css.v1.CssProductInputsService' => [
            'DeleteCssProductInput' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=accounts/*/cssProductInputs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InsertCssProductInput' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}/cssProductInputs:insert',
                'body' => 'css_product_input',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCssProductInput' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{css_product_input.name=accounts/*/cssProductInputs/*}',
                'body' => 'css_product_input',
                'placeholders' => [
                    'css_product_input.name' => [
                        'getters' => [
                            'getCssProductInput',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
