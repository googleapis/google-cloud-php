<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/admanager/v1/request_platform_enum.proto

namespace Google\Ads\AdManager\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Wrapper message for [RequestPlatform].
 * Describes the platform from which a request is made and on which the ad is
 * rendered. In the event of multiple platforms, the platform that ultimately
 * renders the ad is the targeted platform. For example, a video player on a
 * website would have a request platform of `VIDEO_PLAYER`.
 *
 * Generated from protobuf message <code>google.ads.admanager.v1.RequestPlatformEnum</code>
 */
class RequestPlatformEnum extends \Google\Protobuf\Internal\Message
{

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\Admanager\V1\RequestPlatformEnum::initOnce();
        parent::__construct($data);
    }

}

