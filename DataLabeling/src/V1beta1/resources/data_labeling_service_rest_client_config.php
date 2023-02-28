<?php

return [
    'interfaces' => [
        'google.cloud.datalabeling.v1beta1.DataLabelingService' => [
            'CreateAnnotationSpecSet' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/annotationSpecSets',
                'body' => '*',
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
                'uriTemplate' => '/v1beta1/{parent=projects/*}/datasets',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateEvaluationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/evaluationJobs',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateInstruction' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/instructions',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAnnotatedDataset' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*/annotatedDatasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAnnotationSpecSet' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/annotationSpecSets/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEvaluationJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/evaluationJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteInstruction' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/instructions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportData' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*}:exportData',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAnnotatedDataset' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*/annotatedDatasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAnnotationSpecSet' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/annotationSpecSets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataItem' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*/dataItems/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEvaluation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*/evaluations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEvaluationJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/evaluationJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExample' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*/annotatedDatasets/*/examples/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInstruction' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/instructions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportData' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/datasets/*}:importData',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'LabelImage' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/datasets/*}/image:label',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LabelText' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/datasets/*}/text:label',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LabelVideo' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/datasets/*}/video:label',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAnnotatedDatasets' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/datasets/*}/annotatedDatasets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAnnotationSpecSets' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/annotationSpecSets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDataItems' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/datasets/*}/dataItems',
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
                'uriTemplate' => '/v1beta1/{parent=projects/*}/datasets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEvaluationJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/evaluationJobs',
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
                'uriTemplate' => '/v1beta1/{parent=projects/*/datasets/*/annotatedDatasets/*}/examples',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInstructions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/instructions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PauseEvaluationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/evaluationJobs/*}:pause',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResumeEvaluationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/evaluationJobs/*}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchEvaluations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/evaluations:search',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchExampleComparisons' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/datasets/*/evaluations/*}/exampleComparisons:search',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateEvaluationJob' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{evaluation_job.name=projects/*/evaluationJobs/*}',
                'body' => 'evaluation_job',
                'placeholders' => [
                    'evaluation_job.name' => [
                        'getters' => [
                            'getEvaluationJob',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/operations/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*/operations/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*}/operations',
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
];
