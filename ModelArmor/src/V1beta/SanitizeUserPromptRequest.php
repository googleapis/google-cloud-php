<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/modelarmor/v1beta/service.proto

namespace Google\Cloud\ModelArmor\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Sanitize User Prompt request.
 *
 * Generated from protobuf message <code>google.cloud.modelarmor.v1beta.SanitizeUserPromptRequest</code>
 */
class SanitizeUserPromptRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Represents resource name of template
     * e.g. name=projects/sample-project/locations/us-central1/templates/templ01
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Required. User prompt data to sanitize.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1beta.DataItem user_prompt_data = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $user_prompt_data = null;
    /**
     * Optional. Metadata related to Multi Language Detection.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1beta.MultiLanguageDetectionMetadata multi_language_detection_metadata = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $multi_language_detection_metadata = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. Represents resource name of template
     *           e.g. name=projects/sample-project/locations/us-central1/templates/templ01
     *     @type \Google\Cloud\ModelArmor\V1beta\DataItem $user_prompt_data
     *           Required. User prompt data to sanitize.
     *     @type \Google\Cloud\ModelArmor\V1beta\MultiLanguageDetectionMetadata $multi_language_detection_metadata
     *           Optional. Metadata related to Multi Language Detection.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Modelarmor\V1Beta\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Represents resource name of template
     * e.g. name=projects/sample-project/locations/us-central1/templates/templ01
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. Represents resource name of template
     * e.g. name=projects/sample-project/locations/us-central1/templates/templ01
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

    /**
     * Required. User prompt data to sanitize.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1beta.DataItem user_prompt_data = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\ModelArmor\V1beta\DataItem|null
     */
    public function getUserPromptData()
    {
        return $this->user_prompt_data;
    }

    public function hasUserPromptData()
    {
        return isset($this->user_prompt_data);
    }

    public function clearUserPromptData()
    {
        unset($this->user_prompt_data);
    }

    /**
     * Required. User prompt data to sanitize.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1beta.DataItem user_prompt_data = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\ModelArmor\V1beta\DataItem $var
     * @return $this
     */
    public function setUserPromptData($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\ModelArmor\V1beta\DataItem::class);
        $this->user_prompt_data = $var;

        return $this;
    }

    /**
     * Optional. Metadata related to Multi Language Detection.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1beta.MultiLanguageDetectionMetadata multi_language_detection_metadata = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\ModelArmor\V1beta\MultiLanguageDetectionMetadata|null
     */
    public function getMultiLanguageDetectionMetadata()
    {
        return $this->multi_language_detection_metadata;
    }

    public function hasMultiLanguageDetectionMetadata()
    {
        return isset($this->multi_language_detection_metadata);
    }

    public function clearMultiLanguageDetectionMetadata()
    {
        unset($this->multi_language_detection_metadata);
    }

    /**
     * Optional. Metadata related to Multi Language Detection.
     *
     * Generated from protobuf field <code>.google.cloud.modelarmor.v1beta.MultiLanguageDetectionMetadata multi_language_detection_metadata = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\ModelArmor\V1beta\MultiLanguageDetectionMetadata $var
     * @return $this
     */
    public function setMultiLanguageDetectionMetadata($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\ModelArmor\V1beta\MultiLanguageDetectionMetadata::class);
        $this->multi_language_detection_metadata = $var;

        return $this;
    }

}

