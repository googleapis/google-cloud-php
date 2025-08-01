<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/products/v1beta/products.proto

namespace Google\Shopping\Merchant\Products\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The processed product, built from multiple [product
 * inputs][google.shopping.merchant.products.v1main.ProductInput]
 * after applying rules and supplemental data sources. This processed product
 * matches what is shown in your Merchant Center account. Each product is built
 * from exactly one primary data source product input, and multiple supplemental
 * data source inputs. After inserting, updating, or deleting a product input,
 * it may take several minutes before the updated processed product can be
 * retrieved.
 * All fields in the processed product and its sub-messages match the name of
 * their corresponding attribute in the [Product data
 * specification](https://support.google.com/merchants/answer/7052112) with some
 * exceptions.
 *
 * Generated from protobuf message <code>google.shopping.merchant.products.v1beta.Product</code>
 */
class Product extends \Google\Protobuf\Internal\Message
{
    /**
     * The name of the product.
     * Format:
     * `accounts/{account}/products/{product}` where the last
     * section `product` consists of 4 parts:
     * `channel~content_language~feed_label~offer_id`
     * example for product name is `accounts/123/products/online~en~US~sku123`
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';
    /**
     * Output only. The
     * [channel](https://support.google.com/merchants/answer/7361332) of the
     * product.
     *
     * Generated from protobuf field <code>.google.shopping.type.Channel.ChannelEnum channel = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $channel = 0;
    /**
     * Output only. Your unique identifier for the product. This is the same for
     * the product input and processed product. Leading and trailing whitespaces
     * are stripped and multiple whitespaces are replaced by a single whitespace
     * upon submission. See the [product data
     * specification](https://support.google.com/merchants/answer/188494#id) for
     * details.
     *
     * Generated from protobuf field <code>string offer_id = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $offer_id = '';
    /**
     * Output only. The two-letter [ISO
     * 639-1](http://en.wikipedia.org/wiki/ISO_639-1) language code for the
     * product.
     *
     * Generated from protobuf field <code>string content_language = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $content_language = '';
    /**
     * Output only. The feed label lets you categorize and identify your products.
     * The maximum allowed characters is 20 and the supported characters are`A-Z`,
     * `0-9`, hyphen and underscore. The feed label must not include any spaces.
     * For more information, see [Using feed
     * labels](//support.google.com/merchants/answer/14994087)
     *
     * Generated from protobuf field <code>string feed_label = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $feed_label = '';
    /**
     * Output only. The primary data source of the product.
     *
     * Generated from protobuf field <code>string data_source = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $data_source = '';
    /**
     * Output only. Represents the existing version (freshness) of the product,
     * which can be used to preserve the right order when multiple updates are
     * done at the same time.
     * If set, the insertion is prevented when version number is lower than
     * the current version number of the existing product. Re-insertion (for
     * example, product refresh after 30 days) can be performed with the current
     * `version_number`.
     * Only supported for insertions into primary data sources.
     * If the operation is prevented, the aborted exception will be
     * thrown.
     *
     * Generated from protobuf field <code>optional int64 version_number = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $version_number = null;
    /**
     * Output only. A list of product attributes.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.Attributes attributes = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $attributes = null;
    /**
     * Output only. A list of custom (merchant-provided) attributes. It can also
     * be used to submit any attribute of the data specification in its generic
     * form (for example,
     * `{ "name": "size type", "value": "regular" }`).
     * This is useful for submitting attributes not explicitly exposed by the
     * API, such as additional attributes used for Buy on Google.
     *
     * Generated from protobuf field <code>repeated .google.shopping.type.CustomAttribute custom_attributes = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $custom_attributes;
    /**
     * Output only. The status of a product, data validation issues, that is,
     * information about a product computed asynchronously.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.ProductStatus product_status = 10 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $product_status = null;
    /**
     * Output only. The automated discounts information for the product.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.AutomatedDiscounts automated_discounts = 12 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $automated_discounts = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           The name of the product.
     *           Format:
     *           `accounts/{account}/products/{product}` where the last
     *           section `product` consists of 4 parts:
     *           `channel~content_language~feed_label~offer_id`
     *           example for product name is `accounts/123/products/online~en~US~sku123`
     *     @type int $channel
     *           Output only. The
     *           [channel](https://support.google.com/merchants/answer/7361332) of the
     *           product.
     *     @type string $offer_id
     *           Output only. Your unique identifier for the product. This is the same for
     *           the product input and processed product. Leading and trailing whitespaces
     *           are stripped and multiple whitespaces are replaced by a single whitespace
     *           upon submission. See the [product data
     *           specification](https://support.google.com/merchants/answer/188494#id) for
     *           details.
     *     @type string $content_language
     *           Output only. The two-letter [ISO
     *           639-1](http://en.wikipedia.org/wiki/ISO_639-1) language code for the
     *           product.
     *     @type string $feed_label
     *           Output only. The feed label lets you categorize and identify your products.
     *           The maximum allowed characters is 20 and the supported characters are`A-Z`,
     *           `0-9`, hyphen and underscore. The feed label must not include any spaces.
     *           For more information, see [Using feed
     *           labels](//support.google.com/merchants/answer/14994087)
     *     @type string $data_source
     *           Output only. The primary data source of the product.
     *     @type int|string $version_number
     *           Output only. Represents the existing version (freshness) of the product,
     *           which can be used to preserve the right order when multiple updates are
     *           done at the same time.
     *           If set, the insertion is prevented when version number is lower than
     *           the current version number of the existing product. Re-insertion (for
     *           example, product refresh after 30 days) can be performed with the current
     *           `version_number`.
     *           Only supported for insertions into primary data sources.
     *           If the operation is prevented, the aborted exception will be
     *           thrown.
     *     @type \Google\Shopping\Merchant\Products\V1beta\Attributes $attributes
     *           Output only. A list of product attributes.
     *     @type array<\Google\Shopping\Type\CustomAttribute>|\Google\Protobuf\Internal\RepeatedField $custom_attributes
     *           Output only. A list of custom (merchant-provided) attributes. It can also
     *           be used to submit any attribute of the data specification in its generic
     *           form (for example,
     *           `{ "name": "size type", "value": "regular" }`).
     *           This is useful for submitting attributes not explicitly exposed by the
     *           API, such as additional attributes used for Buy on Google.
     *     @type \Google\Shopping\Merchant\Products\V1beta\ProductStatus $product_status
     *           Output only. The status of a product, data validation issues, that is,
     *           information about a product computed asynchronously.
     *     @type \Google\Shopping\Merchant\Products\V1beta\AutomatedDiscounts $automated_discounts
     *           Output only. The automated discounts information for the product.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Shopping\Merchant\Products\V1Beta\Products::initOnce();
        parent::__construct($data);
    }

    /**
     * The name of the product.
     * Format:
     * `accounts/{account}/products/{product}` where the last
     * section `product` consists of 4 parts:
     * `channel~content_language~feed_label~offer_id`
     * example for product name is `accounts/123/products/online~en~US~sku123`
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The name of the product.
     * Format:
     * `accounts/{account}/products/{product}` where the last
     * section `product` consists of 4 parts:
     * `channel~content_language~feed_label~offer_id`
     * example for product name is `accounts/123/products/online~en~US~sku123`
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Output only. The
     * [channel](https://support.google.com/merchants/answer/7361332) of the
     * product.
     *
     * Generated from protobuf field <code>.google.shopping.type.Channel.ChannelEnum channel = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Output only. The
     * [channel](https://support.google.com/merchants/answer/7361332) of the
     * product.
     *
     * Generated from protobuf field <code>.google.shopping.type.Channel.ChannelEnum channel = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setChannel($var)
    {
        GPBUtil::checkEnum($var, \Google\Shopping\Type\Channel\ChannelEnum::class);
        $this->channel = $var;

        return $this;
    }

    /**
     * Output only. Your unique identifier for the product. This is the same for
     * the product input and processed product. Leading and trailing whitespaces
     * are stripped and multiple whitespaces are replaced by a single whitespace
     * upon submission. See the [product data
     * specification](https://support.google.com/merchants/answer/188494#id) for
     * details.
     *
     * Generated from protobuf field <code>string offer_id = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getOfferId()
    {
        return $this->offer_id;
    }

    /**
     * Output only. Your unique identifier for the product. This is the same for
     * the product input and processed product. Leading and trailing whitespaces
     * are stripped and multiple whitespaces are replaced by a single whitespace
     * upon submission. See the [product data
     * specification](https://support.google.com/merchants/answer/188494#id) for
     * details.
     *
     * Generated from protobuf field <code>string offer_id = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setOfferId($var)
    {
        GPBUtil::checkString($var, True);
        $this->offer_id = $var;

        return $this;
    }

    /**
     * Output only. The two-letter [ISO
     * 639-1](http://en.wikipedia.org/wiki/ISO_639-1) language code for the
     * product.
     *
     * Generated from protobuf field <code>string content_language = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getContentLanguage()
    {
        return $this->content_language;
    }

    /**
     * Output only. The two-letter [ISO
     * 639-1](http://en.wikipedia.org/wiki/ISO_639-1) language code for the
     * product.
     *
     * Generated from protobuf field <code>string content_language = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setContentLanguage($var)
    {
        GPBUtil::checkString($var, True);
        $this->content_language = $var;

        return $this;
    }

    /**
     * Output only. The feed label lets you categorize and identify your products.
     * The maximum allowed characters is 20 and the supported characters are`A-Z`,
     * `0-9`, hyphen and underscore. The feed label must not include any spaces.
     * For more information, see [Using feed
     * labels](//support.google.com/merchants/answer/14994087)
     *
     * Generated from protobuf field <code>string feed_label = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getFeedLabel()
    {
        return $this->feed_label;
    }

    /**
     * Output only. The feed label lets you categorize and identify your products.
     * The maximum allowed characters is 20 and the supported characters are`A-Z`,
     * `0-9`, hyphen and underscore. The feed label must not include any spaces.
     * For more information, see [Using feed
     * labels](//support.google.com/merchants/answer/14994087)
     *
     * Generated from protobuf field <code>string feed_label = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setFeedLabel($var)
    {
        GPBUtil::checkString($var, True);
        $this->feed_label = $var;

        return $this;
    }

    /**
     * Output only. The primary data source of the product.
     *
     * Generated from protobuf field <code>string data_source = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getDataSource()
    {
        return $this->data_source;
    }

    /**
     * Output only. The primary data source of the product.
     *
     * Generated from protobuf field <code>string data_source = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setDataSource($var)
    {
        GPBUtil::checkString($var, True);
        $this->data_source = $var;

        return $this;
    }

    /**
     * Output only. Represents the existing version (freshness) of the product,
     * which can be used to preserve the right order when multiple updates are
     * done at the same time.
     * If set, the insertion is prevented when version number is lower than
     * the current version number of the existing product. Re-insertion (for
     * example, product refresh after 30 days) can be performed with the current
     * `version_number`.
     * Only supported for insertions into primary data sources.
     * If the operation is prevented, the aborted exception will be
     * thrown.
     *
     * Generated from protobuf field <code>optional int64 version_number = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int|string
     */
    public function getVersionNumber()
    {
        return isset($this->version_number) ? $this->version_number : 0;
    }

    public function hasVersionNumber()
    {
        return isset($this->version_number);
    }

    public function clearVersionNumber()
    {
        unset($this->version_number);
    }

    /**
     * Output only. Represents the existing version (freshness) of the product,
     * which can be used to preserve the right order when multiple updates are
     * done at the same time.
     * If set, the insertion is prevented when version number is lower than
     * the current version number of the existing product. Re-insertion (for
     * example, product refresh after 30 days) can be performed with the current
     * `version_number`.
     * Only supported for insertions into primary data sources.
     * If the operation is prevented, the aborted exception will be
     * thrown.
     *
     * Generated from protobuf field <code>optional int64 version_number = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int|string $var
     * @return $this
     */
    public function setVersionNumber($var)
    {
        GPBUtil::checkInt64($var);
        $this->version_number = $var;

        return $this;
    }

    /**
     * Output only. A list of product attributes.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.Attributes attributes = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Shopping\Merchant\Products\V1beta\Attributes|null
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function hasAttributes()
    {
        return isset($this->attributes);
    }

    public function clearAttributes()
    {
        unset($this->attributes);
    }

    /**
     * Output only. A list of product attributes.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.Attributes attributes = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Shopping\Merchant\Products\V1beta\Attributes $var
     * @return $this
     */
    public function setAttributes($var)
    {
        GPBUtil::checkMessage($var, \Google\Shopping\Merchant\Products\V1beta\Attributes::class);
        $this->attributes = $var;

        return $this;
    }

    /**
     * Output only. A list of custom (merchant-provided) attributes. It can also
     * be used to submit any attribute of the data specification in its generic
     * form (for example,
     * `{ "name": "size type", "value": "regular" }`).
     * This is useful for submitting attributes not explicitly exposed by the
     * API, such as additional attributes used for Buy on Google.
     *
     * Generated from protobuf field <code>repeated .google.shopping.type.CustomAttribute custom_attributes = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getCustomAttributes()
    {
        return $this->custom_attributes;
    }

    /**
     * Output only. A list of custom (merchant-provided) attributes. It can also
     * be used to submit any attribute of the data specification in its generic
     * form (for example,
     * `{ "name": "size type", "value": "regular" }`).
     * This is useful for submitting attributes not explicitly exposed by the
     * API, such as additional attributes used for Buy on Google.
     *
     * Generated from protobuf field <code>repeated .google.shopping.type.CustomAttribute custom_attributes = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param array<\Google\Shopping\Type\CustomAttribute>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setCustomAttributes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Shopping\Type\CustomAttribute::class);
        $this->custom_attributes = $arr;

        return $this;
    }

    /**
     * Output only. The status of a product, data validation issues, that is,
     * information about a product computed asynchronously.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.ProductStatus product_status = 10 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Shopping\Merchant\Products\V1beta\ProductStatus|null
     */
    public function getProductStatus()
    {
        return $this->product_status;
    }

    public function hasProductStatus()
    {
        return isset($this->product_status);
    }

    public function clearProductStatus()
    {
        unset($this->product_status);
    }

    /**
     * Output only. The status of a product, data validation issues, that is,
     * information about a product computed asynchronously.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.ProductStatus product_status = 10 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Shopping\Merchant\Products\V1beta\ProductStatus $var
     * @return $this
     */
    public function setProductStatus($var)
    {
        GPBUtil::checkMessage($var, \Google\Shopping\Merchant\Products\V1beta\ProductStatus::class);
        $this->product_status = $var;

        return $this;
    }

    /**
     * Output only. The automated discounts information for the product.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.AutomatedDiscounts automated_discounts = 12 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Shopping\Merchant\Products\V1beta\AutomatedDiscounts|null
     */
    public function getAutomatedDiscounts()
    {
        return $this->automated_discounts;
    }

    public function hasAutomatedDiscounts()
    {
        return isset($this->automated_discounts);
    }

    public function clearAutomatedDiscounts()
    {
        unset($this->automated_discounts);
    }

    /**
     * Output only. The automated discounts information for the product.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.products.v1beta.AutomatedDiscounts automated_discounts = 12 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Shopping\Merchant\Products\V1beta\AutomatedDiscounts $var
     * @return $this
     */
    public function setAutomatedDiscounts($var)
    {
        GPBUtil::checkMessage($var, \Google\Shopping\Merchant\Products\V1beta\AutomatedDiscounts::class);
        $this->automated_discounts = $var;

        return $this;
    }

}

