<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/security/privateca/v1/service.proto

namespace Google\Cloud\Security\PrivateCA\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [CertificateAuthorityService.DeleteCaPool][google.cloud.security.privateca.v1.CertificateAuthorityService.DeleteCaPool].
 *
 * Generated from protobuf message <code>google.cloud.security.privateca.v1.DeleteCaPoolRequest</code>
 */
class DeleteCaPoolRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name for this
     * [CaPool][google.cloud.security.privateca.v1.CaPool] in the format
     * `projects/&#42;&#47;locations/&#42;&#47;caPools/&#42;`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Optional. An ID to identify requests. Specify a unique request ID so that
     * if you must retry your request, the server will know to ignore the request
     * if it has already been completed. The server will guarantee that for at
     * least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and
     * the request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 2 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
     */
    protected $request_id = '';
    /**
     * Optional. This field allows this pool to be deleted even if it's being
     * depended on by another resource. However, doing so may result in unintended
     * and unrecoverable effects on any dependent resources since the pool will
     * no longer be able to issue certificates.
     *
     * Generated from protobuf field <code>bool ignore_dependent_resources = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $ignore_dependent_resources = false;

    /**
     * @param string $name Required. The resource name for this
     *                     [CaPool][google.cloud.security.privateca.v1.CaPool] in the format
     *                     `projects/&#42;/locations/&#42;/caPools/*`. Please see
     *                     {@see CertificateAuthorityServiceClient::caPoolName()} for help formatting this field.
     *
     * @return \Google\Cloud\Security\PrivateCA\V1\DeleteCaPoolRequest
     *
     * @experimental
     */
    public static function build(string $name): self
    {
        return (new self())
            ->setName($name);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The resource name for this
     *           [CaPool][google.cloud.security.privateca.v1.CaPool] in the format
     *           `projects/&#42;&#47;locations/&#42;&#47;caPools/&#42;`.
     *     @type string $request_id
     *           Optional. An ID to identify requests. Specify a unique request ID so that
     *           if you must retry your request, the server will know to ignore the request
     *           if it has already been completed. The server will guarantee that for at
     *           least 60 minutes since the first request.
     *           For example, consider a situation where you make an initial request and
     *           the request times out. If you make the request again with the same request
     *           ID, the server can check if original operation with the same request ID
     *           was received, and if so, will ignore the second request. This prevents
     *           clients from accidentally creating duplicate commitments.
     *           The request ID must be a valid UUID with the exception that zero UUID is
     *           not supported (00000000-0000-0000-0000-000000000000).
     *     @type bool $ignore_dependent_resources
     *           Optional. This field allows this pool to be deleted even if it's being
     *           depended on by another resource. However, doing so may result in unintended
     *           and unrecoverable effects on any dependent resources since the pool will
     *           no longer be able to issue certificates.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Security\Privateca\V1\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name for this
     * [CaPool][google.cloud.security.privateca.v1.CaPool] in the format
     * `projects/&#42;&#47;locations/&#42;&#47;caPools/&#42;`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The resource name for this
     * [CaPool][google.cloud.security.privateca.v1.CaPool] in the format
     * `projects/&#42;&#47;locations/&#42;&#47;caPools/&#42;`.
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
     * Optional. An ID to identify requests. Specify a unique request ID so that
     * if you must retry your request, the server will know to ignore the request
     * if it has already been completed. The server will guarantee that for at
     * least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and
     * the request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 2 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
     * @return string
     */
    public function getRequestId()
    {
        return $this->request_id;
    }

    /**
     * Optional. An ID to identify requests. Specify a unique request ID so that
     * if you must retry your request, the server will know to ignore the request
     * if it has already been completed. The server will guarantee that for at
     * least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and
     * the request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 2 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
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
     * Optional. This field allows this pool to be deleted even if it's being
     * depended on by another resource. However, doing so may result in unintended
     * and unrecoverable effects on any dependent resources since the pool will
     * no longer be able to issue certificates.
     *
     * Generated from protobuf field <code>bool ignore_dependent_resources = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getIgnoreDependentResources()
    {
        return $this->ignore_dependent_resources;
    }

    /**
     * Optional. This field allows this pool to be deleted even if it's being
     * depended on by another resource. However, doing so may result in unintended
     * and unrecoverable effects on any dependent resources since the pool will
     * no longer be able to issue certificates.
     *
     * Generated from protobuf field <code>bool ignore_dependent_resources = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setIgnoreDependentResources($var)
    {
        GPBUtil::checkBool($var);
        $this->ignore_dependent_resources = $var;

        return $this;
    }

}

