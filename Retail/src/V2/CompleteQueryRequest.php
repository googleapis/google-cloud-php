<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/retail/v2/completion_service.proto

namespace Google\Cloud\Retail\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Autocomplete parameters.
 *
 * Generated from protobuf message <code>google.cloud.retail.v2.CompleteQueryRequest</code>
 */
class CompleteQueryRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Catalog for which the completion is performed.
     * Full resource name of catalog, such as
     * `projects/&#42;&#47;locations/global/catalogs/default_catalog`.
     *
     * Generated from protobuf field <code>string catalog = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $catalog = '';
    /**
     * Required. The query used to generate suggestions.
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string query = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $query = '';
    /**
     * Recommended field. A unique identifier for tracking visitors. For example,
     * this could be implemented with an HTTP cookie, which should be able to
     * uniquely identify a visitor on a single device. This unique identifier
     * should not change if the visitor logs in or out of the website.
     * The field must be a UTF-8 encoded string with a length limit of 128
     * characters. Otherwise, an INVALID_ARGUMENT error is returned.
     *
     * Generated from protobuf field <code>string visitor_id = 7;</code>
     */
    protected $visitor_id = '';
    /**
     * Note that this field applies for `user-data` dataset only. For requests
     * with `cloud-retail` dataset, setting this field has no effect.
     * The language filters applied to the output suggestions. If set, it should
     * contain the language of the query. If not set, suggestions are returned
     * without considering language restrictions. This is the BCP-47 language
     * code, such as "en-US" or "sr-Latn". For more information, see [Tags for
     * Identifying Languages](https://tools.ietf.org/html/bcp47). The maximum
     * number of language codes is 3.
     *
     * Generated from protobuf field <code>repeated string language_codes = 3;</code>
     */
    private $language_codes;
    /**
     * The device type context for completion suggestions. We recommend that you
     * leave this field empty.
     * It can apply different suggestions on different device types, e.g.
     * `DESKTOP`, `MOBILE`. If it is empty, the suggestions are across all device
     * types.
     * Supported formats:
     * * `UNKNOWN_DEVICE_TYPE`
     * * `DESKTOP`
     * * `MOBILE`
     * * A customized string starts with `OTHER_`, e.g. `OTHER_IPHONE`.
     *
     * Generated from protobuf field <code>string device_type = 4;</code>
     */
    protected $device_type = '';
    /**
     * Determines which dataset to use for fetching completion. "user-data" will
     * use the dataset imported through
     * [CompletionService.ImportCompletionData][google.cloud.retail.v2.CompletionService.ImportCompletionData].
     * `cloud-retail` will use the dataset generated by Cloud Retail based on user
     * events. If left empty, completions will be fetched from the `user-data`
     * dataset.
     * Current supported values:
     * * user-data
     * * cloud-retail:
     *   This option requires enabling auto-learning function first. See
     *   [guidelines](https://cloud.google.com/retail/docs/completion-overview#generated-completion-dataset).
     *
     * Generated from protobuf field <code>string dataset = 6;</code>
     */
    protected $dataset = '';
    /**
     * Completion max suggestions. If left unset or set to 0, then will fallback
     * to the configured value
     * [CompletionConfig.max_suggestions][google.cloud.retail.v2.CompletionConfig.max_suggestions].
     * The maximum allowed max suggestions is 20. If it is set higher, it will be
     * capped by 20.
     *
     * Generated from protobuf field <code>int32 max_suggestions = 5;</code>
     */
    protected $max_suggestions = 0;
    /**
     * If true, attribute suggestions are enabled and provided in the response.
     * This field is only available for the `cloud-retail` dataset.
     *
     * Generated from protobuf field <code>bool enable_attribute_suggestions = 9;</code>
     */
    protected $enable_attribute_suggestions = false;
    /**
     * The entity for customers who run multiple entities, domains, sites, or
     * regions, for example, `Google US`, `Google Ads`, `Waymo`,
     * `google.com`, `youtube.com`, etc.
     * If this is set, it must be an exact match with
     * [UserEvent.entity][google.cloud.retail.v2.UserEvent.entity] to get
     * per-entity autocomplete results. This field will be applied to
     * `completion_results` only. It has no effect on the `attribute_results`.
     * Also, this entity should be limited to 256 characters, if too long, it will
     * be truncated to 256 characters in both generation and serving time, and may
     * lead to mis-match. To ensure it works, please set the entity with string
     * within 256 characters.
     *
     * Generated from protobuf field <code>string entity = 10;</code>
     */
    protected $entity = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $catalog
     *           Required. Catalog for which the completion is performed.
     *           Full resource name of catalog, such as
     *           `projects/&#42;&#47;locations/global/catalogs/default_catalog`.
     *     @type string $query
     *           Required. The query used to generate suggestions.
     *           The maximum number of allowed characters is 255.
     *     @type string $visitor_id
     *           Recommended field. A unique identifier for tracking visitors. For example,
     *           this could be implemented with an HTTP cookie, which should be able to
     *           uniquely identify a visitor on a single device. This unique identifier
     *           should not change if the visitor logs in or out of the website.
     *           The field must be a UTF-8 encoded string with a length limit of 128
     *           characters. Otherwise, an INVALID_ARGUMENT error is returned.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $language_codes
     *           Note that this field applies for `user-data` dataset only. For requests
     *           with `cloud-retail` dataset, setting this field has no effect.
     *           The language filters applied to the output suggestions. If set, it should
     *           contain the language of the query. If not set, suggestions are returned
     *           without considering language restrictions. This is the BCP-47 language
     *           code, such as "en-US" or "sr-Latn". For more information, see [Tags for
     *           Identifying Languages](https://tools.ietf.org/html/bcp47). The maximum
     *           number of language codes is 3.
     *     @type string $device_type
     *           The device type context for completion suggestions. We recommend that you
     *           leave this field empty.
     *           It can apply different suggestions on different device types, e.g.
     *           `DESKTOP`, `MOBILE`. If it is empty, the suggestions are across all device
     *           types.
     *           Supported formats:
     *           * `UNKNOWN_DEVICE_TYPE`
     *           * `DESKTOP`
     *           * `MOBILE`
     *           * A customized string starts with `OTHER_`, e.g. `OTHER_IPHONE`.
     *     @type string $dataset
     *           Determines which dataset to use for fetching completion. "user-data" will
     *           use the dataset imported through
     *           [CompletionService.ImportCompletionData][google.cloud.retail.v2.CompletionService.ImportCompletionData].
     *           `cloud-retail` will use the dataset generated by Cloud Retail based on user
     *           events. If left empty, completions will be fetched from the `user-data`
     *           dataset.
     *           Current supported values:
     *           * user-data
     *           * cloud-retail:
     *             This option requires enabling auto-learning function first. See
     *             [guidelines](https://cloud.google.com/retail/docs/completion-overview#generated-completion-dataset).
     *     @type int $max_suggestions
     *           Completion max suggestions. If left unset or set to 0, then will fallback
     *           to the configured value
     *           [CompletionConfig.max_suggestions][google.cloud.retail.v2.CompletionConfig.max_suggestions].
     *           The maximum allowed max suggestions is 20. If it is set higher, it will be
     *           capped by 20.
     *     @type bool $enable_attribute_suggestions
     *           If true, attribute suggestions are enabled and provided in the response.
     *           This field is only available for the `cloud-retail` dataset.
     *     @type string $entity
     *           The entity for customers who run multiple entities, domains, sites, or
     *           regions, for example, `Google US`, `Google Ads`, `Waymo`,
     *           `google.com`, `youtube.com`, etc.
     *           If this is set, it must be an exact match with
     *           [UserEvent.entity][google.cloud.retail.v2.UserEvent.entity] to get
     *           per-entity autocomplete results. This field will be applied to
     *           `completion_results` only. It has no effect on the `attribute_results`.
     *           Also, this entity should be limited to 256 characters, if too long, it will
     *           be truncated to 256 characters in both generation and serving time, and may
     *           lead to mis-match. To ensure it works, please set the entity with string
     *           within 256 characters.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Retail\V2\CompletionService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Catalog for which the completion is performed.
     * Full resource name of catalog, such as
     * `projects/&#42;&#47;locations/global/catalogs/default_catalog`.
     *
     * Generated from protobuf field <code>string catalog = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * Required. Catalog for which the completion is performed.
     * Full resource name of catalog, such as
     * `projects/&#42;&#47;locations/global/catalogs/default_catalog`.
     *
     * Generated from protobuf field <code>string catalog = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setCatalog($var)
    {
        GPBUtil::checkString($var, True);
        $this->catalog = $var;

        return $this;
    }

    /**
     * Required. The query used to generate suggestions.
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string query = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Required. The query used to generate suggestions.
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string query = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setQuery($var)
    {
        GPBUtil::checkString($var, True);
        $this->query = $var;

        return $this;
    }

    /**
     * Recommended field. A unique identifier for tracking visitors. For example,
     * this could be implemented with an HTTP cookie, which should be able to
     * uniquely identify a visitor on a single device. This unique identifier
     * should not change if the visitor logs in or out of the website.
     * The field must be a UTF-8 encoded string with a length limit of 128
     * characters. Otherwise, an INVALID_ARGUMENT error is returned.
     *
     * Generated from protobuf field <code>string visitor_id = 7;</code>
     * @return string
     */
    public function getVisitorId()
    {
        return $this->visitor_id;
    }

    /**
     * Recommended field. A unique identifier for tracking visitors. For example,
     * this could be implemented with an HTTP cookie, which should be able to
     * uniquely identify a visitor on a single device. This unique identifier
     * should not change if the visitor logs in or out of the website.
     * The field must be a UTF-8 encoded string with a length limit of 128
     * characters. Otherwise, an INVALID_ARGUMENT error is returned.
     *
     * Generated from protobuf field <code>string visitor_id = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setVisitorId($var)
    {
        GPBUtil::checkString($var, True);
        $this->visitor_id = $var;

        return $this;
    }

    /**
     * Note that this field applies for `user-data` dataset only. For requests
     * with `cloud-retail` dataset, setting this field has no effect.
     * The language filters applied to the output suggestions. If set, it should
     * contain the language of the query. If not set, suggestions are returned
     * without considering language restrictions. This is the BCP-47 language
     * code, such as "en-US" or "sr-Latn". For more information, see [Tags for
     * Identifying Languages](https://tools.ietf.org/html/bcp47). The maximum
     * number of language codes is 3.
     *
     * Generated from protobuf field <code>repeated string language_codes = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getLanguageCodes()
    {
        return $this->language_codes;
    }

    /**
     * Note that this field applies for `user-data` dataset only. For requests
     * with `cloud-retail` dataset, setting this field has no effect.
     * The language filters applied to the output suggestions. If set, it should
     * contain the language of the query. If not set, suggestions are returned
     * without considering language restrictions. This is the BCP-47 language
     * code, such as "en-US" or "sr-Latn". For more information, see [Tags for
     * Identifying Languages](https://tools.ietf.org/html/bcp47). The maximum
     * number of language codes is 3.
     *
     * Generated from protobuf field <code>repeated string language_codes = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setLanguageCodes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->language_codes = $arr;

        return $this;
    }

    /**
     * The device type context for completion suggestions. We recommend that you
     * leave this field empty.
     * It can apply different suggestions on different device types, e.g.
     * `DESKTOP`, `MOBILE`. If it is empty, the suggestions are across all device
     * types.
     * Supported formats:
     * * `UNKNOWN_DEVICE_TYPE`
     * * `DESKTOP`
     * * `MOBILE`
     * * A customized string starts with `OTHER_`, e.g. `OTHER_IPHONE`.
     *
     * Generated from protobuf field <code>string device_type = 4;</code>
     * @return string
     */
    public function getDeviceType()
    {
        return $this->device_type;
    }

    /**
     * The device type context for completion suggestions. We recommend that you
     * leave this field empty.
     * It can apply different suggestions on different device types, e.g.
     * `DESKTOP`, `MOBILE`. If it is empty, the suggestions are across all device
     * types.
     * Supported formats:
     * * `UNKNOWN_DEVICE_TYPE`
     * * `DESKTOP`
     * * `MOBILE`
     * * A customized string starts with `OTHER_`, e.g. `OTHER_IPHONE`.
     *
     * Generated from protobuf field <code>string device_type = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setDeviceType($var)
    {
        GPBUtil::checkString($var, True);
        $this->device_type = $var;

        return $this;
    }

    /**
     * Determines which dataset to use for fetching completion. "user-data" will
     * use the dataset imported through
     * [CompletionService.ImportCompletionData][google.cloud.retail.v2.CompletionService.ImportCompletionData].
     * `cloud-retail` will use the dataset generated by Cloud Retail based on user
     * events. If left empty, completions will be fetched from the `user-data`
     * dataset.
     * Current supported values:
     * * user-data
     * * cloud-retail:
     *   This option requires enabling auto-learning function first. See
     *   [guidelines](https://cloud.google.com/retail/docs/completion-overview#generated-completion-dataset).
     *
     * Generated from protobuf field <code>string dataset = 6;</code>
     * @return string
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    /**
     * Determines which dataset to use for fetching completion. "user-data" will
     * use the dataset imported through
     * [CompletionService.ImportCompletionData][google.cloud.retail.v2.CompletionService.ImportCompletionData].
     * `cloud-retail` will use the dataset generated by Cloud Retail based on user
     * events. If left empty, completions will be fetched from the `user-data`
     * dataset.
     * Current supported values:
     * * user-data
     * * cloud-retail:
     *   This option requires enabling auto-learning function first. See
     *   [guidelines](https://cloud.google.com/retail/docs/completion-overview#generated-completion-dataset).
     *
     * Generated from protobuf field <code>string dataset = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setDataset($var)
    {
        GPBUtil::checkString($var, True);
        $this->dataset = $var;

        return $this;
    }

    /**
     * Completion max suggestions. If left unset or set to 0, then will fallback
     * to the configured value
     * [CompletionConfig.max_suggestions][google.cloud.retail.v2.CompletionConfig.max_suggestions].
     * The maximum allowed max suggestions is 20. If it is set higher, it will be
     * capped by 20.
     *
     * Generated from protobuf field <code>int32 max_suggestions = 5;</code>
     * @return int
     */
    public function getMaxSuggestions()
    {
        return $this->max_suggestions;
    }

    /**
     * Completion max suggestions. If left unset or set to 0, then will fallback
     * to the configured value
     * [CompletionConfig.max_suggestions][google.cloud.retail.v2.CompletionConfig.max_suggestions].
     * The maximum allowed max suggestions is 20. If it is set higher, it will be
     * capped by 20.
     *
     * Generated from protobuf field <code>int32 max_suggestions = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setMaxSuggestions($var)
    {
        GPBUtil::checkInt32($var);
        $this->max_suggestions = $var;

        return $this;
    }

    /**
     * If true, attribute suggestions are enabled and provided in the response.
     * This field is only available for the `cloud-retail` dataset.
     *
     * Generated from protobuf field <code>bool enable_attribute_suggestions = 9;</code>
     * @return bool
     */
    public function getEnableAttributeSuggestions()
    {
        return $this->enable_attribute_suggestions;
    }

    /**
     * If true, attribute suggestions are enabled and provided in the response.
     * This field is only available for the `cloud-retail` dataset.
     *
     * Generated from protobuf field <code>bool enable_attribute_suggestions = 9;</code>
     * @param bool $var
     * @return $this
     */
    public function setEnableAttributeSuggestions($var)
    {
        GPBUtil::checkBool($var);
        $this->enable_attribute_suggestions = $var;

        return $this;
    }

    /**
     * The entity for customers who run multiple entities, domains, sites, or
     * regions, for example, `Google US`, `Google Ads`, `Waymo`,
     * `google.com`, `youtube.com`, etc.
     * If this is set, it must be an exact match with
     * [UserEvent.entity][google.cloud.retail.v2.UserEvent.entity] to get
     * per-entity autocomplete results. This field will be applied to
     * `completion_results` only. It has no effect on the `attribute_results`.
     * Also, this entity should be limited to 256 characters, if too long, it will
     * be truncated to 256 characters in both generation and serving time, and may
     * lead to mis-match. To ensure it works, please set the entity with string
     * within 256 characters.
     *
     * Generated from protobuf field <code>string entity = 10;</code>
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * The entity for customers who run multiple entities, domains, sites, or
     * regions, for example, `Google US`, `Google Ads`, `Waymo`,
     * `google.com`, `youtube.com`, etc.
     * If this is set, it must be an exact match with
     * [UserEvent.entity][google.cloud.retail.v2.UserEvent.entity] to get
     * per-entity autocomplete results. This field will be applied to
     * `completion_results` only. It has no effect on the `attribute_results`.
     * Also, this entity should be limited to 256 characters, if too long, it will
     * be truncated to 256 characters in both generation and serving time, and may
     * lead to mis-match. To ensure it works, please set the entity with string
     * within 256 characters.
     *
     * Generated from protobuf field <code>string entity = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setEntity($var)
    {
        GPBUtil::checkString($var, True);
        $this->entity = $var;

        return $this;
    }

}

