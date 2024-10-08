<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v2/securitycenter_service.proto

namespace Google\Cloud\SecurityCenter\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for bulk findings update.
 * Note:
 * 1. If multiple bulk update requests match the same resource, the order in
 * which they get executed is not defined.
 * 2. Once a bulk operation is started, there is no way to stop it.
 *
 * Generated from protobuf message <code>google.cloud.securitycenter.v2.BulkMuteFindingsRequest</code>
 */
class BulkMuteFindingsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The parent, at which bulk action needs to be applied. If no
     * location is specified, findings are updated in global. The following list
     * shows some examples:
     * + `organizations/[organization_id]`
     * + `organizations/[organization_id]/locations/[location_id]`
     * + `folders/[folder_id]`
     * + `folders/[folder_id]/locations/[location_id]`
     * + `projects/[project_id]`
     * + `projects/[project_id]/locations/[location_id]`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Expression that identifies findings that should be updated.
     * The expression is a list of zero or more restrictions combined
     * via logical operators `AND` and `OR`. Parentheses are supported, and `OR`
     * has higher precedence than `AND`.
     * Restrictions have the form `<field> <operator> <value>` and may have a
     * `-` character in front of them to indicate negation. The fields map to
     * those defined in the corresponding resource.
     * The supported operators are:
     * * `=` for all value types.
     * * `>`, `<`, `>=`, `<=` for integer values.
     * * `:`, meaning substring matching, for strings.
     * The supported value types are:
     * * string literals in quotes.
     * * integer literals without quotes.
     * * boolean literals `true` and `false` without quotes.
     *
     * Generated from protobuf field <code>string filter = 2;</code>
     */
    protected $filter = '';
    /**
     * Optional. All findings matching the given filter will have their mute state
     * set to this value. The default value is `MUTED`. Setting this to
     * `UNDEFINED` will clear the mute state on all matching findings.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.BulkMuteFindingsRequest.MuteState mute_state = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $mute_state = 0;

    /**
     * @param string $parent Required. The parent, at which bulk action needs to be applied. If no
     *                       location is specified, findings are updated in global. The following list
     *                       shows some examples:
     *
     *                       + `organizations/[organization_id]`
     *                       + `organizations/[organization_id]/locations/[location_id]`
     *                       + `folders/[folder_id]`
     *                       + `folders/[folder_id]/locations/[location_id]`
     *                       + `projects/[project_id]`
     *                       + `projects/[project_id]/locations/[location_id]`
     *
     * @return \Google\Cloud\SecurityCenter\V2\BulkMuteFindingsRequest
     *
     * @experimental
     */
    public static function build(string $parent): self
    {
        return (new self())
            ->setParent($parent);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The parent, at which bulk action needs to be applied. If no
     *           location is specified, findings are updated in global. The following list
     *           shows some examples:
     *           + `organizations/[organization_id]`
     *           + `organizations/[organization_id]/locations/[location_id]`
     *           + `folders/[folder_id]`
     *           + `folders/[folder_id]/locations/[location_id]`
     *           + `projects/[project_id]`
     *           + `projects/[project_id]/locations/[location_id]`
     *     @type string $filter
     *           Expression that identifies findings that should be updated.
     *           The expression is a list of zero or more restrictions combined
     *           via logical operators `AND` and `OR`. Parentheses are supported, and `OR`
     *           has higher precedence than `AND`.
     *           Restrictions have the form `<field> <operator> <value>` and may have a
     *           `-` character in front of them to indicate negation. The fields map to
     *           those defined in the corresponding resource.
     *           The supported operators are:
     *           * `=` for all value types.
     *           * `>`, `<`, `>=`, `<=` for integer values.
     *           * `:`, meaning substring matching, for strings.
     *           The supported value types are:
     *           * string literals in quotes.
     *           * integer literals without quotes.
     *           * boolean literals `true` and `false` without quotes.
     *     @type int $mute_state
     *           Optional. All findings matching the given filter will have their mute state
     *           set to this value. The default value is `MUTED`. Setting this to
     *           `UNDEFINED` will clear the mute state on all matching findings.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securitycenter\V2\SecuritycenterService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The parent, at which bulk action needs to be applied. If no
     * location is specified, findings are updated in global. The following list
     * shows some examples:
     * + `organizations/[organization_id]`
     * + `organizations/[organization_id]/locations/[location_id]`
     * + `folders/[folder_id]`
     * + `folders/[folder_id]/locations/[location_id]`
     * + `projects/[project_id]`
     * + `projects/[project_id]/locations/[location_id]`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The parent, at which bulk action needs to be applied. If no
     * location is specified, findings are updated in global. The following list
     * shows some examples:
     * + `organizations/[organization_id]`
     * + `organizations/[organization_id]/locations/[location_id]`
     * + `folders/[folder_id]`
     * + `folders/[folder_id]/locations/[location_id]`
     * + `projects/[project_id]`
     * + `projects/[project_id]/locations/[location_id]`
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
     * Expression that identifies findings that should be updated.
     * The expression is a list of zero or more restrictions combined
     * via logical operators `AND` and `OR`. Parentheses are supported, and `OR`
     * has higher precedence than `AND`.
     * Restrictions have the form `<field> <operator> <value>` and may have a
     * `-` character in front of them to indicate negation. The fields map to
     * those defined in the corresponding resource.
     * The supported operators are:
     * * `=` for all value types.
     * * `>`, `<`, `>=`, `<=` for integer values.
     * * `:`, meaning substring matching, for strings.
     * The supported value types are:
     * * string literals in quotes.
     * * integer literals without quotes.
     * * boolean literals `true` and `false` without quotes.
     *
     * Generated from protobuf field <code>string filter = 2;</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Expression that identifies findings that should be updated.
     * The expression is a list of zero or more restrictions combined
     * via logical operators `AND` and `OR`. Parentheses are supported, and `OR`
     * has higher precedence than `AND`.
     * Restrictions have the form `<field> <operator> <value>` and may have a
     * `-` character in front of them to indicate negation. The fields map to
     * those defined in the corresponding resource.
     * The supported operators are:
     * * `=` for all value types.
     * * `>`, `<`, `>=`, `<=` for integer values.
     * * `:`, meaning substring matching, for strings.
     * The supported value types are:
     * * string literals in quotes.
     * * integer literals without quotes.
     * * boolean literals `true` and `false` without quotes.
     *
     * Generated from protobuf field <code>string filter = 2;</code>
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
     * Optional. All findings matching the given filter will have their mute state
     * set to this value. The default value is `MUTED`. Setting this to
     * `UNDEFINED` will clear the mute state on all matching findings.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.BulkMuteFindingsRequest.MuteState mute_state = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getMuteState()
    {
        return $this->mute_state;
    }

    /**
     * Optional. All findings matching the given filter will have their mute state
     * set to this value. The default value is `MUTED`. Setting this to
     * `UNDEFINED` will clear the mute state on all matching findings.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.BulkMuteFindingsRequest.MuteState mute_state = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setMuteState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\SecurityCenter\V2\BulkMuteFindingsRequest\MuteState::class);
        $this->mute_state = $var;

        return $this;
    }

}

