<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/modelarmor/v1/service.proto

namespace Google\Cloud\ModelArmor\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Message for Updating a Floor Setting
 *
 * Generated from protobuf message <code>google.cloud.modelarmor.v1.UpdateFloorSettingRequest</code>
 */
class UpdateFloorSettingRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The floor setting being updated.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1.FloorSetting floor_setting = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $floor_setting = null;
    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * FloorSetting resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask. If the
     * user does not provide a mask then all fields will be overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $update_mask = null;

    /**
     * @param \Google\Cloud\ModelArmor\V1\FloorSetting $floorSetting Required. The floor setting being updated.
     * @param \Google\Protobuf\FieldMask               $updateMask   Optional. Field mask is used to specify the fields to be overwritten in the
     *                                                               FloorSetting resource by the update.
     *                                                               The fields specified in the update_mask are relative to the resource, not
     *                                                               the full request. A field will be overwritten if it is in the mask. If the
     *                                                               user does not provide a mask then all fields will be overwritten.
     *
     * @return \Google\Cloud\ModelArmor\V1\UpdateFloorSettingRequest
     *
     * @experimental
     */
    public static function build(\Google\Cloud\ModelArmor\V1\FloorSetting $floorSetting, \Google\Protobuf\FieldMask $updateMask): self
    {
        return (new self())
            ->setFloorSetting($floorSetting)
            ->setUpdateMask($updateMask);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\ModelArmor\V1\FloorSetting $floor_setting
     *           Required. The floor setting being updated.
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Optional. Field mask is used to specify the fields to be overwritten in the
     *           FloorSetting resource by the update.
     *           The fields specified in the update_mask are relative to the resource, not
     *           the full request. A field will be overwritten if it is in the mask. If the
     *           user does not provide a mask then all fields will be overwritten.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Modelarmor\V1\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The floor setting being updated.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1.FloorSetting floor_setting = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\ModelArmor\V1\FloorSetting|null
     */
    public function getFloorSetting()
    {
        return $this->floor_setting;
    }

    public function hasFloorSetting()
    {
        return isset($this->floor_setting);
    }

    public function clearFloorSetting()
    {
        unset($this->floor_setting);
    }

    /**
     * Required. The floor setting being updated.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1.FloorSetting floor_setting = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\ModelArmor\V1\FloorSetting $var
     * @return $this
     */
    public function setFloorSetting($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\ModelArmor\V1\FloorSetting::class);
        $this->floor_setting = $var;

        return $this;
    }

    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * FloorSetting resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask. If the
     * user does not provide a mask then all fields will be overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }

    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }

    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }

    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * FloorSetting resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask. If the
     * user does not provide a mask then all fields will be overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;

        return $this;
    }

}

