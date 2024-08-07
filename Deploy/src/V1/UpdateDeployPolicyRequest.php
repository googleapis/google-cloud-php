<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/deploy/v1/cloud_deploy.proto

namespace Google\Cloud\Deploy\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request object for `UpdateDeployPolicy`.
 *
 * Generated from protobuf message <code>google.cloud.deploy.v1.UpdateDeployPolicyRequest</code>
 */
class UpdateDeployPolicyRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Field mask is used to specify the fields to be overwritten by the
     * update in the `DeployPolicy` resource. The fields specified in the
     * update_mask are relative to the resource, not the full request. A field
     * will be overwritten if it's in the mask. If the user doesn't provide a mask
     * then all fields are overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $update_mask = null;
    /**
     * Required. The `DeployPolicy` to update.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.DeployPolicy deploy_policy = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $deploy_policy = null;
    /**
     * Optional. A request ID to identify requests. Specify a unique request ID
     * so that if you must retry your request, the server knows to ignore the
     * request if it has already been completed. The server guarantees that for
     * at least 60 minutes after the first request.
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request ID,
     * the server can check if original operation with the same request ID was
     * received, and if so, will ignore the second request. This prevents clients
     * from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $request_id = '';
    /**
     * Optional. If set to true, updating a `DeployPolicy` that does not exist
     * will result in the creation of a new `DeployPolicy`.
     *
     * Generated from protobuf field <code>bool allow_missing = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $allow_missing = false;
    /**
     * Optional. If set to true, the request is validated and the user is provided
     * with an expected result, but no actual change is made.
     *
     * Generated from protobuf field <code>bool validate_only = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $validate_only = false;

    /**
     * @param \Google\Cloud\Deploy\V1\DeployPolicy $deployPolicy Required. The `DeployPolicy` to update.
     * @param \Google\Protobuf\FieldMask           $updateMask   Required. Field mask is used to specify the fields to be overwritten by the
     *                                                           update in the `DeployPolicy` resource. The fields specified in the
     *                                                           update_mask are relative to the resource, not the full request. A field
     *                                                           will be overwritten if it's in the mask. If the user doesn't provide a mask
     *                                                           then all fields are overwritten.
     *
     * @return \Google\Cloud\Deploy\V1\UpdateDeployPolicyRequest
     *
     * @experimental
     */
    public static function build(\Google\Cloud\Deploy\V1\DeployPolicy $deployPolicy, \Google\Protobuf\FieldMask $updateMask): self
    {
        return (new self())
            ->setDeployPolicy($deployPolicy)
            ->setUpdateMask($updateMask);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Required. Field mask is used to specify the fields to be overwritten by the
     *           update in the `DeployPolicy` resource. The fields specified in the
     *           update_mask are relative to the resource, not the full request. A field
     *           will be overwritten if it's in the mask. If the user doesn't provide a mask
     *           then all fields are overwritten.
     *     @type \Google\Cloud\Deploy\V1\DeployPolicy $deploy_policy
     *           Required. The `DeployPolicy` to update.
     *     @type string $request_id
     *           Optional. A request ID to identify requests. Specify a unique request ID
     *           so that if you must retry your request, the server knows to ignore the
     *           request if it has already been completed. The server guarantees that for
     *           at least 60 minutes after the first request.
     *           For example, consider a situation where you make an initial request and the
     *           request times out. If you make the request again with the same request ID,
     *           the server can check if original operation with the same request ID was
     *           received, and if so, will ignore the second request. This prevents clients
     *           from accidentally creating duplicate commitments.
     *           The request ID must be a valid UUID with the exception that zero UUID is
     *           not supported (00000000-0000-0000-0000-000000000000).
     *     @type bool $allow_missing
     *           Optional. If set to true, updating a `DeployPolicy` that does not exist
     *           will result in the creation of a new `DeployPolicy`.
     *     @type bool $validate_only
     *           Optional. If set to true, the request is validated and the user is provided
     *           with an expected result, but no actual change is made.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Deploy\V1\CloudDeploy::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Field mask is used to specify the fields to be overwritten by the
     * update in the `DeployPolicy` resource. The fields specified in the
     * update_mask are relative to the resource, not the full request. A field
     * will be overwritten if it's in the mask. If the user doesn't provide a mask
     * then all fields are overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }

    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }

    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }

    /**
     * Required. Field mask is used to specify the fields to be overwritten by the
     * update in the `DeployPolicy` resource. The fields specified in the
     * update_mask are relative to the resource, not the full request. A field
     * will be overwritten if it's in the mask. If the user doesn't provide a mask
     * then all fields are overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;

        return $this;
    }

    /**
     * Required. The `DeployPolicy` to update.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.DeployPolicy deploy_policy = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Deploy\V1\DeployPolicy|null
     */
    public function getDeployPolicy()
    {
        return $this->deploy_policy;
    }

    public function hasDeployPolicy()
    {
        return isset($this->deploy_policy);
    }

    public function clearDeployPolicy()
    {
        unset($this->deploy_policy);
    }

    /**
     * Required. The `DeployPolicy` to update.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.DeployPolicy deploy_policy = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Deploy\V1\DeployPolicy $var
     * @return $this
     */
    public function setDeployPolicy($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Deploy\V1\DeployPolicy::class);
        $this->deploy_policy = $var;

        return $this;
    }

    /**
     * Optional. A request ID to identify requests. Specify a unique request ID
     * so that if you must retry your request, the server knows to ignore the
     * request if it has already been completed. The server guarantees that for
     * at least 60 minutes after the first request.
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request ID,
     * the server can check if original operation with the same request ID was
     * received, and if so, will ignore the second request. This prevents clients
     * from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getRequestId()
    {
        return $this->request_id;
    }

    /**
     * Optional. A request ID to identify requests. Specify a unique request ID
     * so that if you must retry your request, the server knows to ignore the
     * request if it has already been completed. The server guarantees that for
     * at least 60 minutes after the first request.
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request ID,
     * the server can check if original operation with the same request ID was
     * received, and if so, will ignore the second request. This prevents clients
     * from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
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
     * Optional. If set to true, updating a `DeployPolicy` that does not exist
     * will result in the creation of a new `DeployPolicy`.
     *
     * Generated from protobuf field <code>bool allow_missing = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getAllowMissing()
    {
        return $this->allow_missing;
    }

    /**
     * Optional. If set to true, updating a `DeployPolicy` that does not exist
     * will result in the creation of a new `DeployPolicy`.
     *
     * Generated from protobuf field <code>bool allow_missing = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setAllowMissing($var)
    {
        GPBUtil::checkBool($var);
        $this->allow_missing = $var;

        return $this;
    }

    /**
     * Optional. If set to true, the request is validated and the user is provided
     * with an expected result, but no actual change is made.
     *
     * Generated from protobuf field <code>bool validate_only = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getValidateOnly()
    {
        return $this->validate_only;
    }

    /**
     * Optional. If set to true, the request is validated and the user is provided
     * with an expected result, but no actual change is made.
     *
     * Generated from protobuf field <code>bool validate_only = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setValidateOnly($var)
    {
        GPBUtil::checkBool($var);
        $this->validate_only = $var;

        return $this;
    }

}

