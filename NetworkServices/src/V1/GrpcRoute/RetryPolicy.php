<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkservices/v1/grpc_route.proto

namespace Google\Cloud\NetworkServices\V1\GrpcRoute;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The specifications for retries.
 * Specifies one or more conditions for which this retry rule applies. Valid
 * values are:
 *
 * Generated from protobuf message <code>google.cloud.networkservices.v1.GrpcRoute.RetryPolicy</code>
 */
class RetryPolicy extends \Google\Protobuf\Internal\Message
{
    /**
     * - connect-failure: Router will retry on failures connecting to Backend
     *    Services, for example due to connection timeouts.
     * - refused-stream: Router will retry if the backend service resets the
     * stream
     *    with a REFUSED_STREAM error code. This reset type indicates that it is
     *    safe to retry.
     * - cancelled: Router will retry if the gRPC status code in the response
     * header
     *    is set to cancelled
     * - deadline-exceeded: Router will retry if the gRPC status code in the
     * response
     *    header is set to deadline-exceeded
     * - resource-exhausted: Router will retry if the gRPC status code in the
     *    response header is set to resource-exhausted
     * - unavailable: Router will retry if the gRPC status code in the response
     *    header is set to unavailable
     *
     * Generated from protobuf field <code>repeated string retry_conditions = 1;</code>
     */
    private $retry_conditions;
    /**
     * Specifies the allowed number of retries. This number must be > 0. If not
     * specified, default to 1.
     *
     * Generated from protobuf field <code>uint32 num_retries = 2;</code>
     */
    protected $num_retries = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $retry_conditions
     *           - connect-failure: Router will retry on failures connecting to Backend
     *              Services, for example due to connection timeouts.
     *           - refused-stream: Router will retry if the backend service resets the
     *           stream
     *              with a REFUSED_STREAM error code. This reset type indicates that it is
     *              safe to retry.
     *           - cancelled: Router will retry if the gRPC status code in the response
     *           header
     *              is set to cancelled
     *           - deadline-exceeded: Router will retry if the gRPC status code in the
     *           response
     *              header is set to deadline-exceeded
     *           - resource-exhausted: Router will retry if the gRPC status code in the
     *              response header is set to resource-exhausted
     *           - unavailable: Router will retry if the gRPC status code in the response
     *              header is set to unavailable
     *     @type int $num_retries
     *           Specifies the allowed number of retries. This number must be > 0. If not
     *           specified, default to 1.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networkservices\V1\GrpcRoute::initOnce();
        parent::__construct($data);
    }

    /**
     * - connect-failure: Router will retry on failures connecting to Backend
     *    Services, for example due to connection timeouts.
     * - refused-stream: Router will retry if the backend service resets the
     * stream
     *    with a REFUSED_STREAM error code. This reset type indicates that it is
     *    safe to retry.
     * - cancelled: Router will retry if the gRPC status code in the response
     * header
     *    is set to cancelled
     * - deadline-exceeded: Router will retry if the gRPC status code in the
     * response
     *    header is set to deadline-exceeded
     * - resource-exhausted: Router will retry if the gRPC status code in the
     *    response header is set to resource-exhausted
     * - unavailable: Router will retry if the gRPC status code in the response
     *    header is set to unavailable
     *
     * Generated from protobuf field <code>repeated string retry_conditions = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRetryConditions()
    {
        return $this->retry_conditions;
    }

    /**
     * - connect-failure: Router will retry on failures connecting to Backend
     *    Services, for example due to connection timeouts.
     * - refused-stream: Router will retry if the backend service resets the
     * stream
     *    with a REFUSED_STREAM error code. This reset type indicates that it is
     *    safe to retry.
     * - cancelled: Router will retry if the gRPC status code in the response
     * header
     *    is set to cancelled
     * - deadline-exceeded: Router will retry if the gRPC status code in the
     * response
     *    header is set to deadline-exceeded
     * - resource-exhausted: Router will retry if the gRPC status code in the
     *    response header is set to resource-exhausted
     * - unavailable: Router will retry if the gRPC status code in the response
     *    header is set to unavailable
     *
     * Generated from protobuf field <code>repeated string retry_conditions = 1;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRetryConditions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->retry_conditions = $arr;

        return $this;
    }

    /**
     * Specifies the allowed number of retries. This number must be > 0. If not
     * specified, default to 1.
     *
     * Generated from protobuf field <code>uint32 num_retries = 2;</code>
     * @return int
     */
    public function getNumRetries()
    {
        return $this->num_retries;
    }

    /**
     * Specifies the allowed number of retries. This number must be > 0. If not
     * specified, default to 1.
     *
     * Generated from protobuf field <code>uint32 num_retries = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setNumRetries($var)
    {
        GPBUtil::checkUint32($var);
        $this->num_retries = $var;

        return $this;
    }

}


