<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\ServiceControl\V1;

/**
 * [Google Quota Control API](https://cloud.google.com/service-control/overview)
 *
 * Allows clients to allocate and release quota against a [managed
 * service](https://cloud.google.com/service-management/reference/rpc/google.api/servicemanagement.v1#google.api.servicemanagement.v1.ManagedService).
 */
class QuotaControllerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Attempts to allocate quota for the specified consumer. It should be called
     * before the operation is executed.
     *
     * This method requires the `servicemanagement.services.quota`
     * permission on the specified service. For more information, see
     * [Cloud IAM](https://cloud.google.com/iam).
     *
     * **NOTE:** The client **must** fail-open on server errors `INTERNAL`,
     * `UNKNOWN`, `DEADLINE_EXCEEDED`, and `UNAVAILABLE`. To ensure system
     * reliability, the server may inject these errors to prohibit any hard
     * dependency on the quota functionality.
     * @param \Google\Cloud\ServiceControl\V1\AllocateQuotaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AllocateQuota(\Google\Cloud\ServiceControl\V1\AllocateQuotaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicecontrol.v1.QuotaController/AllocateQuota',
        $argument,
        ['\Google\Cloud\ServiceControl\V1\AllocateQuotaResponse', 'decode'],
        $metadata, $options);
    }

}
