<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/recommendationengine/v1beta1/user_event_service.proto

namespace Google\Cloud\RecommendationEngine\V1beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for CollectUserEvent method.
 *
 * Generated from protobuf message <code>google.cloud.recommendationengine.v1beta1.CollectUserEventRequest</code>
 */
class CollectUserEventRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The parent eventStore name, such as
     * `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. URL encoded UserEvent proto.
     *
     * Generated from protobuf field <code>string user_event = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $user_event = '';
    /**
     * Optional. The url including cgi-parameters but excluding the hash fragment.
     * The URL must be truncated to 1.5K bytes to conservatively be under the 2K
     * bytes. This is often more useful than the referer url, because many
     * browsers only send the domain for 3rd party requests.
     *
     * Generated from protobuf field <code>string uri = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $uri = '';
    /**
     * Optional. The event timestamp in milliseconds. This prevents browser
     * caching of otherwise identical get requests. The name is abbreviated to
     * reduce the payload bytes.
     *
     * Generated from protobuf field <code>int64 ets = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $ets = 0;

    /**
     * @param string $parent    Required. The parent eventStore name, such as
     *                          `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`. Please see
     *                          {@see UserEventServiceClient::eventStoreName()} for help formatting this field.
     * @param string $userEvent Required. URL encoded UserEvent proto.
     * @param string $uri       Optional. The url including cgi-parameters but excluding the hash fragment.
     *                          The URL must be truncated to 1.5K bytes to conservatively be under the 2K
     *                          bytes. This is often more useful than the referer url, because many
     *                          browsers only send the domain for 3rd party requests.
     * @param int    $ets       Optional. The event timestamp in milliseconds. This prevents browser
     *                          caching of otherwise identical get requests. The name is abbreviated to
     *                          reduce the payload bytes.
     *
     * @return \Google\Cloud\RecommendationEngine\V1beta1\CollectUserEventRequest
     *
     * @experimental
     */
    public static function build(string $parent, string $userEvent, string $uri, int $ets): self
    {
        return (new self())
            ->setParent($parent)
            ->setUserEvent($userEvent)
            ->setUri($uri)
            ->setEts($ets);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The parent eventStore name, such as
     *           `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`.
     *     @type string $user_event
     *           Required. URL encoded UserEvent proto.
     *     @type string $uri
     *           Optional. The url including cgi-parameters but excluding the hash fragment.
     *           The URL must be truncated to 1.5K bytes to conservatively be under the 2K
     *           bytes. This is often more useful than the referer url, because many
     *           browsers only send the domain for 3rd party requests.
     *     @type int|string $ets
     *           Optional. The event timestamp in milliseconds. This prevents browser
     *           caching of otherwise identical get requests. The name is abbreviated to
     *           reduce the payload bytes.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Recommendationengine\V1Beta1\UserEventService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The parent eventStore name, such as
     * `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The parent eventStore name, such as
     * `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Required. URL encoded UserEvent proto.
     *
     * Generated from protobuf field <code>string user_event = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getUserEvent()
    {
        return $this->user_event;
    }

    /**
     * Required. URL encoded UserEvent proto.
     *
     * Generated from protobuf field <code>string user_event = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setUserEvent($var)
    {
        GPBUtil::checkString($var, True);
        $this->user_event = $var;

        return $this;
    }

    /**
     * Optional. The url including cgi-parameters but excluding the hash fragment.
     * The URL must be truncated to 1.5K bytes to conservatively be under the 2K
     * bytes. This is often more useful than the referer url, because many
     * browsers only send the domain for 3rd party requests.
     *
     * Generated from protobuf field <code>string uri = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Optional. The url including cgi-parameters but excluding the hash fragment.
     * The URL must be truncated to 1.5K bytes to conservatively be under the 2K
     * bytes. This is often more useful than the referer url, because many
     * browsers only send the domain for 3rd party requests.
     *
     * Generated from protobuf field <code>string uri = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->uri = $var;

        return $this;
    }

    /**
     * Optional. The event timestamp in milliseconds. This prevents browser
     * caching of otherwise identical get requests. The name is abbreviated to
     * reduce the payload bytes.
     *
     * Generated from protobuf field <code>int64 ets = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int|string
     */
    public function getEts()
    {
        return $this->ets;
    }

    /**
     * Optional. The event timestamp in milliseconds. This prevents browser
     * caching of otherwise identical get requests. The name is abbreviated to
     * reduce the payload bytes.
     *
     * Generated from protobuf field <code>int64 ets = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int|string $var
     * @return $this
     */
    public function setEts($var)
    {
        GPBUtil::checkInt64($var);
        $this->ets = $var;

        return $this;
    }

}

