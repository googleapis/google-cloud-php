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
namespace Google\Cloud\Retail\V2;

/**
 * Service for search.
 *
 * This feature is only available for users who have Retail Search enabled.
 * Please enable Retail Search on Cloud Console before using this feature.
 */
class SearchServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Performs a search.
     *
     * This feature is only available for users who have Retail Search enabled.
     * Please enable Retail Search on Cloud Console before using this feature.
     * @param \Google\Cloud\Retail\V2\SearchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Search(\Google\Cloud\Retail\V2\SearchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.SearchService/Search',
        $argument,
        ['\Google\Cloud\Retail\V2\SearchResponse', 'decode'],
        $metadata, $options);
    }

}
