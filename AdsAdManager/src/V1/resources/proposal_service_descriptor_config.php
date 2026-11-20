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
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchArchiveProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchCreateProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDiscardDraftProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchDiscardDraftProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPauseProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchPauseProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPushToOrderProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchPushToOrderProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRedraftProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchRedraftProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRequestBuyerAcceptProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchRequestBuyerAcceptProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRequestBuyerReviewProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchRequestBuyerReviewProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReserveProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchReserveProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResumeProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchResumeProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchTerminateProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchTerminateProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUnarchiveProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUnarchiveProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateProposals' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUpdateProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProposal' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Proposal',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'FetchMarketplaceComments' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMarketplaceComments',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\FetchMarketplaceCommentsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetProposal' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Proposal',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListProposals' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProposals',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\ListProposalsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateProposal' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Proposal',
                'headerParams' => [
                    [
                        'keyName' => 'proposal.name',
                        'fieldAccessors' => [
                            'getProposal',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'adCategory' => 'networks/{network_code}/adCategories/{ad_category}',
                'adSpot' => 'networks/{network_code}/adSpots/{ad_spot}',
                'adUnit' => 'networks/{network_code}/adUnits/{ad_unit}',
                'application' => 'networks/{network_code}/applications/{application}',
                'audienceSegment' => 'networks/{network_code}/audienceSegments/{audience_segment}',
                'bandwidthGroup' => 'networks/{network_code}/bandwidthGroups/{bandwidth_group}',
                'browser' => 'networks/{network_code}/browsers/{browser}',
                'browserLanguage' => 'networks/{network_code}/browserLanguages/{browser_language}',
                'cmsMetadataValue' => 'networks/{network_code}/cmsMetadataValues/{cms_metadata_value}',
                'company' => 'networks/{network_code}/companies/{company}',
                'contact' => 'networks/{network_code}/contacts/{contact}',
                'content' => 'networks/{network_code}/content/{content}',
                'contentBundle' => 'networks/{network_code}/contentBundles/{content_bundle}',
                'contentLabel' => 'networks/{network_code}/contentLabels/{content_label}',
                'customField' => 'networks/{network_code}/customFields/{custom_field}',
                'customTargetingKey' => 'networks/{network_code}/customTargetingKeys/{custom_targeting_key}',
                'customTargetingValue' => 'networks/{network_code}/customTargetingValues/{custom_targeting_value}',
                'deviceCapability' => 'networks/{network_code}/deviceCapabilities/{device_capability}',
                'deviceCategory' => 'networks/{network_code}/deviceCategories/{device_category}',
                'deviceManufacturer' => 'networks/{network_code}/deviceManufacturers/{device_manufacturer}',
                'geoTarget' => 'networks/{network_code}/geoTargets/{geo_target}',
                'inventoryUrl' => 'networks/{network_code}/inventoryUrls/{inventory_url}',
                'label' => 'networks/{network_code}/labels/{label}',
                'mobileCarrier' => 'networks/{network_code}/mobileCarriers/{mobile_carrier}',
                'mobileDevice' => 'networks/{network_code}/mobileDevices/{mobile_device}',
                'mobileDeviceSubmodel' => 'networks/{network_code}/mobileDeviceSubmodels/{mobile_device_submodel}',
                'network' => 'networks/{network_code}',
                'operatingSystem' => 'networks/{network_code}/operatingSystems/{operating_system}',
                'operatingSystemVersion' => 'networks/{network_code}/operatingSystemVersions/{operating_system_version}',
                'order' => 'networks/{network_code}/orders/{order}',
                'placement' => 'networks/{network_code}/placements/{placement}',
                'proposal' => 'networks/{network_code}/proposals/{proposal}',
                'taxonomyCategory' => 'networks/{network_code}/taxonomyCategories/{taxonomy_category}',
                'team' => 'networks/{network_code}/teams/{team}',
                'user' => 'networks/{network_code}/users/{user}',
            ],
        ],
    ],
];
