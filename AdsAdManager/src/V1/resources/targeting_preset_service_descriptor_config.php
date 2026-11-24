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
        'google.ads.admanager.v1.TargetingPresetService' => [
            'BatchCreateTargetingPresets' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchCreateTargetingPresetsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateTargetingPresets' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchDeactivateTargetingPresetsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateTargetingPresets' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUpdateTargetingPresetsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTargetingPreset' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\TargetingPreset',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetTargetingPreset' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\TargetingPreset',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTargetingPresets' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTargetingPresets',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\ListTargetingPresetsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateTargetingPreset' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\TargetingPreset',
                'headerParams' => [
                    [
                        'keyName' => 'targeting_preset.name',
                        'fieldAccessors' => [
                            'getTargetingPreset',
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
                'content' => 'networks/{network_code}/content/{content}',
                'contentBundle' => 'networks/{network_code}/contentBundles/{content_bundle}',
                'contentLabel' => 'networks/{network_code}/contentLabels/{content_label}',
                'customTargetingKey' => 'networks/{network_code}/customTargetingKeys/{custom_targeting_key}',
                'customTargetingValue' => 'networks/{network_code}/customTargetingValues/{custom_targeting_value}',
                'deviceCapability' => 'networks/{network_code}/deviceCapabilities/{device_capability}',
                'deviceCategory' => 'networks/{network_code}/deviceCategories/{device_category}',
                'deviceManufacturer' => 'networks/{network_code}/deviceManufacturers/{device_manufacturer}',
                'geoTarget' => 'networks/{network_code}/geoTargets/{geo_target}',
                'inventoryUrl' => 'networks/{network_code}/inventoryUrls/{inventory_url}',
                'mobileCarrier' => 'networks/{network_code}/mobileCarriers/{mobile_carrier}',
                'mobileDevice' => 'networks/{network_code}/mobileDevices/{mobile_device}',
                'mobileDeviceSubmodel' => 'networks/{network_code}/mobileDeviceSubmodels/{mobile_device_submodel}',
                'network' => 'networks/{network_code}',
                'operatingSystem' => 'networks/{network_code}/operatingSystems/{operating_system}',
                'operatingSystemVersion' => 'networks/{network_code}/operatingSystemVersions/{operating_system_version}',
                'placement' => 'networks/{network_code}/placements/{placement}',
                'targetingPreset' => 'networks/{network_code}/targetingPresets/{targeting_preset}',
                'taxonomyCategory' => 'networks/{network_code}/taxonomyCategories/{taxonomy_category}',
            ],
        ],
    ],
];
