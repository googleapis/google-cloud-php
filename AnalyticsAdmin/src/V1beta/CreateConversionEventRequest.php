<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1beta/analytics_admin.proto

namespace Google\Analytics\Admin\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for CreateConversionEvent RPC
 *
 * Generated from protobuf message <code>google.analytics.admin.v1beta.CreateConversionEventRequest</code>
 */
class CreateConversionEventRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The conversion event to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1beta.ConversionEvent conversion_event = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $conversion_event = null;
    /**
     * Required. The resource name of the parent property where this conversion
     * event will be created. Format: properties/123
     *
     * Generated from protobuf field <code>string parent = 2 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';

    /**
     * @param string                                         $parent          Required. The resource name of the parent property where this conversion
     *                                                                        event will be created. Format: properties/123
     *                                                                        Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
     * @param \Google\Analytics\Admin\V1beta\ConversionEvent $conversionEvent Required. The conversion event to create.
     *
     * @return \Google\Analytics\Admin\V1beta\CreateConversionEventRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Analytics\Admin\V1beta\ConversionEvent $conversionEvent): self
    {
        return (new self())
            ->setParent($parent)
            ->setConversionEvent($conversionEvent);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Analytics\Admin\V1beta\ConversionEvent $conversion_event
     *           Required. The conversion event to create.
     *     @type string $parent
     *           Required. The resource name of the parent property where this conversion
     *           event will be created. Format: properties/123
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Analytics\Admin\V1Beta\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The conversion event to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1beta.ConversionEvent conversion_event = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Analytics\Admin\V1beta\ConversionEvent|null
     */
    public function getConversionEvent()
    {
        return $this->conversion_event;
    }

    public function hasConversionEvent()
    {
        return isset($this->conversion_event);
    }

    public function clearConversionEvent()
    {
        unset($this->conversion_event);
    }

    /**
     * Required. The conversion event to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1beta.ConversionEvent conversion_event = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Analytics\Admin\V1beta\ConversionEvent $var
     * @return $this
     */
    public function setConversionEvent($var)
    {
        GPBUtil::checkMessage($var, \Google\Analytics\Admin\V1beta\ConversionEvent::class);
        $this->conversion_event = $var;

        return $this;
    }

    /**
     * Required. The resource name of the parent property where this conversion
     * event will be created. Format: properties/123
     *
     * Generated from protobuf field <code>string parent = 2 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The resource name of the parent property where this conversion
     * event will be created. Format: properties/123
     *
     * Generated from protobuf field <code>string parent = 2 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

}

