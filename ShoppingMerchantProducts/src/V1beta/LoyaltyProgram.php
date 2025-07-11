<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/products/v1beta/products_common.proto

namespace Google\Shopping\Merchant\Products\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A message that represents loyalty program.
 *
 * Generated from protobuf message <code>google.shopping.merchant.products.v1beta.LoyaltyProgram</code>
 */
class LoyaltyProgram extends \Google\Protobuf\Internal\Message
{
    /**
     * The label of the loyalty program. This is an internal label that uniquely
     * identifies the relationship between a business entity and a loyalty
     * program entity. The label must be provided so that the system can associate
     * the assets below (for example, price and points) with a business. The
     * corresponding program must be linked to the Merchant Center account.
     *
     * Generated from protobuf field <code>optional string program_label = 1;</code>
     */
    protected $program_label = null;
    /**
     * The label of the tier within the loyalty program.
     * Must match one of the labels within the program.
     *
     * Generated from protobuf field <code>optional string tier_label = 2;</code>
     */
    protected $tier_label = null;
    /**
     * The price for members of the given tier, that is, the instant discount
     * price. Must be smaller or equal to the regular price.
     *
     * Generated from protobuf field <code>optional .google.shopping.type.Price price = 3;</code>
     */
    protected $price = null;
    /**
     * The cashback that can be used for future purchases.
     *
     * Generated from protobuf field <code>optional .google.shopping.type.Price cashback_for_future_use = 4;</code>
     */
    protected $cashback_for_future_use = null;
    /**
     * The amount of loyalty points earned on a purchase.
     *
     * Generated from protobuf field <code>optional int64 loyalty_points = 5;</code>
     */
    protected $loyalty_points = null;
    /**
     * A date range during which the item is eligible for member price. If not
     * specified, the member price is always applicable. The date range is
     * represented by a pair of ISO 8601 dates separated by a space,
     * comma, or slash.
     *
     * Generated from protobuf field <code>optional .google.type.Interval member_price_effective_date = 6;</code>
     */
    protected $member_price_effective_date = null;
    /**
     * The label of the shipping benefit. If the field has value, this offer has
     * loyalty shipping benefit. If the field value isn't provided, the item is
     * not eligible for loyalty shipping for the given loyalty tier.
     *
     * Generated from protobuf field <code>optional string shipping_label = 7;</code>
     */
    protected $shipping_label = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $program_label
     *           The label of the loyalty program. This is an internal label that uniquely
     *           identifies the relationship between a business entity and a loyalty
     *           program entity. The label must be provided so that the system can associate
     *           the assets below (for example, price and points) with a business. The
     *           corresponding program must be linked to the Merchant Center account.
     *     @type string $tier_label
     *           The label of the tier within the loyalty program.
     *           Must match one of the labels within the program.
     *     @type \Google\Shopping\Type\Price $price
     *           The price for members of the given tier, that is, the instant discount
     *           price. Must be smaller or equal to the regular price.
     *     @type \Google\Shopping\Type\Price $cashback_for_future_use
     *           The cashback that can be used for future purchases.
     *     @type int|string $loyalty_points
     *           The amount of loyalty points earned on a purchase.
     *     @type \Google\Type\Interval $member_price_effective_date
     *           A date range during which the item is eligible for member price. If not
     *           specified, the member price is always applicable. The date range is
     *           represented by a pair of ISO 8601 dates separated by a space,
     *           comma, or slash.
     *     @type string $shipping_label
     *           The label of the shipping benefit. If the field has value, this offer has
     *           loyalty shipping benefit. If the field value isn't provided, the item is
     *           not eligible for loyalty shipping for the given loyalty tier.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Shopping\Merchant\Products\V1Beta\ProductsCommon::initOnce();
        parent::__construct($data);
    }

    /**
     * The label of the loyalty program. This is an internal label that uniquely
     * identifies the relationship between a business entity and a loyalty
     * program entity. The label must be provided so that the system can associate
     * the assets below (for example, price and points) with a business. The
     * corresponding program must be linked to the Merchant Center account.
     *
     * Generated from protobuf field <code>optional string program_label = 1;</code>
     * @return string
     */
    public function getProgramLabel()
    {
        return isset($this->program_label) ? $this->program_label : '';
    }

    public function hasProgramLabel()
    {
        return isset($this->program_label);
    }

    public function clearProgramLabel()
    {
        unset($this->program_label);
    }

    /**
     * The label of the loyalty program. This is an internal label that uniquely
     * identifies the relationship between a business entity and a loyalty
     * program entity. The label must be provided so that the system can associate
     * the assets below (for example, price and points) with a business. The
     * corresponding program must be linked to the Merchant Center account.
     *
     * Generated from protobuf field <code>optional string program_label = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setProgramLabel($var)
    {
        GPBUtil::checkString($var, True);
        $this->program_label = $var;

        return $this;
    }

    /**
     * The label of the tier within the loyalty program.
     * Must match one of the labels within the program.
     *
     * Generated from protobuf field <code>optional string tier_label = 2;</code>
     * @return string
     */
    public function getTierLabel()
    {
        return isset($this->tier_label) ? $this->tier_label : '';
    }

    public function hasTierLabel()
    {
        return isset($this->tier_label);
    }

    public function clearTierLabel()
    {
        unset($this->tier_label);
    }

    /**
     * The label of the tier within the loyalty program.
     * Must match one of the labels within the program.
     *
     * Generated from protobuf field <code>optional string tier_label = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setTierLabel($var)
    {
        GPBUtil::checkString($var, True);
        $this->tier_label = $var;

        return $this;
    }

    /**
     * The price for members of the given tier, that is, the instant discount
     * price. Must be smaller or equal to the regular price.
     *
     * Generated from protobuf field <code>optional .google.shopping.type.Price price = 3;</code>
     * @return \Google\Shopping\Type\Price|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function hasPrice()
    {
        return isset($this->price);
    }

    public function clearPrice()
    {
        unset($this->price);
    }

    /**
     * The price for members of the given tier, that is, the instant discount
     * price. Must be smaller or equal to the regular price.
     *
     * Generated from protobuf field <code>optional .google.shopping.type.Price price = 3;</code>
     * @param \Google\Shopping\Type\Price $var
     * @return $this
     */
    public function setPrice($var)
    {
        GPBUtil::checkMessage($var, \Google\Shopping\Type\Price::class);
        $this->price = $var;

        return $this;
    }

    /**
     * The cashback that can be used for future purchases.
     *
     * Generated from protobuf field <code>optional .google.shopping.type.Price cashback_for_future_use = 4;</code>
     * @return \Google\Shopping\Type\Price|null
     */
    public function getCashbackForFutureUse()
    {
        return $this->cashback_for_future_use;
    }

    public function hasCashbackForFutureUse()
    {
        return isset($this->cashback_for_future_use);
    }

    public function clearCashbackForFutureUse()
    {
        unset($this->cashback_for_future_use);
    }

    /**
     * The cashback that can be used for future purchases.
     *
     * Generated from protobuf field <code>optional .google.shopping.type.Price cashback_for_future_use = 4;</code>
     * @param \Google\Shopping\Type\Price $var
     * @return $this
     */
    public function setCashbackForFutureUse($var)
    {
        GPBUtil::checkMessage($var, \Google\Shopping\Type\Price::class);
        $this->cashback_for_future_use = $var;

        return $this;
    }

    /**
     * The amount of loyalty points earned on a purchase.
     *
     * Generated from protobuf field <code>optional int64 loyalty_points = 5;</code>
     * @return int|string
     */
    public function getLoyaltyPoints()
    {
        return isset($this->loyalty_points) ? $this->loyalty_points : 0;
    }

    public function hasLoyaltyPoints()
    {
        return isset($this->loyalty_points);
    }

    public function clearLoyaltyPoints()
    {
        unset($this->loyalty_points);
    }

    /**
     * The amount of loyalty points earned on a purchase.
     *
     * Generated from protobuf field <code>optional int64 loyalty_points = 5;</code>
     * @param int|string $var
     * @return $this
     */
    public function setLoyaltyPoints($var)
    {
        GPBUtil::checkInt64($var);
        $this->loyalty_points = $var;

        return $this;
    }

    /**
     * A date range during which the item is eligible for member price. If not
     * specified, the member price is always applicable. The date range is
     * represented by a pair of ISO 8601 dates separated by a space,
     * comma, or slash.
     *
     * Generated from protobuf field <code>optional .google.type.Interval member_price_effective_date = 6;</code>
     * @return \Google\Type\Interval|null
     */
    public function getMemberPriceEffectiveDate()
    {
        return $this->member_price_effective_date;
    }

    public function hasMemberPriceEffectiveDate()
    {
        return isset($this->member_price_effective_date);
    }

    public function clearMemberPriceEffectiveDate()
    {
        unset($this->member_price_effective_date);
    }

    /**
     * A date range during which the item is eligible for member price. If not
     * specified, the member price is always applicable. The date range is
     * represented by a pair of ISO 8601 dates separated by a space,
     * comma, or slash.
     *
     * Generated from protobuf field <code>optional .google.type.Interval member_price_effective_date = 6;</code>
     * @param \Google\Type\Interval $var
     * @return $this
     */
    public function setMemberPriceEffectiveDate($var)
    {
        GPBUtil::checkMessage($var, \Google\Type\Interval::class);
        $this->member_price_effective_date = $var;

        return $this;
    }

    /**
     * The label of the shipping benefit. If the field has value, this offer has
     * loyalty shipping benefit. If the field value isn't provided, the item is
     * not eligible for loyalty shipping for the given loyalty tier.
     *
     * Generated from protobuf field <code>optional string shipping_label = 7;</code>
     * @return string
     */
    public function getShippingLabel()
    {
        return isset($this->shipping_label) ? $this->shipping_label : '';
    }

    public function hasShippingLabel()
    {
        return isset($this->shipping_label);
    }

    public function clearShippingLabel()
    {
        unset($this->shipping_label);
    }

    /**
     * The label of the shipping benefit. If the field has value, this offer has
     * loyalty shipping benefit. If the field value isn't provided, the item is
     * not eligible for loyalty shipping for the given loyalty tier.
     *
     * Generated from protobuf field <code>optional string shipping_label = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setShippingLabel($var)
    {
        GPBUtil::checkString($var, True);
        $this->shipping_label = $var;

        return $this;
    }

}

