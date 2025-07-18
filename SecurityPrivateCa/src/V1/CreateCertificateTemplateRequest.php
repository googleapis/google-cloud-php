<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/security/privateca/v1/service.proto

namespace Google\Cloud\Security\PrivateCA\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [CertificateAuthorityService.CreateCertificateTemplate][google.cloud.security.privateca.v1.CertificateAuthorityService.CreateCertificateTemplate].
 *
 * Generated from protobuf message <code>google.cloud.security.privateca.v1.CreateCertificateTemplateRequest</code>
 */
class CreateCertificateTemplateRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the location associated with the
     * [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate],
     * in the format `projects/&#42;&#47;locations/&#42;`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. It must be unique within a location and match the regular
     * expression `[a-zA-Z0-9_-]{1,63}`
     *
     * Generated from protobuf field <code>string certificate_template_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $certificate_template_id = '';
    /**
     * Required. A
     * [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate]
     * with initial field values.
     *
     * Generated from protobuf field <code>.google.cloud.security.privateca.v1.CertificateTemplate certificate_template = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $certificate_template = null;
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
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
     */
    protected $request_id = '';

    /**
     * @param string                                                  $parent                Required. The resource name of the location associated with the
     *                                                                                       [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate],
     *                                                                                       in the format `projects/&#42;/locations/*`. Please see
     *                                                                                       {@see CertificateAuthorityServiceClient::locationName()} for help formatting this field.
     * @param \Google\Cloud\Security\PrivateCA\V1\CertificateTemplate $certificateTemplate   Required. A
     *                                                                                       [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate]
     *                                                                                       with initial field values.
     * @param string                                                  $certificateTemplateId Required. It must be unique within a location and match the regular
     *                                                                                       expression `[a-zA-Z0-9_-]{1,63}`
     *
     * @return \Google\Cloud\Security\PrivateCA\V1\CreateCertificateTemplateRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Cloud\Security\PrivateCA\V1\CertificateTemplate $certificateTemplate, string $certificateTemplateId): self
    {
        return (new self())
            ->setParent($parent)
            ->setCertificateTemplate($certificateTemplate)
            ->setCertificateTemplateId($certificateTemplateId);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The resource name of the location associated with the
     *           [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate],
     *           in the format `projects/&#42;&#47;locations/&#42;`.
     *     @type string $certificate_template_id
     *           Required. It must be unique within a location and match the regular
     *           expression `[a-zA-Z0-9_-]{1,63}`
     *     @type \Google\Cloud\Security\PrivateCA\V1\CertificateTemplate $certificate_template
     *           Required. A
     *           [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate]
     *           with initial field values.
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
     * Required. The resource name of the location associated with the
     * [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate],
     * in the format `projects/&#42;&#47;locations/&#42;`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The resource name of the location associated with the
     * [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate],
     * in the format `projects/&#42;&#47;locations/&#42;`.
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
     * Required. It must be unique within a location and match the regular
     * expression `[a-zA-Z0-9_-]{1,63}`
     *
     * Generated from protobuf field <code>string certificate_template_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getCertificateTemplateId()
    {
        return $this->certificate_template_id;
    }

    /**
     * Required. It must be unique within a location and match the regular
     * expression `[a-zA-Z0-9_-]{1,63}`
     *
     * Generated from protobuf field <code>string certificate_template_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setCertificateTemplateId($var)
    {
        GPBUtil::checkString($var, True);
        $this->certificate_template_id = $var;

        return $this;
    }

    /**
     * Required. A
     * [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate]
     * with initial field values.
     *
     * Generated from protobuf field <code>.google.cloud.security.privateca.v1.CertificateTemplate certificate_template = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Security\PrivateCA\V1\CertificateTemplate|null
     */
    public function getCertificateTemplate()
    {
        return $this->certificate_template;
    }

    public function hasCertificateTemplate()
    {
        return isset($this->certificate_template);
    }

    public function clearCertificateTemplate()
    {
        unset($this->certificate_template);
    }

    /**
     * Required. A
     * [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate]
     * with initial field values.
     *
     * Generated from protobuf field <code>.google.cloud.security.privateca.v1.CertificateTemplate certificate_template = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Security\PrivateCA\V1\CertificateTemplate $var
     * @return $this
     */
    public function setCertificateTemplate($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Security\PrivateCA\V1\CertificateTemplate::class);
        $this->certificate_template = $var;

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
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
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
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.field_info) = {</code>
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

