<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/cx/v3/page.proto

namespace Google\Cloud\Dialogflow\Cx\V3\Form;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents a form parameter.
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.cx.v3.Form.Parameter</code>
 */
class Parameter extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The human-readable name of the parameter, unique within the
     * form.
     *
     * Generated from protobuf field <code>string display_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $display_name = '';
    /**
     * Indicates whether the parameter is required. Optional parameters will not
     * trigger prompts; however, they are filled if the user specifies them.
     * Required parameters must be filled before form filling concludes.
     *
     * Generated from protobuf field <code>bool required = 2;</code>
     */
    protected $required = false;
    /**
     * Required. The entity type of the parameter.
     * Format:
     * `projects/-/locations/-/agents/-/entityTypes/<SystemEntityTypeID>` for
     * system entity types (for example,
     * `projects/-/locations/-/agents/-/entityTypes/sys.date`), or
     * `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/entityTypes/<EntityTypeID>`
     * for developer entity types.
     *
     * Generated from protobuf field <code>string entity_type = 3 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $entity_type = '';
    /**
     * Indicates whether the parameter represents a list of values.
     *
     * Generated from protobuf field <code>bool is_list = 4;</code>
     */
    protected $is_list = false;
    /**
     * Required. Defines fill behavior for the parameter.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.cx.v3.Form.Parameter.FillBehavior fill_behavior = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $fill_behavior = null;
    /**
     * The default value of an optional parameter. If the parameter is required,
     * the default value will be ignored.
     *
     * Generated from protobuf field <code>.google.protobuf.Value default_value = 9;</code>
     */
    protected $default_value = null;
    /**
     * Indicates whether the parameter content should be redacted in log.  If
     * redaction is enabled, the parameter content will be replaced by parameter
     * name during logging.
     * Note: the parameter content is subject to redaction if either parameter
     * level redaction or [entity type level
     * redaction][google.cloud.dialogflow.cx.v3.EntityType.redact] is enabled.
     *
     * Generated from protobuf field <code>bool redact = 11;</code>
     */
    protected $redact = false;
    /**
     * Hierarchical advanced settings for this parameter. The settings exposed
     * at the lower level overrides the settings exposed at the higher level.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.cx.v3.AdvancedSettings advanced_settings = 12;</code>
     */
    protected $advanced_settings = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $display_name
     *           Required. The human-readable name of the parameter, unique within the
     *           form.
     *     @type bool $required
     *           Indicates whether the parameter is required. Optional parameters will not
     *           trigger prompts; however, they are filled if the user specifies them.
     *           Required parameters must be filled before form filling concludes.
     *     @type string $entity_type
     *           Required. The entity type of the parameter.
     *           Format:
     *           `projects/-/locations/-/agents/-/entityTypes/<SystemEntityTypeID>` for
     *           system entity types (for example,
     *           `projects/-/locations/-/agents/-/entityTypes/sys.date`), or
     *           `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/entityTypes/<EntityTypeID>`
     *           for developer entity types.
     *     @type bool $is_list
     *           Indicates whether the parameter represents a list of values.
     *     @type \Google\Cloud\Dialogflow\Cx\V3\Form\Parameter\FillBehavior $fill_behavior
     *           Required. Defines fill behavior for the parameter.
     *     @type \Google\Protobuf\Value $default_value
     *           The default value of an optional parameter. If the parameter is required,
     *           the default value will be ignored.
     *     @type bool $redact
     *           Indicates whether the parameter content should be redacted in log.  If
     *           redaction is enabled, the parameter content will be replaced by parameter
     *           name during logging.
     *           Note: the parameter content is subject to redaction if either parameter
     *           level redaction or [entity type level
     *           redaction][google.cloud.dialogflow.cx.v3.EntityType.redact] is enabled.
     *     @type \Google\Cloud\Dialogflow\Cx\V3\AdvancedSettings $advanced_settings
     *           Hierarchical advanced settings for this parameter. The settings exposed
     *           at the lower level overrides the settings exposed at the higher level.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\Cx\V3\Page::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The human-readable name of the parameter, unique within the
     * form.
     *
     * Generated from protobuf field <code>string display_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Required. The human-readable name of the parameter, unique within the
     * form.
     *
     * Generated from protobuf field <code>string display_name = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayName($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_name = $var;

        return $this;
    }

    /**
     * Indicates whether the parameter is required. Optional parameters will not
     * trigger prompts; however, they are filled if the user specifies them.
     * Required parameters must be filled before form filling concludes.
     *
     * Generated from protobuf field <code>bool required = 2;</code>
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Indicates whether the parameter is required. Optional parameters will not
     * trigger prompts; however, they are filled if the user specifies them.
     * Required parameters must be filled before form filling concludes.
     *
     * Generated from protobuf field <code>bool required = 2;</code>
     * @param bool $var
     * @return $this
     */
    public function setRequired($var)
    {
        GPBUtil::checkBool($var);
        $this->required = $var;

        return $this;
    }

    /**
     * Required. The entity type of the parameter.
     * Format:
     * `projects/-/locations/-/agents/-/entityTypes/<SystemEntityTypeID>` for
     * system entity types (for example,
     * `projects/-/locations/-/agents/-/entityTypes/sys.date`), or
     * `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/entityTypes/<EntityTypeID>`
     * for developer entity types.
     *
     * Generated from protobuf field <code>string entity_type = 3 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getEntityType()
    {
        return $this->entity_type;
    }

    /**
     * Required. The entity type of the parameter.
     * Format:
     * `projects/-/locations/-/agents/-/entityTypes/<SystemEntityTypeID>` for
     * system entity types (for example,
     * `projects/-/locations/-/agents/-/entityTypes/sys.date`), or
     * `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/entityTypes/<EntityTypeID>`
     * for developer entity types.
     *
     * Generated from protobuf field <code>string entity_type = 3 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setEntityType($var)
    {
        GPBUtil::checkString($var, True);
        $this->entity_type = $var;

        return $this;
    }

    /**
     * Indicates whether the parameter represents a list of values.
     *
     * Generated from protobuf field <code>bool is_list = 4;</code>
     * @return bool
     */
    public function getIsList()
    {
        return $this->is_list;
    }

    /**
     * Indicates whether the parameter represents a list of values.
     *
     * Generated from protobuf field <code>bool is_list = 4;</code>
     * @param bool $var
     * @return $this
     */
    public function setIsList($var)
    {
        GPBUtil::checkBool($var);
        $this->is_list = $var;

        return $this;
    }

    /**
     * Required. Defines fill behavior for the parameter.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.cx.v3.Form.Parameter.FillBehavior fill_behavior = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Dialogflow\Cx\V3\Form\Parameter\FillBehavior|null
     */
    public function getFillBehavior()
    {
        return $this->fill_behavior;
    }

    public function hasFillBehavior()
    {
        return isset($this->fill_behavior);
    }

    public function clearFillBehavior()
    {
        unset($this->fill_behavior);
    }

    /**
     * Required. Defines fill behavior for the parameter.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.cx.v3.Form.Parameter.FillBehavior fill_behavior = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Dialogflow\Cx\V3\Form\Parameter\FillBehavior $var
     * @return $this
     */
    public function setFillBehavior($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dialogflow\Cx\V3\Form\Parameter\FillBehavior::class);
        $this->fill_behavior = $var;

        return $this;
    }

    /**
     * The default value of an optional parameter. If the parameter is required,
     * the default value will be ignored.
     *
     * Generated from protobuf field <code>.google.protobuf.Value default_value = 9;</code>
     * @return \Google\Protobuf\Value|null
     */
    public function getDefaultValue()
    {
        return $this->default_value;
    }

    public function hasDefaultValue()
    {
        return isset($this->default_value);
    }

    public function clearDefaultValue()
    {
        unset($this->default_value);
    }

    /**
     * The default value of an optional parameter. If the parameter is required,
     * the default value will be ignored.
     *
     * Generated from protobuf field <code>.google.protobuf.Value default_value = 9;</code>
     * @param \Google\Protobuf\Value $var
     * @return $this
     */
    public function setDefaultValue($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Value::class);
        $this->default_value = $var;

        return $this;
    }

    /**
     * Indicates whether the parameter content should be redacted in log.  If
     * redaction is enabled, the parameter content will be replaced by parameter
     * name during logging.
     * Note: the parameter content is subject to redaction if either parameter
     * level redaction or [entity type level
     * redaction][google.cloud.dialogflow.cx.v3.EntityType.redact] is enabled.
     *
     * Generated from protobuf field <code>bool redact = 11;</code>
     * @return bool
     */
    public function getRedact()
    {
        return $this->redact;
    }

    /**
     * Indicates whether the parameter content should be redacted in log.  If
     * redaction is enabled, the parameter content will be replaced by parameter
     * name during logging.
     * Note: the parameter content is subject to redaction if either parameter
     * level redaction or [entity type level
     * redaction][google.cloud.dialogflow.cx.v3.EntityType.redact] is enabled.
     *
     * Generated from protobuf field <code>bool redact = 11;</code>
     * @param bool $var
     * @return $this
     */
    public function setRedact($var)
    {
        GPBUtil::checkBool($var);
        $this->redact = $var;

        return $this;
    }

    /**
     * Hierarchical advanced settings for this parameter. The settings exposed
     * at the lower level overrides the settings exposed at the higher level.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.cx.v3.AdvancedSettings advanced_settings = 12;</code>
     * @return \Google\Cloud\Dialogflow\Cx\V3\AdvancedSettings|null
     */
    public function getAdvancedSettings()
    {
        return $this->advanced_settings;
    }

    public function hasAdvancedSettings()
    {
        return isset($this->advanced_settings);
    }

    public function clearAdvancedSettings()
    {
        unset($this->advanced_settings);
    }

    /**
     * Hierarchical advanced settings for this parameter. The settings exposed
     * at the lower level overrides the settings exposed at the higher level.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.cx.v3.AdvancedSettings advanced_settings = 12;</code>
     * @param \Google\Cloud\Dialogflow\Cx\V3\AdvancedSettings $var
     * @return $this
     */
    public function setAdvancedSettings($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dialogflow\Cx\V3\AdvancedSettings::class);
        $this->advanced_settings = $var;

        return $this;
    }

}


