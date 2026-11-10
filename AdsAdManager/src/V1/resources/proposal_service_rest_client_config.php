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
        'google.ads.admanager.v1.ProposalService' => [
            'BatchArchiveProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchArchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDiscardDraftProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchDiscardDraft',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPauseProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchPause',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPushToOrderProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchPushToOrder',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRedraftProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchRedraft',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRequestBuyerAcceptProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchRequestBuyerAccept',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRequestBuyerReviewProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchRequestBuyerReview',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReserveProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchReserve',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResumeProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchResume',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchTerminateProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchTerminate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUnarchiveProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchUnarchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateProposals' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProposal' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals',
                'body' => 'proposal',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'FetchMarketplaceComments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals:fetchMarketplaceComments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetProposal' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/proposals/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListProposals' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/proposals',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateProposal' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{proposal.name=networks/*/proposals/*}',
                'body' => 'proposal',
                'placeholders' => [
                    'proposal.name' => [
                        'getters' => [
                            'getProposal',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}:cancel',
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
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
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
