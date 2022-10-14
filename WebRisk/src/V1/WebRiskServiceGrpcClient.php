<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\WebRisk\V1;

/**
 * Web Risk API defines an interface to detect malicious URLs on your
 * website and in client applications.
 */
class WebRiskServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets the most recent threat list diffs. These diffs should be applied to
     * a local database of hashes to keep it up-to-date. If the local database is
     * empty or excessively out-of-date, a complete snapshot of the database will
     * be returned. This Method only updates a single ThreatList at a time. To
     * update multiple ThreatList databases, this method needs to be called once
     * for each list.
     * @param \Google\Cloud\WebRisk\V1\ComputeThreatListDiffRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ComputeThreatListDiff(\Google\Cloud\WebRisk\V1\ComputeThreatListDiffRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.webrisk.v1.WebRiskService/ComputeThreatListDiff',
        $argument,
        ['\Google\Cloud\WebRisk\V1\ComputeThreatListDiffResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * This method is used to check whether a URI is on a given threatList.
     * Multiple threatLists may be searched in a single query.
     * The response will list all requested threatLists the URI was found to
     * match. If the URI is not found on any of the requested ThreatList an
     * empty response will be returned.
     * @param \Google\Cloud\WebRisk\V1\SearchUrisRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchUris(\Google\Cloud\WebRisk\V1\SearchUrisRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.webrisk.v1.WebRiskService/SearchUris',
        $argument,
        ['\Google\Cloud\WebRisk\V1\SearchUrisResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the full hashes that match the requested hash prefix.
     * This is used after a hash prefix is looked up in a threatList
     * and there is a match. The client side threatList only holds partial hashes
     * so the client must query this method to determine if there is a full
     * hash match of a threat.
     * @param \Google\Cloud\WebRisk\V1\SearchHashesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchHashes(\Google\Cloud\WebRisk\V1\SearchHashesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.webrisk.v1.WebRiskService/SearchHashes',
        $argument,
        ['\Google\Cloud\WebRisk\V1\SearchHashesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Submission of a URI suspected of containing phishing content to
     * be reviewed. If the result verifies the existence of malicious phishing
     * content, the site will be added to the [Google's Social Engineering
     * lists](https://support.google.com/webmasters/answer/6350487/) in order to
     * protect users that could get exposed to this threat in the future. Only
     * allowlisted projects can use this method during Early Access. Please reach
     * out to Sales or your customer engineer to obtain access.
     * @param \Google\Cloud\WebRisk\V1\CreateSubmissionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSubmission(\Google\Cloud\WebRisk\V1\CreateSubmissionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.webrisk.v1.WebRiskService/CreateSubmission',
        $argument,
        ['\Google\Cloud\WebRisk\V1\Submission', 'decode'],
        $metadata, $options);
    }

}
