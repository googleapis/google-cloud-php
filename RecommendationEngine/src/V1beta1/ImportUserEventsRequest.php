<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/recommendationengine/v1beta1/import.proto

namespace Google\Cloud\RecommendationEngine\V1beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for the ImportUserEvents request.
 *
 * Generated from protobuf message <code>google.cloud.recommendationengine.v1beta1.ImportUserEventsRequest</code>
 */
class ImportUserEventsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required.
     * `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Optional. Unique identifier provided by client, within the ancestor
     * dataset scope. Ensures idempotency for expensive long running operations.
     * Server-generated if unspecified. Up to 128 characters long. This is
     * returned as google.longrunning.Operation.name in the response. Note that
     * this field must not be set if the desired input config is
     * catalog_inline_source.
     *
     * Generated from protobuf field <code>string request_id = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $request_id = '';
    /**
     * Required. The desired input location of the data.
     *
     * Generated from protobuf field <code>.google.cloud.recommendationengine.v1beta1.InputConfig input_config = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $input_config = null;
    /**
     * Optional. The desired location of errors incurred during the Import.
     *
     * Generated from protobuf field <code>.google.cloud.recommendationengine.v1beta1.ImportErrorsConfig errors_config = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $errors_config = null;

    /**
     * @param string                                                        $parent       Required.
     *                                                                                    `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`
     *                                                                                    Please see {@see UserEventServiceClient::eventStoreName()} for help formatting this field.
     * @param string                                                        $requestId    Optional. Unique identifier provided by client, within the ancestor
     *                                                                                    dataset scope. Ensures idempotency for expensive long running operations.
     *                                                                                    Server-generated if unspecified. Up to 128 characters long. This is
     *                                                                                    returned as google.longrunning.Operation.name in the response. Note that
     *                                                                                    this field must not be set if the desired input config is
     *                                                                                    catalog_inline_source.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\InputConfig        $inputConfig  Required. The desired input location of the data.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\ImportErrorsConfig $errorsConfig Optional. The desired location of errors incurred during the Import.
     *
     * @return \Google\Cloud\RecommendationEngine\V1beta1\ImportUserEventsRequest
     *
     * @experimental
     */
    public static function build(string $parent, string $requestId, \Google\Cloud\RecommendationEngine\V1beta1\InputConfig $inputConfig, \Google\Cloud\RecommendationEngine\V1beta1\ImportErrorsConfig $errorsConfig): self
    {
        return (new self())
            ->setParent($parent)
            ->setRequestId($requestId)
            ->setInputConfig($inputConfig)
            ->setErrorsConfig($errorsConfig);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required.
     *           `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`
     *     @type string $request_id
     *           Optional. Unique identifier provided by client, within the ancestor
     *           dataset scope. Ensures idempotency for expensive long running operations.
     *           Server-generated if unspecified. Up to 128 characters long. This is
     *           returned as google.longrunning.Operation.name in the response. Note that
     *           this field must not be set if the desired input config is
     *           catalog_inline_source.
     *     @type \Google\Cloud\RecommendationEngine\V1beta1\InputConfig $input_config
     *           Required. The desired input location of the data.
     *     @type \Google\Cloud\RecommendationEngine\V1beta1\ImportErrorsConfig $errors_config
     *           Optional. The desired location of errors incurred during the Import.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Recommendationengine\V1Beta1\Import::initOnce();
        parent::__construct($data);
    }

    /**
     * Required.
     * `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required.
     * `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Optional. Unique identifier provided by client, within the ancestor
     * dataset scope. Ensures idempotency for expensive long running operations.
     * Server-generated if unspecified. Up to 128 characters long. This is
     * returned as google.longrunning.Operation.name in the response. Note that
     * this field must not be set if the desired input config is
     * catalog_inline_source.
     *
     * Generated from protobuf field <code>string request_id = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getRequestId()
    {
        return $this->request_id;
    }

    /**
     * Optional. Unique identifier provided by client, within the ancestor
     * dataset scope. Ensures idempotency for expensive long running operations.
     * Server-generated if unspecified. Up to 128 characters long. This is
     * returned as google.longrunning.Operation.name in the response. Note that
     * this field must not be set if the desired input config is
     * catalog_inline_source.
     *
     * Generated from protobuf field <code>string request_id = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setRequestId($var)
    {
        GPBUtil::checkString($var, True);
        $this->request_id = $var;

        return $this;
    }

    /**
     * Required. The desired input location of the data.
     *
     * Generated from protobuf field <code>.google.cloud.recommendationengine.v1beta1.InputConfig input_config = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\RecommendationEngine\V1beta1\InputConfig|null
     */
    public function getInputConfig()
    {
        return $this->input_config;
    }

    public function hasInputConfig()
    {
        return isset($this->input_config);
    }

    public function clearInputConfig()
    {
        unset($this->input_config);
    }

    /**
     * Required. The desired input location of the data.
     *
     * Generated from protobuf field <code>.google.cloud.recommendationengine.v1beta1.InputConfig input_config = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\RecommendationEngine\V1beta1\InputConfig $var
     * @return $this
     */
    public function setInputConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\RecommendationEngine\V1beta1\InputConfig::class);
        $this->input_config = $var;

        return $this;
    }

    /**
     * Optional. The desired location of errors incurred during the Import.
     *
     * Generated from protobuf field <code>.google.cloud.recommendationengine.v1beta1.ImportErrorsConfig errors_config = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\RecommendationEngine\V1beta1\ImportErrorsConfig|null
     */
    public function getErrorsConfig()
    {
        return $this->errors_config;
    }

    public function hasErrorsConfig()
    {
        return isset($this->errors_config);
    }

    public function clearErrorsConfig()
    {
        unset($this->errors_config);
    }

    /**
     * Optional. The desired location of errors incurred during the Import.
     *
     * Generated from protobuf field <code>.google.cloud.recommendationengine.v1beta1.ImportErrorsConfig errors_config = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\RecommendationEngine\V1beta1\ImportErrorsConfig $var
     * @return $this
     */
    public function setErrorsConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\RecommendationEngine\V1beta1\ImportErrorsConfig::class);
        $this->errors_config = $var;

        return $this;
    }

}

