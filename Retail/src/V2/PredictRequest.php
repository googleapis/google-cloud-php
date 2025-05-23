<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/retail/v2/prediction_service.proto

namespace Google\Cloud\Retail\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for Predict method.
 *
 * Generated from protobuf message <code>google.cloud.retail.v2.PredictRequest</code>
 */
class PredictRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Full resource name of the format:
     * `{placement=projects/&#42;&#47;locations/global/catalogs/default_catalog/servingConfigs/&#42;}`
     * or
     * `{placement=projects/&#42;&#47;locations/global/catalogs/default_catalog/placements/&#42;}`.
     * We recommend using the `servingConfigs` resource. `placements` is a legacy
     * resource.
     * The ID of the Recommendations AI serving config or placement.
     * Before you can request predictions from your model, you must create at
     * least one serving config or placement for it. For more information, see
     * [Manage serving configs]
     * (https://cloud.google.com/retail/docs/manage-configs).
     * The full list of available serving configs can be seen at
     * https://console.cloud.google.com/ai/retail/catalogs/default_catalog/configs
     *
     * Generated from protobuf field <code>string placement = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $placement = '';
    /**
     * Required. Context about the user, what they are looking at and what action
     * they took to trigger the predict request. Note that this user event detail
     * won't be ingested to userEvent logs. Thus, a separate userEvent write
     * request is required for event logging.
     * Don't set
     * [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id] or
     * [UserInfo.user_id][google.cloud.retail.v2.UserInfo.user_id] to the same
     * fixed ID for different users. If you are trying to receive non-personalized
     * recommendations (not recommended; this can negatively impact model
     * performance), instead set
     * [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id] to a
     * random unique ID and leave
     * [UserInfo.user_id][google.cloud.retail.v2.UserInfo.user_id] unset.
     *
     * Generated from protobuf field <code>.google.cloud.retail.v2.UserEvent user_event = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $user_event = null;
    /**
     * Maximum number of results to return. Set this property to the number of
     * prediction results needed. If zero, the service will choose a reasonable
     * default. The maximum allowed value is 100. Values above 100 will be coerced
     * to 100.
     *
     * Generated from protobuf field <code>int32 page_size = 3;</code>
     */
    protected $page_size = 0;
    /**
     * This field is not used; leave it unset.
     *
     * Generated from protobuf field <code>string page_token = 4 [deprecated = true];</code>
     * @deprecated
     */
    protected $page_token = '';
    /**
     * Filter for restricting prediction results with a length limit of 5,000
     * characters. Accepts values for tags and the `filterOutOfStockItems` flag.
     *  * Tag expressions. Restricts predictions to products that match all of the
     *    specified tags. Boolean operators `OR` and `NOT` are supported if the
     *    expression is enclosed in parentheses, and must be separated from the
     *    tag values by a space. `-"tagA"` is also supported and is equivalent to
     *    `NOT "tagA"`. Tag values must be double quoted UTF-8 encoded strings
     *    with a size limit of 1,000 characters.
     *    Note: "Recently viewed" models don't support tag filtering at the
     *    moment.
     *  * filterOutOfStockItems. Restricts predictions to products that do not
     *  have a
     *    stockState value of OUT_OF_STOCK.
     * Examples:
     *  * tag=("Red" OR "Blue") tag="New-Arrival" tag=(NOT "promotional")
     *  * filterOutOfStockItems  tag=(-"promotional")
     *  * filterOutOfStockItems
     * If your filter blocks all prediction results, the API will return *no*
     * results. If instead you want empty result sets to return generic
     * (unfiltered) popular products, set `strictFiltering` to False in
     * `PredictRequest.params`. Note that the API will never return items with
     * storageStatus of "EXPIRED" or "DELETED" regardless of filter choices.
     * If `filterSyntaxV2` is set to true under the `params` field, then
     * attribute-based expressions are expected instead of the above described
     * tag-based syntax. Examples:
     *  * (colors: ANY("Red", "Blue")) AND NOT (categories: ANY("Phones"))
     *  * (availability: ANY("IN_STOCK")) AND
     *    (colors: ANY("Red") OR categories: ANY("Phones"))
     * For more information, see
     * [Filter recommendations](https://cloud.google.com/retail/docs/filter-recs).
     *
     * Generated from protobuf field <code>string filter = 5;</code>
     */
    protected $filter = '';
    /**
     * Use validate only mode for this prediction query. If set to true, a
     * dummy model will be used that returns arbitrary products.
     * Note that the validate only mode should only be used for testing the API,
     * or if the model is not ready.
     *
     * Generated from protobuf field <code>bool validate_only = 6;</code>
     */
    protected $validate_only = false;
    /**
     * Additional domain specific parameters for the predictions.
     * Allowed values:
     * * `returnProduct`: Boolean. If set to true, the associated product
     *    object will be returned in the `results.metadata` field in the
     *    prediction response.
     * * `returnScore`: Boolean. If set to true, the prediction 'score'
     *    corresponding to each returned product will be set in the
     *    `results.metadata` field in the prediction response. The given
     *    'score' indicates the probability of a product being clicked/purchased
     *    given the user's context and history.
     * * `strictFiltering`: Boolean. True by default. If set to false, the service
     *    will return generic (unfiltered) popular products instead of empty if
     *    your filter blocks all prediction results.
     * * `priceRerankLevel`: String. Default empty. If set to be non-empty, then
     *    it needs to be one of {'no-price-reranking', 'low-price-reranking',
     *    'medium-price-reranking', 'high-price-reranking'}. This gives
     *    request-level control and adjusts prediction results based on product
     *    price.
     * * `diversityLevel`: String. Default empty. If set to be non-empty, then
     *    it needs to be one of {'no-diversity', 'low-diversity',
     *    'medium-diversity', 'high-diversity', 'auto-diversity'}. This gives
     *    request-level control and adjusts prediction results based on product
     *    category.
     * * `filterSyntaxV2`: Boolean. False by default. If set to true, the `filter`
     *   field is interpreteted according to the new, attribute-based syntax.
     *
     * Generated from protobuf field <code>map<string, .google.protobuf.Value> params = 7;</code>
     */
    private $params;
    /**
     * The labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> labels = 8;</code>
     */
    private $labels;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $placement
     *           Required. Full resource name of the format:
     *           `{placement=projects/&#42;&#47;locations/global/catalogs/default_catalog/servingConfigs/&#42;}`
     *           or
     *           `{placement=projects/&#42;&#47;locations/global/catalogs/default_catalog/placements/&#42;}`.
     *           We recommend using the `servingConfigs` resource. `placements` is a legacy
     *           resource.
     *           The ID of the Recommendations AI serving config or placement.
     *           Before you can request predictions from your model, you must create at
     *           least one serving config or placement for it. For more information, see
     *           [Manage serving configs]
     *           (https://cloud.google.com/retail/docs/manage-configs).
     *           The full list of available serving configs can be seen at
     *           https://console.cloud.google.com/ai/retail/catalogs/default_catalog/configs
     *     @type \Google\Cloud\Retail\V2\UserEvent $user_event
     *           Required. Context about the user, what they are looking at and what action
     *           they took to trigger the predict request. Note that this user event detail
     *           won't be ingested to userEvent logs. Thus, a separate userEvent write
     *           request is required for event logging.
     *           Don't set
     *           [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id] or
     *           [UserInfo.user_id][google.cloud.retail.v2.UserInfo.user_id] to the same
     *           fixed ID for different users. If you are trying to receive non-personalized
     *           recommendations (not recommended; this can negatively impact model
     *           performance), instead set
     *           [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id] to a
     *           random unique ID and leave
     *           [UserInfo.user_id][google.cloud.retail.v2.UserInfo.user_id] unset.
     *     @type int $page_size
     *           Maximum number of results to return. Set this property to the number of
     *           prediction results needed. If zero, the service will choose a reasonable
     *           default. The maximum allowed value is 100. Values above 100 will be coerced
     *           to 100.
     *     @type string $page_token
     *           This field is not used; leave it unset.
     *     @type string $filter
     *           Filter for restricting prediction results with a length limit of 5,000
     *           characters. Accepts values for tags and the `filterOutOfStockItems` flag.
     *            * Tag expressions. Restricts predictions to products that match all of the
     *              specified tags. Boolean operators `OR` and `NOT` are supported if the
     *              expression is enclosed in parentheses, and must be separated from the
     *              tag values by a space. `-"tagA"` is also supported and is equivalent to
     *              `NOT "tagA"`. Tag values must be double quoted UTF-8 encoded strings
     *              with a size limit of 1,000 characters.
     *              Note: "Recently viewed" models don't support tag filtering at the
     *              moment.
     *            * filterOutOfStockItems. Restricts predictions to products that do not
     *            have a
     *              stockState value of OUT_OF_STOCK.
     *           Examples:
     *            * tag=("Red" OR "Blue") tag="New-Arrival" tag=(NOT "promotional")
     *            * filterOutOfStockItems  tag=(-"promotional")
     *            * filterOutOfStockItems
     *           If your filter blocks all prediction results, the API will return *no*
     *           results. If instead you want empty result sets to return generic
     *           (unfiltered) popular products, set `strictFiltering` to False in
     *           `PredictRequest.params`. Note that the API will never return items with
     *           storageStatus of "EXPIRED" or "DELETED" regardless of filter choices.
     *           If `filterSyntaxV2` is set to true under the `params` field, then
     *           attribute-based expressions are expected instead of the above described
     *           tag-based syntax. Examples:
     *            * (colors: ANY("Red", "Blue")) AND NOT (categories: ANY("Phones"))
     *            * (availability: ANY("IN_STOCK")) AND
     *              (colors: ANY("Red") OR categories: ANY("Phones"))
     *           For more information, see
     *           [Filter recommendations](https://cloud.google.com/retail/docs/filter-recs).
     *     @type bool $validate_only
     *           Use validate only mode for this prediction query. If set to true, a
     *           dummy model will be used that returns arbitrary products.
     *           Note that the validate only mode should only be used for testing the API,
     *           or if the model is not ready.
     *     @type array|\Google\Protobuf\Internal\MapField $params
     *           Additional domain specific parameters for the predictions.
     *           Allowed values:
     *           * `returnProduct`: Boolean. If set to true, the associated product
     *              object will be returned in the `results.metadata` field in the
     *              prediction response.
     *           * `returnScore`: Boolean. If set to true, the prediction 'score'
     *              corresponding to each returned product will be set in the
     *              `results.metadata` field in the prediction response. The given
     *              'score' indicates the probability of a product being clicked/purchased
     *              given the user's context and history.
     *           * `strictFiltering`: Boolean. True by default. If set to false, the service
     *              will return generic (unfiltered) popular products instead of empty if
     *              your filter blocks all prediction results.
     *           * `priceRerankLevel`: String. Default empty. If set to be non-empty, then
     *              it needs to be one of {'no-price-reranking', 'low-price-reranking',
     *              'medium-price-reranking', 'high-price-reranking'}. This gives
     *              request-level control and adjusts prediction results based on product
     *              price.
     *           * `diversityLevel`: String. Default empty. If set to be non-empty, then
     *              it needs to be one of {'no-diversity', 'low-diversity',
     *              'medium-diversity', 'high-diversity', 'auto-diversity'}. This gives
     *              request-level control and adjusts prediction results based on product
     *              category.
     *           * `filterSyntaxV2`: Boolean. False by default. If set to true, the `filter`
     *             field is interpreteted according to the new, attribute-based syntax.
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           The labels applied to a resource must meet the following requirements:
     *           * Each resource can have multiple labels, up to a maximum of 64.
     *           * Each label must be a key-value pair.
     *           * Keys have a minimum length of 1 character and a maximum length of 63
     *             characters and cannot be empty. Values can be empty and have a maximum
     *             length of 63 characters.
     *           * Keys and values can contain only lowercase letters, numeric characters,
     *             underscores, and dashes. All characters must use UTF-8 encoding, and
     *             international characters are allowed.
     *           * The key portion of a label must be unique. However, you can use the same
     *             key with multiple resources.
     *           * Keys must start with a lowercase letter or international character.
     *           See [Google Cloud
     *           Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     *           for more details.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Retail\V2\PredictionService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Full resource name of the format:
     * `{placement=projects/&#42;&#47;locations/global/catalogs/default_catalog/servingConfigs/&#42;}`
     * or
     * `{placement=projects/&#42;&#47;locations/global/catalogs/default_catalog/placements/&#42;}`.
     * We recommend using the `servingConfigs` resource. `placements` is a legacy
     * resource.
     * The ID of the Recommendations AI serving config or placement.
     * Before you can request predictions from your model, you must create at
     * least one serving config or placement for it. For more information, see
     * [Manage serving configs]
     * (https://cloud.google.com/retail/docs/manage-configs).
     * The full list of available serving configs can be seen at
     * https://console.cloud.google.com/ai/retail/catalogs/default_catalog/configs
     *
     * Generated from protobuf field <code>string placement = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getPlacement()
    {
        return $this->placement;
    }

    /**
     * Required. Full resource name of the format:
     * `{placement=projects/&#42;&#47;locations/global/catalogs/default_catalog/servingConfigs/&#42;}`
     * or
     * `{placement=projects/&#42;&#47;locations/global/catalogs/default_catalog/placements/&#42;}`.
     * We recommend using the `servingConfigs` resource. `placements` is a legacy
     * resource.
     * The ID of the Recommendations AI serving config or placement.
     * Before you can request predictions from your model, you must create at
     * least one serving config or placement for it. For more information, see
     * [Manage serving configs]
     * (https://cloud.google.com/retail/docs/manage-configs).
     * The full list of available serving configs can be seen at
     * https://console.cloud.google.com/ai/retail/catalogs/default_catalog/configs
     *
     * Generated from protobuf field <code>string placement = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setPlacement($var)
    {
        GPBUtil::checkString($var, True);
        $this->placement = $var;

        return $this;
    }

    /**
     * Required. Context about the user, what they are looking at and what action
     * they took to trigger the predict request. Note that this user event detail
     * won't be ingested to userEvent logs. Thus, a separate userEvent write
     * request is required for event logging.
     * Don't set
     * [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id] or
     * [UserInfo.user_id][google.cloud.retail.v2.UserInfo.user_id] to the same
     * fixed ID for different users. If you are trying to receive non-personalized
     * recommendations (not recommended; this can negatively impact model
     * performance), instead set
     * [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id] to a
     * random unique ID and leave
     * [UserInfo.user_id][google.cloud.retail.v2.UserInfo.user_id] unset.
     *
     * Generated from protobuf field <code>.google.cloud.retail.v2.UserEvent user_event = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Retail\V2\UserEvent|null
     */
    public function getUserEvent()
    {
        return $this->user_event;
    }

    public function hasUserEvent()
    {
        return isset($this->user_event);
    }

    public function clearUserEvent()
    {
        unset($this->user_event);
    }

    /**
     * Required. Context about the user, what they are looking at and what action
     * they took to trigger the predict request. Note that this user event detail
     * won't be ingested to userEvent logs. Thus, a separate userEvent write
     * request is required for event logging.
     * Don't set
     * [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id] or
     * [UserInfo.user_id][google.cloud.retail.v2.UserInfo.user_id] to the same
     * fixed ID for different users. If you are trying to receive non-personalized
     * recommendations (not recommended; this can negatively impact model
     * performance), instead set
     * [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id] to a
     * random unique ID and leave
     * [UserInfo.user_id][google.cloud.retail.v2.UserInfo.user_id] unset.
     *
     * Generated from protobuf field <code>.google.cloud.retail.v2.UserEvent user_event = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Retail\V2\UserEvent $var
     * @return $this
     */
    public function setUserEvent($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Retail\V2\UserEvent::class);
        $this->user_event = $var;

        return $this;
    }

    /**
     * Maximum number of results to return. Set this property to the number of
     * prediction results needed. If zero, the service will choose a reasonable
     * default. The maximum allowed value is 100. Values above 100 will be coerced
     * to 100.
     *
     * Generated from protobuf field <code>int32 page_size = 3;</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * Maximum number of results to return. Set this property to the number of
     * prediction results needed. If zero, the service will choose a reasonable
     * default. The maximum allowed value is 100. Values above 100 will be coerced
     * to 100.
     *
     * Generated from protobuf field <code>int32 page_size = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

    /**
     * This field is not used; leave it unset.
     *
     * Generated from protobuf field <code>string page_token = 4 [deprecated = true];</code>
     * @return string
     * @deprecated
     */
    public function getPageToken()
    {
        if ($this->page_token !== '') {
            @trigger_error('page_token is deprecated.', E_USER_DEPRECATED);
        }
        return $this->page_token;
    }

    /**
     * This field is not used; leave it unset.
     *
     * Generated from protobuf field <code>string page_token = 4 [deprecated = true];</code>
     * @param string $var
     * @return $this
     * @deprecated
     */
    public function setPageToken($var)
    {
        @trigger_error('page_token is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkString($var, True);
        $this->page_token = $var;

        return $this;
    }

    /**
     * Filter for restricting prediction results with a length limit of 5,000
     * characters. Accepts values for tags and the `filterOutOfStockItems` flag.
     *  * Tag expressions. Restricts predictions to products that match all of the
     *    specified tags. Boolean operators `OR` and `NOT` are supported if the
     *    expression is enclosed in parentheses, and must be separated from the
     *    tag values by a space. `-"tagA"` is also supported and is equivalent to
     *    `NOT "tagA"`. Tag values must be double quoted UTF-8 encoded strings
     *    with a size limit of 1,000 characters.
     *    Note: "Recently viewed" models don't support tag filtering at the
     *    moment.
     *  * filterOutOfStockItems. Restricts predictions to products that do not
     *  have a
     *    stockState value of OUT_OF_STOCK.
     * Examples:
     *  * tag=("Red" OR "Blue") tag="New-Arrival" tag=(NOT "promotional")
     *  * filterOutOfStockItems  tag=(-"promotional")
     *  * filterOutOfStockItems
     * If your filter blocks all prediction results, the API will return *no*
     * results. If instead you want empty result sets to return generic
     * (unfiltered) popular products, set `strictFiltering` to False in
     * `PredictRequest.params`. Note that the API will never return items with
     * storageStatus of "EXPIRED" or "DELETED" regardless of filter choices.
     * If `filterSyntaxV2` is set to true under the `params` field, then
     * attribute-based expressions are expected instead of the above described
     * tag-based syntax. Examples:
     *  * (colors: ANY("Red", "Blue")) AND NOT (categories: ANY("Phones"))
     *  * (availability: ANY("IN_STOCK")) AND
     *    (colors: ANY("Red") OR categories: ANY("Phones"))
     * For more information, see
     * [Filter recommendations](https://cloud.google.com/retail/docs/filter-recs).
     *
     * Generated from protobuf field <code>string filter = 5;</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Filter for restricting prediction results with a length limit of 5,000
     * characters. Accepts values for tags and the `filterOutOfStockItems` flag.
     *  * Tag expressions. Restricts predictions to products that match all of the
     *    specified tags. Boolean operators `OR` and `NOT` are supported if the
     *    expression is enclosed in parentheses, and must be separated from the
     *    tag values by a space. `-"tagA"` is also supported and is equivalent to
     *    `NOT "tagA"`. Tag values must be double quoted UTF-8 encoded strings
     *    with a size limit of 1,000 characters.
     *    Note: "Recently viewed" models don't support tag filtering at the
     *    moment.
     *  * filterOutOfStockItems. Restricts predictions to products that do not
     *  have a
     *    stockState value of OUT_OF_STOCK.
     * Examples:
     *  * tag=("Red" OR "Blue") tag="New-Arrival" tag=(NOT "promotional")
     *  * filterOutOfStockItems  tag=(-"promotional")
     *  * filterOutOfStockItems
     * If your filter blocks all prediction results, the API will return *no*
     * results. If instead you want empty result sets to return generic
     * (unfiltered) popular products, set `strictFiltering` to False in
     * `PredictRequest.params`. Note that the API will never return items with
     * storageStatus of "EXPIRED" or "DELETED" regardless of filter choices.
     * If `filterSyntaxV2` is set to true under the `params` field, then
     * attribute-based expressions are expected instead of the above described
     * tag-based syntax. Examples:
     *  * (colors: ANY("Red", "Blue")) AND NOT (categories: ANY("Phones"))
     *  * (availability: ANY("IN_STOCK")) AND
     *    (colors: ANY("Red") OR categories: ANY("Phones"))
     * For more information, see
     * [Filter recommendations](https://cloud.google.com/retail/docs/filter-recs).
     *
     * Generated from protobuf field <code>string filter = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

    /**
     * Use validate only mode for this prediction query. If set to true, a
     * dummy model will be used that returns arbitrary products.
     * Note that the validate only mode should only be used for testing the API,
     * or if the model is not ready.
     *
     * Generated from protobuf field <code>bool validate_only = 6;</code>
     * @return bool
     */
    public function getValidateOnly()
    {
        return $this->validate_only;
    }

    /**
     * Use validate only mode for this prediction query. If set to true, a
     * dummy model will be used that returns arbitrary products.
     * Note that the validate only mode should only be used for testing the API,
     * or if the model is not ready.
     *
     * Generated from protobuf field <code>bool validate_only = 6;</code>
     * @param bool $var
     * @return $this
     */
    public function setValidateOnly($var)
    {
        GPBUtil::checkBool($var);
        $this->validate_only = $var;

        return $this;
    }

    /**
     * Additional domain specific parameters for the predictions.
     * Allowed values:
     * * `returnProduct`: Boolean. If set to true, the associated product
     *    object will be returned in the `results.metadata` field in the
     *    prediction response.
     * * `returnScore`: Boolean. If set to true, the prediction 'score'
     *    corresponding to each returned product will be set in the
     *    `results.metadata` field in the prediction response. The given
     *    'score' indicates the probability of a product being clicked/purchased
     *    given the user's context and history.
     * * `strictFiltering`: Boolean. True by default. If set to false, the service
     *    will return generic (unfiltered) popular products instead of empty if
     *    your filter blocks all prediction results.
     * * `priceRerankLevel`: String. Default empty. If set to be non-empty, then
     *    it needs to be one of {'no-price-reranking', 'low-price-reranking',
     *    'medium-price-reranking', 'high-price-reranking'}. This gives
     *    request-level control and adjusts prediction results based on product
     *    price.
     * * `diversityLevel`: String. Default empty. If set to be non-empty, then
     *    it needs to be one of {'no-diversity', 'low-diversity',
     *    'medium-diversity', 'high-diversity', 'auto-diversity'}. This gives
     *    request-level control and adjusts prediction results based on product
     *    category.
     * * `filterSyntaxV2`: Boolean. False by default. If set to true, the `filter`
     *   field is interpreteted according to the new, attribute-based syntax.
     *
     * Generated from protobuf field <code>map<string, .google.protobuf.Value> params = 7;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Additional domain specific parameters for the predictions.
     * Allowed values:
     * * `returnProduct`: Boolean. If set to true, the associated product
     *    object will be returned in the `results.metadata` field in the
     *    prediction response.
     * * `returnScore`: Boolean. If set to true, the prediction 'score'
     *    corresponding to each returned product will be set in the
     *    `results.metadata` field in the prediction response. The given
     *    'score' indicates the probability of a product being clicked/purchased
     *    given the user's context and history.
     * * `strictFiltering`: Boolean. True by default. If set to false, the service
     *    will return generic (unfiltered) popular products instead of empty if
     *    your filter blocks all prediction results.
     * * `priceRerankLevel`: String. Default empty. If set to be non-empty, then
     *    it needs to be one of {'no-price-reranking', 'low-price-reranking',
     *    'medium-price-reranking', 'high-price-reranking'}. This gives
     *    request-level control and adjusts prediction results based on product
     *    price.
     * * `diversityLevel`: String. Default empty. If set to be non-empty, then
     *    it needs to be one of {'no-diversity', 'low-diversity',
     *    'medium-diversity', 'high-diversity', 'auto-diversity'}. This gives
     *    request-level control and adjusts prediction results based on product
     *    category.
     * * `filterSyntaxV2`: Boolean. False by default. If set to true, the `filter`
     *   field is interpreteted according to the new, attribute-based syntax.
     *
     * Generated from protobuf field <code>map<string, .google.protobuf.Value> params = 7;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setParams($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Protobuf\Value::class);
        $this->params = $arr;

        return $this;
    }

    /**
     * The labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> labels = 8;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * The labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> labels = 8;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;

        return $this;
    }

}

