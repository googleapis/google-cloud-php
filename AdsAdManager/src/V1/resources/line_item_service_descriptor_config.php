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
        'google.ads.admanager.v1.LineItemService' => [
            'BatchActivateLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchActivateLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchArchiveLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchArchiveLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchCreateLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchPauseLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchPauseLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReleaseLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchReleaseLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReserveAndOverbookLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchReserveAndOverbookLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReserveLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchReserveLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResumeAndOverbookLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchResumeAndOverbookLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchResumeLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchResumeLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUnarchiveLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUnarchiveLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateLineItems' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUpdateLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateLineItem' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\LineItem',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetLineItem' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\LineItem',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLineItems' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLineItems',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\ListLineItemsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateLineItem' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\LineItem',
                'headerParams' => [
                    [
                        'keyName' => 'line_item.name',
                        'fieldAccessors' => [
                            'getLineItem',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'adUnit' => 'networks/{network_code}/adUnits/{ad_unit}',
                'application' => 'networks/{network_code}/applications/{application}',
                'audienceSegment' => 'networks/{network_code}/audienceSegments/{audience_segment}',
                'bandwidthGroup' => 'networks/{network_code}/bandwidthGroups/{bandwidth_group}',
                'browser' => 'networks/{network_code}/browsers/{browser}',
                'browserLanguage' => 'networks/{network_code}/browserLanguages/{browser_language}',
                'cmsMetadataValue' => 'networks/{network_code}/cmsMetadataValues/{cms_metadata_value}',
                'company' => 'networks/{network_code}/companies/{company}',
                'content' => 'networks/{network_code}/content/{content}',
                'contentBundle' => 'networks/{network_code}/contentBundles/{content_bundle}',
                'customField' => 'networks/{network_code}/customFields/{custom_field}',
                'customTargetingKey' => 'networks/{network_code}/customTargetingKeys/{custom_targeting_key}',
                'customTargetingValue' => 'networks/{network_code}/customTargetingValues/{custom_targeting_value}',
                'deviceCapability' => 'networks/{network_code}/deviceCapabilities/{device_capability}',
                'deviceCategory' => 'networks/{network_code}/deviceCategories/{device_category}',
                'deviceManufacturer' => 'networks/{network_code}/deviceManufacturers/{device_manufacturer}',
                'geoTarget' => 'networks/{network_code}/geoTargets/{geo_target}',
                'label' => 'networks/{network_code}/labels/{label}',
                'lineItem' => 'networks/{network_code}/lineItems/{line_item}',
                'mobileCarrier' => 'networks/{network_code}/mobileCarriers/{mobile_carrier}',
                'mobileDevice' => 'networks/{network_code}/mobileDevices/{mobile_device}',
                'mobileDeviceSubmodel' => 'networks/{network_code}/mobileDeviceSubmodels/{mobile_device_submodel}',
                'network' => 'networks/{network_code}',
                'operatingSystem' => 'networks/{network_code}/operatingSystems/{operating_system}',
                'operatingSystemVersion' => 'networks/{network_code}/operatingSystemVersions/{operating_system_version}',
                'order' => 'networks/{network_code}/orders/{order}',
                'placement' => 'networks/{network_code}/placements/{placement}',
            ],
        ],
    ],
];
