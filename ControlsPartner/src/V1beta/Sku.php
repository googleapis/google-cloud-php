<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/cloudcontrolspartner/v1beta/partners.proto

namespace Google\Cloud\CloudControlsPartner\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents the SKU a partner owns inside Google Cloud to sell to customers.
 *
 * Generated from protobuf message <code>google.cloud.cloudcontrolspartner.v1beta.Sku</code>
 */
class Sku extends \Google\Protobuf\Internal\Message
{
    /**
     * Argentum product SKU, that is associated with the partner offerings to
     * customers used by Syntro for billing purposes. SKUs can represent resold
     * Google products or support services.
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    protected $id = '';
    /**
     * Display name of the product identified by the SKU. A partner may want to
     * show partner branded names for their offerings such as local sovereign
     * cloud solutions.
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     */
    protected $display_name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           Argentum product SKU, that is associated with the partner offerings to
     *           customers used by Syntro for billing purposes. SKUs can represent resold
     *           Google products or support services.
     *     @type string $display_name
     *           Display name of the product identified by the SKU. A partner may want to
     *           show partner branded names for their offerings such as local sovereign
     *           cloud solutions.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Cloudcontrolspartner\V1Beta\Partners::initOnce();
        parent::__construct($data);
    }

    /**
     * Argentum product SKU, that is associated with the partner offerings to
     * customers used by Syntro for billing purposes. SKUs can represent resold
     * Google products or support services.
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Argentum product SKU, that is associated with the partner offerings to
     * customers used by Syntro for billing purposes. SKUs can represent resold
     * Google products or support services.
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * Display name of the product identified by the SKU. A partner may want to
     * show partner branded names for their offerings such as local sovereign
     * cloud solutions.
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Display name of the product identified by the SKU. A partner may want to
     * show partner branded names for their offerings such as local sovereign
     * cloud solutions.
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayName($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_name = $var;

        return $this;
    }

}

