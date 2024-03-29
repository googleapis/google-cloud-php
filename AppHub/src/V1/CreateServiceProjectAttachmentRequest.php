<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/apphub/v1/apphub_service.proto

namespace Google\Cloud\AppHub\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request for CreateServiceProjectAttachment.
 *
 * Generated from protobuf message <code>google.cloud.apphub.v1.CreateServiceProjectAttachmentRequest</code>
 */
class CreateServiceProjectAttachmentRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Host project ID and location to which service project is being
     * attached. Only global location is supported. Expected format:
     * `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. The service project attachment identifier must contain the
     * project id of the service project specified in the
     * service_project_attachment.service_project field.
     *
     * Generated from protobuf field <code>string service_project_attachment_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $service_project_attachment_id = '';
    /**
     * Required. The resource being created.
     *
     * Generated from protobuf field <code>.google.cloud.apphub.v1.ServiceProjectAttachment service_project_attachment = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $service_project_attachment = null;
    /**
     * Optional. An optional request ID to identify requests. Specify a unique
     * request ID so that if you must retry your request, the server will know to
     * ignore the request if it has already been completed. The server will
     * guarantee that for at least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $request_id = '';

    /**
     * @param string                                           $parent                     Required. Host project ID and location to which service project is being
     *                                                                                     attached. Only global location is supported. Expected format:
     *                                                                                     `projects/{project}/locations/{location}`. Please see
     *                                                                                     {@see AppHubClient::locationName()} for help formatting this field.
     * @param \Google\Cloud\AppHub\V1\ServiceProjectAttachment $serviceProjectAttachment   Required. The resource being created.
     * @param string                                           $serviceProjectAttachmentId Required. The service project attachment identifier must contain the
     *                                                                                     project id of the service project specified in the
     *                                                                                     service_project_attachment.service_project field.
     *
     * @return \Google\Cloud\AppHub\V1\CreateServiceProjectAttachmentRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Cloud\AppHub\V1\ServiceProjectAttachment $serviceProjectAttachment, string $serviceProjectAttachmentId): self
    {
        return (new self())
            ->setParent($parent)
            ->setServiceProjectAttachment($serviceProjectAttachment)
            ->setServiceProjectAttachmentId($serviceProjectAttachmentId);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Host project ID and location to which service project is being
     *           attached. Only global location is supported. Expected format:
     *           `projects/{project}/locations/{location}`.
     *     @type string $service_project_attachment_id
     *           Required. The service project attachment identifier must contain the
     *           project id of the service project specified in the
     *           service_project_attachment.service_project field.
     *     @type \Google\Cloud\AppHub\V1\ServiceProjectAttachment $service_project_attachment
     *           Required. The resource being created.
     *     @type string $request_id
     *           Optional. An optional request ID to identify requests. Specify a unique
     *           request ID so that if you must retry your request, the server will know to
     *           ignore the request if it has already been completed. The server will
     *           guarantee that for at least 60 minutes since the first request.
     *           For example, consider a situation where you make an initial request and the
     *           request times out. If you make the request again with the same request
     *           ID, the server can check if original operation with the same request ID
     *           was received, and if so, will ignore the second request. This prevents
     *           clients from accidentally creating duplicate commitments.
     *           The request ID must be a valid UUID with the exception that zero UUID is
     *           not supported (00000000-0000-0000-0000-000000000000).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Apphub\V1\ApphubService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Host project ID and location to which service project is being
     * attached. Only global location is supported. Expected format:
     * `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. Host project ID and location to which service project is being
     * attached. Only global location is supported. Expected format:
     * `projects/{project}/locations/{location}`.
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
     * Required. The service project attachment identifier must contain the
     * project id of the service project specified in the
     * service_project_attachment.service_project field.
     *
     * Generated from protobuf field <code>string service_project_attachment_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getServiceProjectAttachmentId()
    {
        return $this->service_project_attachment_id;
    }

    /**
     * Required. The service project attachment identifier must contain the
     * project id of the service project specified in the
     * service_project_attachment.service_project field.
     *
     * Generated from protobuf field <code>string service_project_attachment_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setServiceProjectAttachmentId($var)
    {
        GPBUtil::checkString($var, True);
        $this->service_project_attachment_id = $var;

        return $this;
    }

    /**
     * Required. The resource being created.
     *
     * Generated from protobuf field <code>.google.cloud.apphub.v1.ServiceProjectAttachment service_project_attachment = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\AppHub\V1\ServiceProjectAttachment|null
     */
    public function getServiceProjectAttachment()
    {
        return $this->service_project_attachment;
    }

    public function hasServiceProjectAttachment()
    {
        return isset($this->service_project_attachment);
    }

    public function clearServiceProjectAttachment()
    {
        unset($this->service_project_attachment);
    }

    /**
     * Required. The resource being created.
     *
     * Generated from protobuf field <code>.google.cloud.apphub.v1.ServiceProjectAttachment service_project_attachment = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\AppHub\V1\ServiceProjectAttachment $var
     * @return $this
     */
    public function setServiceProjectAttachment($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AppHub\V1\ServiceProjectAttachment::class);
        $this->service_project_attachment = $var;

        return $this;
    }

    /**
     * Optional. An optional request ID to identify requests. Specify a unique
     * request ID so that if you must retry your request, the server will know to
     * ignore the request if it has already been completed. The server will
     * guarantee that for at least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getRequestId()
    {
        return $this->request_id;
    }

    /**
     * Optional. An optional request ID to identify requests. Specify a unique
     * request ID so that if you must retry your request, the server will know to
     * ignore the request if it has already been completed. The server will
     * guarantee that for at least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
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

