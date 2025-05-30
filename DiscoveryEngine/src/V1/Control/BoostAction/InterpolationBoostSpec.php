<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/control.proto

namespace Google\Cloud\DiscoveryEngine\V1\Control\BoostAction;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specification for custom ranking based on customer specified attribute
 * value. It provides more controls for customized ranking than the simple
 * (condition, boost) combination above.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec</code>
 */
class InterpolationBoostSpec extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. The name of the field whose value will be used to determine
     * the boost amount.
     *
     * Generated from protobuf field <code>string field_name = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $field_name = '';
    /**
     * Optional. The attribute type to be used to determine the boost amount.
     * The attribute value can be derived from the field value of the
     * specified field_name. In the case of numerical it is straightforward
     * i.e. attribute_value = numerical_field_value. In the case of freshness
     * however, attribute_value = (time.now() - datetime_field_value).
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.AttributeType attribute_type = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $attribute_type = 0;
    /**
     * Optional. The interpolation type to be applied to connect the control
     * points listed below.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.InterpolationType interpolation_type = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $interpolation_type = 0;
    /**
     * Optional. The control points used to define the curve. The monotonic
     * function (defined through the interpolation_type above) passes through
     * the control points listed here.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.ControlPoint control_points = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $control_points;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $field_name
     *           Optional. The name of the field whose value will be used to determine
     *           the boost amount.
     *     @type int $attribute_type
     *           Optional. The attribute type to be used to determine the boost amount.
     *           The attribute value can be derived from the field value of the
     *           specified field_name. In the case of numerical it is straightforward
     *           i.e. attribute_value = numerical_field_value. In the case of freshness
     *           however, attribute_value = (time.now() - datetime_field_value).
     *     @type int $interpolation_type
     *           Optional. The interpolation type to be applied to connect the control
     *           points listed below.
     *     @type array<\Google\Cloud\DiscoveryEngine\V1\Control\BoostAction\InterpolationBoostSpec\ControlPoint>|\Google\Protobuf\Internal\RepeatedField $control_points
     *           Optional. The control points used to define the curve. The monotonic
     *           function (defined through the interpolation_type above) passes through
     *           the control points listed here.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\Control::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. The name of the field whose value will be used to determine
     * the boost amount.
     *
     * Generated from protobuf field <code>string field_name = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getFieldName()
    {
        return $this->field_name;
    }

    /**
     * Optional. The name of the field whose value will be used to determine
     * the boost amount.
     *
     * Generated from protobuf field <code>string field_name = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setFieldName($var)
    {
        GPBUtil::checkString($var, True);
        $this->field_name = $var;

        return $this;
    }

    /**
     * Optional. The attribute type to be used to determine the boost amount.
     * The attribute value can be derived from the field value of the
     * specified field_name. In the case of numerical it is straightforward
     * i.e. attribute_value = numerical_field_value. In the case of freshness
     * however, attribute_value = (time.now() - datetime_field_value).
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.AttributeType attribute_type = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getAttributeType()
    {
        return $this->attribute_type;
    }

    /**
     * Optional. The attribute type to be used to determine the boost amount.
     * The attribute value can be derived from the field value of the
     * specified field_name. In the case of numerical it is straightforward
     * i.e. attribute_value = numerical_field_value. In the case of freshness
     * however, attribute_value = (time.now() - datetime_field_value).
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.AttributeType attribute_type = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setAttributeType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\DiscoveryEngine\V1\Control\BoostAction\InterpolationBoostSpec\AttributeType::class);
        $this->attribute_type = $var;

        return $this;
    }

    /**
     * Optional. The interpolation type to be applied to connect the control
     * points listed below.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.InterpolationType interpolation_type = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getInterpolationType()
    {
        return $this->interpolation_type;
    }

    /**
     * Optional. The interpolation type to be applied to connect the control
     * points listed below.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.InterpolationType interpolation_type = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setInterpolationType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\DiscoveryEngine\V1\Control\BoostAction\InterpolationBoostSpec\InterpolationType::class);
        $this->interpolation_type = $var;

        return $this;
    }

    /**
     * Optional. The control points used to define the curve. The monotonic
     * function (defined through the interpolation_type above) passes through
     * the control points listed here.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.ControlPoint control_points = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getControlPoints()
    {
        return $this->control_points;
    }

    /**
     * Optional. The control points used to define the curve. The monotonic
     * function (defined through the interpolation_type above) passes through
     * the control points listed here.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Control.BoostAction.InterpolationBoostSpec.ControlPoint control_points = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Cloud\DiscoveryEngine\V1\Control\BoostAction\InterpolationBoostSpec\ControlPoint>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setControlPoints($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\DiscoveryEngine\V1\Control\BoostAction\InterpolationBoostSpec\ControlPoint::class);
        $this->control_points = $arr;

        return $this;
    }

}


