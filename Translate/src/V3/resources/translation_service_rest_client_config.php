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
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.translation.v3.TranslationService' => [
            'AdaptiveMtTranslate' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:adaptiveMtTranslate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchTranslateDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:batchTranslateDocument',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchTranslateText' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:batchTranslateText',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAdaptiveMtDataset' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/adaptiveMtDatasets',
                'body' => 'adaptive_mt_dataset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDataset' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/datasets',
                'body' => 'dataset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateGlossary' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/glossaries',
                'body' => 'glossary',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateGlossaryEntry' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/glossaries/*}/glossaryEntries',
                'body' => 'glossary_entry',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateModel' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/models',
                'body' => 'model',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAdaptiveMtDataset' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/adaptiveMtDatasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAdaptiveMtFile' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/adaptiveMtDatasets/*/adaptiveMtFiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDataset' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGlossary' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/glossaries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGlossaryEntry' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/glossaries/*/glossaryEntries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteModel' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/models/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DetectLanguage' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:detectLanguage',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=projects/*}:detectLanguage',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ExportData' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{dataset=projects/*/locations/*/datasets/*}:exportData',
                'body' => '*',
                'placeholders' => [
                    'dataset' => [
                        'getters' => [
                            'getDataset',
                        ],
                    ],
                ],
            ],
            'GetAdaptiveMtDataset' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/adaptiveMtDatasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAdaptiveMtFile' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/adaptiveMtDatasets/*/adaptiveMtFiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataset' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGlossary' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/glossaries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGlossaryEntry' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/glossaries/*/glossaryEntries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetModel' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/models/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSupportedLanguages' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/supportedLanguages',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=projects/*}/supportedLanguages',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ImportAdaptiveMtFile' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/adaptiveMtDatasets/*}:importAdaptiveMtFile',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ImportData' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{dataset=projects/*/locations/*/datasets/*}:importData',
                'body' => '*',
                'placeholders' => [
                    'dataset' => [
                        'getters' => [
                            'getDataset',
                        ],
                    ],
                ],
            ],
            'ListAdaptiveMtDatasets' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/adaptiveMtDatasets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAdaptiveMtFiles' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/adaptiveMtDatasets/*}/adaptiveMtFiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAdaptiveMtSentences' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/adaptiveMtDatasets/*/adaptiveMtFiles/*}/adaptiveMtSentences',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=projects/*/locations/*/adaptiveMtDatasets/*}/adaptiveMtSentences',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDatasets' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/datasets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExamples' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/datasets/*}/examples',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGlossaries' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/glossaries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGlossaryEntries' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/glossaries/*}/glossaryEntries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListModels' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/models',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RomanizeText' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:romanizeText',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=projects/*}:romanizeText',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'TranslateDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:translateDocument',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'TranslateText' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:translateText',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=projects/*}:translateText',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateGlossary' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{glossary.name=projects/*/locations/*/glossaries/*}',
                'body' => 'glossary',
                'placeholders' => [
                    'glossary.name' => [
                        'getters' => [
                            'getGlossary',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGlossaryEntry' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{glossary_entry.name=projects/*/locations/*/glossaries/*/glossaryEntries/*}',
                'body' => 'glossary_entry',
                'placeholders' => [
                    'glossary_entry.name' => [
                        'getters' => [
                            'getGlossaryEntry',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'WaitOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}:wait',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
