<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/accounts/v1beta/automaticimprovements.proto

namespace Google\Shopping\Merchant\Accounts\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for the `GetAutomaticImprovements` method.
 *
 * Generated from protobuf message <code>google.shopping.merchant.accounts.v1beta.GetAutomaticImprovementsRequest</code>
 */
class GetAutomaticImprovementsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the automatic improvements.
     * Format: `accounts/{account}/automaticImprovements`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name Required. The resource name of the automatic improvements.
     *                     Format: `accounts/{account}/automaticImprovements`
     *                     Please see {@see AutomaticImprovementsServiceClient::automaticImprovementsName()} for help formatting this field.
     *
     * @return \Google\Shopping\Merchant\Accounts\V1beta\GetAutomaticImprovementsRequest
     *
     * @experimental
     */
    public static function build(string $name): self
    {
        return (new self())
            ->setName($name);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The resource name of the automatic improvements.
     *           Format: `accounts/{account}/automaticImprovements`
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Shopping\Merchant\Accounts\V1Beta\Automaticimprovements::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name of the automatic improvements.
     * Format: `accounts/{account}/automaticImprovements`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The resource name of the automatic improvements.
     * Format: `accounts/{account}/automaticImprovements`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

}

