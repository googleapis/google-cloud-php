<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\Video\Stitcher\V1;

/**
 * Video-On-Demand content stitching API allows you to insert ads
 * into (VoD) video on demand files. You will be able to render custom
 * scrubber bars with highlighted ads, enforce ad policies, allow
 * seamless playback and tracking on native players and monetize
 * content with any standard VMAP compliant ad server.
 */
class VideoStitcherServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new CDN key.
     * @param \Google\Cloud\Video\Stitcher\V1\CreateCdnKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCdnKey(\Google\Cloud\Video\Stitcher\V1\CreateCdnKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/CreateCdnKey',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\CdnKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all CDN keys in the specified project and location.
     * @param \Google\Cloud\Video\Stitcher\V1\ListCdnKeysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCdnKeys(\Google\Cloud\Video\Stitcher\V1\ListCdnKeysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/ListCdnKeys',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\ListCdnKeysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified CDN key.
     * @param \Google\Cloud\Video\Stitcher\V1\GetCdnKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCdnKey(\Google\Cloud\Video\Stitcher\V1\GetCdnKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/GetCdnKey',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\CdnKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified CDN key.
     * @param \Google\Cloud\Video\Stitcher\V1\DeleteCdnKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCdnKey(\Google\Cloud\Video\Stitcher\V1\DeleteCdnKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/DeleteCdnKey',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified CDN key. Only update fields specified
     * in the call method body.
     * @param \Google\Cloud\Video\Stitcher\V1\UpdateCdnKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCdnKey(\Google\Cloud\Video\Stitcher\V1\UpdateCdnKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/UpdateCdnKey',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\CdnKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a client side playback VOD session and returns the full
     * tracking and playback metadata of the session.
     * @param \Google\Cloud\Video\Stitcher\V1\CreateVodSessionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateVodSession(\Google\Cloud\Video\Stitcher\V1\CreateVodSessionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/CreateVodSession',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\VodSession', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the full tracking, playback metadata, and relevant ad-ops
     * logs for the specified VOD session.
     * @param \Google\Cloud\Video\Stitcher\V1\GetVodSessionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVodSession(\Google\Cloud\Video\Stitcher\V1\GetVodSessionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/GetVodSession',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\VodSession', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of detailed stitching information of the specified VOD
     * session.
     * @param \Google\Cloud\Video\Stitcher\V1\ListVodStitchDetailsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVodStitchDetails(\Google\Cloud\Video\Stitcher\V1\ListVodStitchDetailsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/ListVodStitchDetails',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\ListVodStitchDetailsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified stitching information for the specified VOD session.
     * @param \Google\Cloud\Video\Stitcher\V1\GetVodStitchDetailRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVodStitchDetail(\Google\Cloud\Video\Stitcher\V1\GetVodStitchDetailRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/GetVodStitchDetail',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\VodStitchDetail', 'decode'],
        $metadata, $options);
    }

    /**
     * Return the list of ad tag details for the specified VOD session.
     * @param \Google\Cloud\Video\Stitcher\V1\ListVodAdTagDetailsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVodAdTagDetails(\Google\Cloud\Video\Stitcher\V1\ListVodAdTagDetailsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/ListVodAdTagDetails',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\ListVodAdTagDetailsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified ad tag detail for the specified VOD session.
     * @param \Google\Cloud\Video\Stitcher\V1\GetVodAdTagDetailRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVodAdTagDetail(\Google\Cloud\Video\Stitcher\V1\GetVodAdTagDetailRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/GetVodAdTagDetail',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\VodAdTagDetail', 'decode'],
        $metadata, $options);
    }

    /**
     * Return the list of ad tag details for the specified live session.
     * @param \Google\Cloud\Video\Stitcher\V1\ListLiveAdTagDetailsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListLiveAdTagDetails(\Google\Cloud\Video\Stitcher\V1\ListLiveAdTagDetailsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/ListLiveAdTagDetails',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\ListLiveAdTagDetailsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified ad tag detail for the specified live session.
     * @param \Google\Cloud\Video\Stitcher\V1\GetLiveAdTagDetailRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLiveAdTagDetail(\Google\Cloud\Video\Stitcher\V1\GetLiveAdTagDetailRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/GetLiveAdTagDetail',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\LiveAdTagDetail', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a slate.
     * @param \Google\Cloud\Video\Stitcher\V1\CreateSlateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSlate(\Google\Cloud\Video\Stitcher\V1\CreateSlateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/CreateSlate',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\Slate', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all slates in the specified project and location.
     * @param \Google\Cloud\Video\Stitcher\V1\ListSlatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSlates(\Google\Cloud\Video\Stitcher\V1\ListSlatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/ListSlates',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\ListSlatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified slate.
     * @param \Google\Cloud\Video\Stitcher\V1\GetSlateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSlate(\Google\Cloud\Video\Stitcher\V1\GetSlateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/GetSlate',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\Slate', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified slate.
     * @param \Google\Cloud\Video\Stitcher\V1\UpdateSlateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSlate(\Google\Cloud\Video\Stitcher\V1\UpdateSlateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/UpdateSlate',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\Slate', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified slate.
     * @param \Google\Cloud\Video\Stitcher\V1\DeleteSlateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSlate(\Google\Cloud\Video\Stitcher\V1\DeleteSlateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/DeleteSlate',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new live session.
     * @param \Google\Cloud\Video\Stitcher\V1\CreateLiveSessionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateLiveSession(\Google\Cloud\Video\Stitcher\V1\CreateLiveSessionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/CreateLiveSession',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\LiveSession', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the details for the specified live session.
     * @param \Google\Cloud\Video\Stitcher\V1\GetLiveSessionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLiveSession(\Google\Cloud\Video\Stitcher\V1\GetLiveSessionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.stitcher.v1.VideoStitcherService/GetLiveSession',
        $argument,
        ['\Google\Cloud\Video\Stitcher\V1\LiveSession', 'decode'],
        $metadata, $options);
    }

}
