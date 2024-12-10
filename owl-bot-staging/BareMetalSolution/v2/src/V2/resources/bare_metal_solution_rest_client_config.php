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
        'google.cloud.baremetalsolution.v2.BareMetalSolution' => [
            'CreateNfsShare' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/nfsShares',
                'body' => 'nfs_share',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProvisioningConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/provisioningConfigs',
                'body' => 'provisioning_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSSHKey' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/sshKeys',
                'body' => 'ssh_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'ssh_key_id',
                ],
            ],
            'CreateVolumeSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/volumes/*}/snapshots',
                'body' => 'volume_snapshot',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteNfsShare' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nfsShares/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSSHKey' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/sshKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteVolumeSnapshot' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DetachLun' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{instance=projects/*/locations/*/instances/*}:detachLun',
                'body' => '*',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'DisableInteractiveSerialConsole' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:disableInteractiveSerialConsole',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EnableInteractiveSerialConsole' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:enableInteractiveSerialConsole',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EvictLun' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*/luns/*}:evict',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EvictVolume' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*}:evict',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLun' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*/luns/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNetwork' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/networks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNfsShare' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nfsShares/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProvisioningConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/provisioningConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVolume' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVolumeSnapshot' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLuns' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/volumes/*}/luns',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNetworkUsage' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{location=projects/*/locations/*}/networks:listNetworkUsage',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'ListNetworks' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/networks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNfsShares' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/nfsShares',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOSImages' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/osImages',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProvisioningQuotas' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/provisioningQuotas',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSSHKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/sshKeys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVolumeSnapshots' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/volumes/*}/snapshots',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVolumes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/volumes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RenameInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:rename',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RenameNetwork' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/networks/*}:rename',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RenameNfsShare' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nfsShares/*}:rename',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RenameVolume' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/volumes/*}:rename',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResetInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:reset',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResizeVolume' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{volume=projects/*/locations/*/volumes/*}:resize',
                'body' => '*',
                'placeholders' => [
                    'volume' => [
                        'getters' => [
                            'getVolume',
                        ],
                    ],
                ],
            ],
            'RestoreVolumeSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{volume_snapshot=projects/*/locations/*/volumes/*/snapshots/*}:restoreVolumeSnapshot',
                'body' => '*',
                'placeholders' => [
                    'volume_snapshot' => [
                        'getters' => [
                            'getVolumeSnapshot',
                        ],
                    ],
                ],
            ],
            'StartInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:start',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/instances/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SubmitProvisioningConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/provisioningConfigs:submit',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateInstance' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{instance.name=projects/*/locations/*/instances/*}',
                'body' => 'instance',
                'placeholders' => [
                    'instance.name' => [
                        'getters' => [
                            'getInstance',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNetwork' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{network.name=projects/*/locations/*/networks/*}',
                'body' => 'network',
                'placeholders' => [
                    'network.name' => [
                        'getters' => [
                            'getNetwork',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNfsShare' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{nfs_share.name=projects/*/locations/*/nfsShares/*}',
                'body' => 'nfs_share',
                'placeholders' => [
                    'nfs_share.name' => [
                        'getters' => [
                            'getNfsShare',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProvisioningConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{provisioning_config.name=projects/*/locations/*/provisioningConfigs/*}',
                'body' => 'provisioning_config',
                'placeholders' => [
                    'provisioning_config.name' => [
                        'getters' => [
                            'getProvisioningConfig',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateVolume' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{volume.name=projects/*/locations/*/volumes/*}',
                'body' => 'volume',
                'placeholders' => [
                    'volume.name' => [
                        'getters' => [
                            'getVolume',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*}/locations',
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
