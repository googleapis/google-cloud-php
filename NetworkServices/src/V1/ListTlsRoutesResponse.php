<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkservices/v1/tls_route.proto

namespace Google\Cloud\NetworkServices\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response returned by the ListTlsRoutes method.
 *
 * Generated from protobuf message <code>google.cloud.networkservices.v1.ListTlsRoutesResponse</code>
 */
class ListTlsRoutesResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * List of TlsRoute resources.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkservices.v1.TlsRoute tls_routes = 1;</code>
     */
    private $tls_routes;
    /**
     * If there might be more results than those appearing in this response, then
     * `next_page_token` is included. To get the next set of results, call this
     * method again using the value of `next_page_token` as `page_token`.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';
    /**
     * Unreachable resources. Populated when the request opts into
     * [return_partial_success][google.cloud.networkservices.v1.ListTlsRoutesRequest.return_partial_success]
     * and reading across collections e.g. when attempting to list all resources
     * across all supported locations.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     */
    private $unreachable;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\NetworkServices\V1\TlsRoute>|\Google\Protobuf\Internal\RepeatedField $tls_routes
     *           List of TlsRoute resources.
     *     @type string $next_page_token
     *           If there might be more results than those appearing in this response, then
     *           `next_page_token` is included. To get the next set of results, call this
     *           method again using the value of `next_page_token` as `page_token`.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $unreachable
     *           Unreachable resources. Populated when the request opts into
     *           [return_partial_success][google.cloud.networkservices.v1.ListTlsRoutesRequest.return_partial_success]
     *           and reading across collections e.g. when attempting to list all resources
     *           across all supported locations.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networkservices\V1\TlsRoute::initOnce();
        parent::__construct($data);
    }

    /**
     * List of TlsRoute resources.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkservices.v1.TlsRoute tls_routes = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTlsRoutes()
    {
        return $this->tls_routes;
    }

    /**
     * List of TlsRoute resources.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkservices.v1.TlsRoute tls_routes = 1;</code>
     * @param array<\Google\Cloud\NetworkServices\V1\TlsRoute>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTlsRoutes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\NetworkServices\V1\TlsRoute::class);
        $this->tls_routes = $arr;

        return $this;
    }

    /**
     * If there might be more results than those appearing in this response, then
     * `next_page_token` is included. To get the next set of results, call this
     * method again using the value of `next_page_token` as `page_token`.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * If there might be more results than those appearing in this response, then
     * `next_page_token` is included. To get the next set of results, call this
     * method again using the value of `next_page_token` as `page_token`.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setNextPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->next_page_token = $var;

        return $this;
    }

    /**
     * Unreachable resources. Populated when the request opts into
     * [return_partial_success][google.cloud.networkservices.v1.ListTlsRoutesRequest.return_partial_success]
     * and reading across collections e.g. when attempting to list all resources
     * across all supported locations.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getUnreachable()
    {
        return $this->unreachable;
    }

    /**
     * Unreachable resources. Populated when the request opts into
     * [return_partial_success][google.cloud.networkservices.v1.ListTlsRoutesRequest.return_partial_success]
     * and reading across collections e.g. when attempting to list all resources
     * across all supported locations.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setUnreachable($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->unreachable = $arr;

        return $this;
    }

}

