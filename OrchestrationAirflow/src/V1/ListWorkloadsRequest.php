<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/orchestration/airflow/service/v1/environments.proto

namespace Google\Cloud\Orchestration\Airflow\Service\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request for listing workloads in a Cloud Composer environment.
 *
 * Generated from protobuf message <code>google.cloud.orchestration.airflow.service.v1.ListWorkloadsRequest</code>
 */
class ListWorkloadsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The environment name to get workloads for, in the form:
     * "projects/{projectId}/locations/{locationId}/environments/{environmentId}"
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Optional. The maximum number of environments to return.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $page_size = 0;
    /**
     * Optional. The next_page_token value returned from a previous List request,
     * if any.
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $page_token = '';
    /**
     * Optional. The list filter.
     * Currently only supports equality on the type field. The value of a field
     * specified in the filter expression must be one ComposerWorkloadType enum
     * option. It's possible to get multiple types using "OR" operator, e.g.:
     * "type=SCHEDULER OR type=CELERY_WORKER". If not specified, all items are
     * returned.
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $filter = '';

    /**
     * @param string $parent Required. The environment name to get workloads for, in the form:
     *                       "projects/{projectId}/locations/{locationId}/environments/{environmentId}"
     *                       Please see {@see EnvironmentsClient::environmentName()} for help formatting this field.
     *
     * @return \Google\Cloud\Orchestration\Airflow\Service\V1\ListWorkloadsRequest
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
     *           Required. The environment name to get workloads for, in the form:
     *           "projects/{projectId}/locations/{locationId}/environments/{environmentId}"
     *     @type int $page_size
     *           Optional. The maximum number of environments to return.
     *     @type string $page_token
     *           Optional. The next_page_token value returned from a previous List request,
     *           if any.
     *     @type string $filter
     *           Optional. The list filter.
     *           Currently only supports equality on the type field. The value of a field
     *           specified in the filter expression must be one ComposerWorkloadType enum
     *           option. It's possible to get multiple types using "OR" operator, e.g.:
     *           "type=SCHEDULER OR type=CELERY_WORKER". If not specified, all items are
     *           returned.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Orchestration\Airflow\Service\V1\Environments::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The environment name to get workloads for, in the form:
     * "projects/{projectId}/locations/{locationId}/environments/{environmentId}"
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The environment name to get workloads for, in the form:
     * "projects/{projectId}/locations/{locationId}/environments/{environmentId}"
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
     * Optional. The maximum number of environments to return.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * Optional. The maximum number of environments to return.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

    /**
     * Optional. The next_page_token value returned from a previous List request,
     * if any.
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getPageToken()
    {
        return $this->page_token;
    }

    /**
     * Optional. The next_page_token value returned from a previous List request,
     * if any.
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->page_token = $var;

        return $this;
    }

    /**
     * Optional. The list filter.
     * Currently only supports equality on the type field. The value of a field
     * specified in the filter expression must be one ComposerWorkloadType enum
     * option. It's possible to get multiple types using "OR" operator, e.g.:
     * "type=SCHEDULER OR type=CELERY_WORKER". If not specified, all items are
     * returned.
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Optional. The list filter.
     * Currently only supports equality on the type field. The value of a field
     * specified in the filter expression must be one ComposerWorkloadType enum
     * option. It's possible to get multiple types using "OR" operator, e.g.:
     * "type=SCHEDULER OR type=CELERY_WORKER". If not specified, all items are
     * returned.
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

}

