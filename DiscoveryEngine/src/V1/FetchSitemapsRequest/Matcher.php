<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/site_search_engine_service.proto

namespace Google\Cloud\DiscoveryEngine\V1\FetchSitemapsRequest;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Matcher for the [Sitemap][google.cloud.discoveryengine.v1.Sitemap]s.
 * Currently only supports uris matcher.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.FetchSitemapsRequest.Matcher</code>
 */
class Matcher extends \Google\Protobuf\Internal\Message
{
    protected $matcher;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\DiscoveryEngine\V1\FetchSitemapsRequest\UrisMatcher $uris_matcher
     *           Matcher by sitemap URIs.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\SiteSearchEngineService::initOnce();
        parent::__construct($data);
    }

    /**
     * Matcher by sitemap URIs.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.FetchSitemapsRequest.UrisMatcher uris_matcher = 1;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\FetchSitemapsRequest\UrisMatcher|null
     */
    public function getUrisMatcher()
    {
        return $this->readOneof(1);
    }

    public function hasUrisMatcher()
    {
        return $this->hasOneof(1);
    }

    /**
     * Matcher by sitemap URIs.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.FetchSitemapsRequest.UrisMatcher uris_matcher = 1;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\FetchSitemapsRequest\UrisMatcher $var
     * @return $this
     */
    public function setUrisMatcher($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\FetchSitemapsRequest\UrisMatcher::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getMatcher()
    {
        return $this->whichOneof("matcher");
    }

}


