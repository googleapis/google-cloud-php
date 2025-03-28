<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/monitoring/v3/service_service.proto

namespace Google\Cloud\Monitoring\V3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The `CreateService` request.
 *
 * Generated from protobuf message <code>google.monitoring.v3.CreateServiceRequest</code>
 */
class CreateServiceRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Resource
     * [name](https://cloud.google.com/monitoring/api/v3#project_name) of the
     * parent Metrics Scope. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Optional. The Service id to use for this Service. If omitted, an id will be
     * generated instead. Must match the pattern `[a-z0-9\-]+`
     *
     * Generated from protobuf field <code>string service_id = 3;</code>
     */
    protected $service_id = '';
    /**
     * Required. The `Service` to create.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.Service service = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $service = null;

    /**
     * @param string                              $parent  Required. Resource
     *                                                     [name](https://cloud.google.com/monitoring/api/v3#project_name) of the
     *                                                     parent Metrics Scope. The format is:
     *
     *                                                     projects/[PROJECT_ID_OR_NUMBER]
     * @param \Google\Cloud\Monitoring\V3\Service $service Required. The `Service` to create.
     *
     * @return \Google\Cloud\Monitoring\V3\CreateServiceRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Cloud\Monitoring\V3\Service $service): self
    {
        return (new self())
            ->setParent($parent)
            ->setService($service);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Resource
     *           [name](https://cloud.google.com/monitoring/api/v3#project_name) of the
     *           parent Metrics Scope. The format is:
     *               projects/[PROJECT_ID_OR_NUMBER]
     *     @type string $service_id
     *           Optional. The Service id to use for this Service. If omitted, an id will be
     *           generated instead. Must match the pattern `[a-z0-9\-]+`
     *     @type \Google\Cloud\Monitoring\V3\Service $service
     *           Required. The `Service` to create.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Monitoring\V3\ServiceService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Resource
     * [name](https://cloud.google.com/monitoring/api/v3#project_name) of the
     * parent Metrics Scope. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. Resource
     * [name](https://cloud.google.com/monitoring/api/v3#project_name) of the
     * parent Metrics Scope. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]
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
     * Optional. The Service id to use for this Service. If omitted, an id will be
     * generated instead. Must match the pattern `[a-z0-9\-]+`
     *
     * Generated from protobuf field <code>string service_id = 3;</code>
     * @return string
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * Optional. The Service id to use for this Service. If omitted, an id will be
     * generated instead. Must match the pattern `[a-z0-9\-]+`
     *
     * Generated from protobuf field <code>string service_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setServiceId($var)
    {
        GPBUtil::checkString($var, True);
        $this->service_id = $var;

        return $this;
    }

    /**
     * Required. The `Service` to create.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.Service service = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Monitoring\V3\Service|null
     */
    public function getService()
    {
        return $this->service;
    }

    public function hasService()
    {
        return isset($this->service);
    }

    public function clearService()
    {
        unset($this->service);
    }

    /**
     * Required. The `Service` to create.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.Service service = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Monitoring\V3\Service $var
     * @return $this
     */
    public function setService($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Monitoring\V3\Service::class);
        $this->service = $var;

        return $this;
    }

}

