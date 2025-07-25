<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/security/privateca/v1/service.proto

namespace Google\Cloud\Security\PrivateCA\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [CertificateAuthorityService.UpdateCertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthorityService.UpdateCertificateAuthority].
 *
 * Generated from protobuf message <code>google.cloud.security.privateca.v1.UpdateCertificateAuthorityRequest</code>
 */
class UpdateCertificateAuthorityRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required.
     * [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority]
     * with updated values.
     *
     * Generated from protobuf field <code>.google.cloud.security.privateca.v1.CertificateAuthority certificate_authority = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $certificate_authority = null;
    /**
     * Required. A list of fields to be updated in this request.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $update_mask = null;
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
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
     */
    protected $request_id = '';

    /**
     * @param \Google\Cloud\Security\PrivateCA\V1\CertificateAuthority $certificateAuthority Required.
     *                                                                                       [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority]
     *                                                                                       with updated values.
     * @param \Google\Protobuf\FieldMask                               $updateMask           Required. A list of fields to be updated in this request.
     *
     * @return \Google\Cloud\Security\PrivateCA\V1\UpdateCertificateAuthorityRequest
     *
     * @experimental
     */
    public static function build(\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority $certificateAuthority, \Google\Protobuf\FieldMask $updateMask): self
    {
        return (new self())
            ->setCertificateAuthority($certificateAuthority)
            ->setUpdateMask($updateMask);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Security\PrivateCA\V1\CertificateAuthority $certificate_authority
     *           Required.
     *           [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority]
     *           with updated values.
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Required. A list of fields to be updated in this request.
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
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Security\Privateca\V1\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Required.
     * [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority]
     * with updated values.
     *
     * Generated from protobuf field <code>.google.cloud.security.privateca.v1.CertificateAuthority certificate_authority = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Security\PrivateCA\V1\CertificateAuthority|null
     */
    public function getCertificateAuthority()
    {
        return $this->certificate_authority;
    }

    public function hasCertificateAuthority()
    {
        return isset($this->certificate_authority);
    }

    public function clearCertificateAuthority()
    {
        unset($this->certificate_authority);
    }

    /**
     * Required.
     * [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority]
     * with updated values.
     *
     * Generated from protobuf field <code>.google.cloud.security.privateca.v1.CertificateAuthority certificate_authority = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Security\PrivateCA\V1\CertificateAuthority $var
     * @return $this
     */
    public function setCertificateAuthority($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Security\PrivateCA\V1\CertificateAuthority::class);
        $this->certificate_authority = $var;

        return $this;
    }

    /**
     * Required. A list of fields to be updated in this request.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
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
     * Required. A list of fields to be updated in this request.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
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
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
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
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
     * @param string $var
     * @return $this
     */
    public function setRequestId($var)
    {
        GPBUtil::checkString($var, True);
        $this->request_id = $var;

        return $this;
    }

}

