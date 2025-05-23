<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/datasources/v1beta/datasourcetypes.proto

namespace Google\Shopping\Merchant\DataSources\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The supplemental data source for local and online products. After creation,
 * you should make sure to link the supplemental product data source into one or
 * more primary product data sources.
 *
 * Generated from protobuf message <code>google.shopping.merchant.datasources.v1beta.SupplementalProductDataSource</code>
 */
class SupplementalProductDataSource extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Immutable. The feed label that is specified on the data source
     * level.
     * Must be less than or equal to 20 uppercase letters (A-Z), numbers (0-9),
     * and dashes (-).
     * See also [migration to feed
     * labels](https://developers.google.com/shopping-content/guides/products/feed-labels).
     * `feedLabel` and `contentLanguage` must be either both set or unset for data
     * sources with product content type.
     * They must be set for data sources with a [file
     * input][google.shopping.merchant.datasources.v1main.FileInput].
     * The fields must be unset for data sources without [file
     * input][google.shopping.merchant.datasources.v1main.FileInput].
     * If set, the data source will only accept products matching this
     * combination. If unset, the data source will accept produts without that
     * restriction.
     *
     * Generated from protobuf field <code>optional string feed_label = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_behavior) = IMMUTABLE];</code>
     */
    protected $feed_label = null;
    /**
     * Optional. Immutable. The two-letter ISO 639-1 language of the items in the
     * data source.
     * `feedLabel` and `contentLanguage` must be either both set or unset.
     * The fields can only be unset for data sources without file input.
     * If set, the data source will only accept products matching this
     * combination. If unset, the data source will accept produts without that
     * restriction.
     *
     * Generated from protobuf field <code>optional string content_language = 5 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_behavior) = IMMUTABLE];</code>
     */
    protected $content_language = null;
    /**
     * Output only. The (unordered and deduplicated) list of all primary data
     * sources linked to this data source in either default or custom rules.
     * Supplemental data source cannot be deleted before all links are removed.
     *
     * Generated from protobuf field <code>repeated .google.shopping.merchant.datasources.v1beta.DataSourceReference referencing_primary_data_sources = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $referencing_primary_data_sources;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $feed_label
     *           Optional. Immutable. The feed label that is specified on the data source
     *           level.
     *           Must be less than or equal to 20 uppercase letters (A-Z), numbers (0-9),
     *           and dashes (-).
     *           See also [migration to feed
     *           labels](https://developers.google.com/shopping-content/guides/products/feed-labels).
     *           `feedLabel` and `contentLanguage` must be either both set or unset for data
     *           sources with product content type.
     *           They must be set for data sources with a [file
     *           input][google.shopping.merchant.datasources.v1main.FileInput].
     *           The fields must be unset for data sources without [file
     *           input][google.shopping.merchant.datasources.v1main.FileInput].
     *           If set, the data source will only accept products matching this
     *           combination. If unset, the data source will accept produts without that
     *           restriction.
     *     @type string $content_language
     *           Optional. Immutable. The two-letter ISO 639-1 language of the items in the
     *           data source.
     *           `feedLabel` and `contentLanguage` must be either both set or unset.
     *           The fields can only be unset for data sources without file input.
     *           If set, the data source will only accept products matching this
     *           combination. If unset, the data source will accept produts without that
     *           restriction.
     *     @type array<\Google\Shopping\Merchant\DataSources\V1beta\DataSourceReference>|\Google\Protobuf\Internal\RepeatedField $referencing_primary_data_sources
     *           Output only. The (unordered and deduplicated) list of all primary data
     *           sources linked to this data source in either default or custom rules.
     *           Supplemental data source cannot be deleted before all links are removed.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Shopping\Merchant\Datasources\V1Beta\Datasourcetypes::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Immutable. The feed label that is specified on the data source
     * level.
     * Must be less than or equal to 20 uppercase letters (A-Z), numbers (0-9),
     * and dashes (-).
     * See also [migration to feed
     * labels](https://developers.google.com/shopping-content/guides/products/feed-labels).
     * `feedLabel` and `contentLanguage` must be either both set or unset for data
     * sources with product content type.
     * They must be set for data sources with a [file
     * input][google.shopping.merchant.datasources.v1main.FileInput].
     * The fields must be unset for data sources without [file
     * input][google.shopping.merchant.datasources.v1main.FileInput].
     * If set, the data source will only accept products matching this
     * combination. If unset, the data source will accept produts without that
     * restriction.
     *
     * Generated from protobuf field <code>optional string feed_label = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_behavior) = IMMUTABLE];</code>
     * @return string
     */
    public function getFeedLabel()
    {
        return isset($this->feed_label) ? $this->feed_label : '';
    }

    public function hasFeedLabel()
    {
        return isset($this->feed_label);
    }

    public function clearFeedLabel()
    {
        unset($this->feed_label);
    }

    /**
     * Optional. Immutable. The feed label that is specified on the data source
     * level.
     * Must be less than or equal to 20 uppercase letters (A-Z), numbers (0-9),
     * and dashes (-).
     * See also [migration to feed
     * labels](https://developers.google.com/shopping-content/guides/products/feed-labels).
     * `feedLabel` and `contentLanguage` must be either both set or unset for data
     * sources with product content type.
     * They must be set for data sources with a [file
     * input][google.shopping.merchant.datasources.v1main.FileInput].
     * The fields must be unset for data sources without [file
     * input][google.shopping.merchant.datasources.v1main.FileInput].
     * If set, the data source will only accept products matching this
     * combination. If unset, the data source will accept produts without that
     * restriction.
     *
     * Generated from protobuf field <code>optional string feed_label = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_behavior) = IMMUTABLE];</code>
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
     * Optional. Immutable. The two-letter ISO 639-1 language of the items in the
     * data source.
     * `feedLabel` and `contentLanguage` must be either both set or unset.
     * The fields can only be unset for data sources without file input.
     * If set, the data source will only accept products matching this
     * combination. If unset, the data source will accept produts without that
     * restriction.
     *
     * Generated from protobuf field <code>optional string content_language = 5 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_behavior) = IMMUTABLE];</code>
     * @return string
     */
    public function getContentLanguage()
    {
        return isset($this->content_language) ? $this->content_language : '';
    }

    public function hasContentLanguage()
    {
        return isset($this->content_language);
    }

    public function clearContentLanguage()
    {
        unset($this->content_language);
    }

    /**
     * Optional. Immutable. The two-letter ISO 639-1 language of the items in the
     * data source.
     * `feedLabel` and `contentLanguage` must be either both set or unset.
     * The fields can only be unset for data sources without file input.
     * If set, the data source will only accept products matching this
     * combination. If unset, the data source will accept produts without that
     * restriction.
     *
     * Generated from protobuf field <code>optional string content_language = 5 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_behavior) = IMMUTABLE];</code>
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
     * Output only. The (unordered and deduplicated) list of all primary data
     * sources linked to this data source in either default or custom rules.
     * Supplemental data source cannot be deleted before all links are removed.
     *
     * Generated from protobuf field <code>repeated .google.shopping.merchant.datasources.v1beta.DataSourceReference referencing_primary_data_sources = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getReferencingPrimaryDataSources()
    {
        return $this->referencing_primary_data_sources;
    }

    /**
     * Output only. The (unordered and deduplicated) list of all primary data
     * sources linked to this data source in either default or custom rules.
     * Supplemental data source cannot be deleted before all links are removed.
     *
     * Generated from protobuf field <code>repeated .google.shopping.merchant.datasources.v1beta.DataSourceReference referencing_primary_data_sources = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param array<\Google\Shopping\Merchant\DataSources\V1beta\DataSourceReference>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setReferencingPrimaryDataSources($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Shopping\Merchant\DataSources\V1beta\DataSourceReference::class);
        $this->referencing_primary_data_sources = $arr;

        return $this;
    }

}

