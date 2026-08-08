<?php
/*
 * Copyright 2026 Google LLC
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.visionai.v1.Warehouse' => [
            'AddCollectionItem' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{item.collection=projects/*/locations/*/corpora/*/collections/*}:addCollectionItem',
                'body' => '*',
                'placeholders' => [
                    'item.collection' => [
                        'getters' => [
                            'getItem',
                            'getCollection',
                        ],
                    ],
                ],
            ],
            'AnalyzeAsset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}:analyze',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'AnalyzeCorpus' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*}:analyze',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ClipAsset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}:clip',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateAnnotation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*/assets/*}/annotations',
                'body' => 'annotation',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAsset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/assets',
                'body' => 'asset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCollection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/collections',
                'body' => 'collection',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCorpus' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/corpora',
                'body' => 'corpus',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDataSchema' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/dataSchemas',
                'body' => 'data_schema',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateIndex' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/indexes',
                'body' => 'index',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateIndexEndpoint' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/indexEndpoints',
                'body' => 'index_endpoint',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSearchConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/searchConfigs',
                'body' => 'search_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'search_config_id',
                ],
            ],
            'CreateSearchHypernym' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/searchHypernyms',
                'body' => 'search_hypernym',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAnnotation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*/annotations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAsset' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCollection' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/collections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCorpus' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDataSchema' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/dataSchemas/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteIndex' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/indexes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteIndexEndpoint' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSearchConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/searchConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSearchHypernym' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/searchHypernyms/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeployIndex' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{index_endpoint=projects/*/locations/*/indexEndpoints/*}:deployIndex',
                'body' => '*',
                'placeholders' => [
                    'index_endpoint' => [
                        'getters' => [
                            'getIndexEndpoint',
                        ],
                    ],
                ],
            ],
            'GenerateHlsUri' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}:generateHlsUri',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateRetrievalUrl' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}:generateRetrievalUrl',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAnnotation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*/annotations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAsset' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCollection' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/collections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCorpus' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataSchema' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/dataSchemas/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIndex' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/indexes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIndexEndpoint' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSearchConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/searchConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSearchHypernym' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/searchHypernyms/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/assets:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'IndexAsset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}:index',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAnnotations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*/assets/*}/annotations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAssets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/assets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCollections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/collections',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCorpora' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/corpora',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDataSchemas' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/dataSchemas',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIndexEndpoints' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/indexEndpoints',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIndexes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/indexes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSearchConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/searchConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSearchHypernyms' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/corpora/*}/searchHypernyms',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveCollectionItem' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{item.collection=projects/*/locations/*/corpora/*/collections/*}:removeCollectionItem',
                'body' => '*',
                'placeholders' => [
                    'item.collection' => [
                        'getters' => [
                            'getItem',
                            'getCollection',
                        ],
                    ],
                ],
            ],
            'RemoveIndexAsset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}:removeIndex',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{corpus=projects/*/locations/*/corpora/*}:searchAssets',
                'body' => '*',
                'placeholders' => [
                    'corpus' => [
                        'getters' => [
                            'getCorpus',
                        ],
                    ],
                ],
            ],
            'SearchIndexEndpoint' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{index_endpoint=projects/*/locations/*/indexEndpoints/*}:searchIndexEndpoint',
                'body' => '*',
                'placeholders' => [
                    'index_endpoint' => [
                        'getters' => [
                            'getIndexEndpoint',
                        ],
                    ],
                ],
            ],
            'UndeployIndex' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{index_endpoint=projects/*/locations/*/indexEndpoints/*}:undeployIndex',
                'body' => '*',
                'placeholders' => [
                    'index_endpoint' => [
                        'getters' => [
                            'getIndexEndpoint',
                        ],
                    ],
                ],
            ],
            'UpdateAnnotation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{annotation.name=projects/*/locations/*/corpora/*/assets/*/annotations/*}',
                'body' => 'annotation',
                'placeholders' => [
                    'annotation.name' => [
                        'getters' => [
                            'getAnnotation',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAsset' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{asset.name=projects/*/locations/*/corpora/*/assets/*}',
                'body' => 'asset',
                'placeholders' => [
                    'asset.name' => [
                        'getters' => [
                            'getAsset',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCollection' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{collection.name=projects/*/locations/*/corpora/*/collections/*}',
                'body' => 'collection',
                'placeholders' => [
                    'collection.name' => [
                        'getters' => [
                            'getCollection',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCorpus' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{corpus.name=projects/*/locations/*/corpora/*}',
                'body' => 'corpus',
                'placeholders' => [
                    'corpus.name' => [
                        'getters' => [
                            'getCorpus',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDataSchema' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{data_schema.name=projects/*/locations/*/corpora/*/dataSchemas/*}',
                'body' => 'data_schema',
                'placeholders' => [
                    'data_schema.name' => [
                        'getters' => [
                            'getDataSchema',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateIndex' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{index.name=projects/*/locations/*/corpora/*/indexes/*}',
                'body' => 'index',
                'placeholders' => [
                    'index.name' => [
                        'getters' => [
                            'getIndex',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateIndexEndpoint' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{index_endpoint.name=projects/*/locations/*/indexEndpoints/*}',
                'body' => 'index_endpoint',
                'placeholders' => [
                    'index_endpoint.name' => [
                        'getters' => [
                            'getIndexEndpoint',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSearchConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{search_config.name=projects/*/locations/*/corpora/*/searchConfigs/*}',
                'body' => 'search_config',
                'placeholders' => [
                    'search_config.name' => [
                        'getters' => [
                            'getSearchConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSearchHypernym' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{search_hypernym.name=projects/*/locations/*/corpora/*/searchHypernyms/*}',
                'body' => 'search_hypernym',
                'placeholders' => [
                    'search_hypernym.name' => [
                        'getters' => [
                            'getSearchHypernym',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UploadAsset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*}:upload',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ViewCollectionItems' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{collection=projects/*/locations/*/corpora/*/collections/*}:viewCollectionItems',
                'placeholders' => [
                    'collection' => [
                        'getters' => [
                            'getCollection',
                        ],
                    ],
                ],
            ],
            'ViewIndexedAssets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{index=projects/*/locations/*/corpora/*/indexes/*}:viewAssets',
                'placeholders' => [
                    'index' => [
                        'getters' => [
                            'getIndex',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/warehouseOperations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/collections/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/imageIndexes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                ],
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
