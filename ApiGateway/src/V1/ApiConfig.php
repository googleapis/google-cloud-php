<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/apigateway/v1/apigateway.proto

namespace Google\Cloud\ApiGateway\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * An API Configuration is a combination of settings for both the Managed
 * Service and Gateways serving this API Config.
 *
 * Generated from protobuf message <code>google.cloud.apigateway.v1.ApiConfig</code>
 */
class ApiConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. Resource name of the API Config.
     * Format: projects/{project}/locations/global/apis/{api}/configs/{api_config}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $name = '';
    /**
     * Output only. Created time.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. Updated time.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $update_time = null;
    /**
     * Optional. Resource labels to represent user-provided metadata.
     * Refer to cloud documentation on labels for more details.
     * https://cloud.google.com/compute/docs/labeling-resources
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $labels;
    /**
     * Optional. Display name.
     *
     * Generated from protobuf field <code>string display_name = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $display_name = '';
    /**
     * Immutable. The Google Cloud IAM Service Account that Gateways serving this config
     * should use to authenticate to other services. This may either be the
     * Service Account's email
     * (`{ACCOUNT_ID}&#64;{PROJECT}.iam.gserviceaccount.com`) or its full resource
     * name (`projects/{PROJECT}/accounts/{UNIQUE_ID}`). This is most often used
     * when the service is a GCP resource such as a Cloud Run Service or an
     * IAP-secured service.
     *
     * Generated from protobuf field <code>string gateway_service_account = 14 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.resource_reference) = {</code>
     */
    protected $gateway_service_account = '';
    /**
     * Output only. The ID of the associated Service Config (
     * https://cloud.google.com/service-infrastructure/docs/glossary#config).
     *
     * Generated from protobuf field <code>string service_config_id = 12 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $service_config_id = '';
    /**
     * Output only. State of the API Config.
     *
     * Generated from protobuf field <code>.google.cloud.apigateway.v1.ApiConfig.State state = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $state = 0;
    /**
     * Optional. OpenAPI specification documents. If specified, grpc_services and
     * managed_service_configs must not be included.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.OpenApiDocument openapi_documents = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $openapi_documents;
    /**
     * Optional. gRPC service definition files. If specified, openapi_documents must
     * not be included.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.GrpcServiceDefinition grpc_services = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $grpc_services;
    /**
     * Optional. Service Configuration files. At least one must be included when using gRPC
     * service definitions. See
     * https://cloud.google.com/endpoints/docs/grpc/grpc-service-config#service_configuration_overview
     * for the expected file contents.
     * If multiple files are specified, the files are merged with the following
     * rules:
     * * All singular scalar fields are merged using "last one wins" semantics in
     * the order of the files uploaded.
     * * Repeated fields are concatenated.
     * * Singular embedded messages are merged using these rules for nested
     * fields.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.File managed_service_configs = 11 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $managed_service_configs;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Output only. Resource name of the API Config.
     *           Format: projects/{project}/locations/global/apis/{api}/configs/{api_config}
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. Created time.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. Updated time.
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           Optional. Resource labels to represent user-provided metadata.
     *           Refer to cloud documentation on labels for more details.
     *           https://cloud.google.com/compute/docs/labeling-resources
     *     @type string $display_name
     *           Optional. Display name.
     *     @type string $gateway_service_account
     *           Immutable. The Google Cloud IAM Service Account that Gateways serving this config
     *           should use to authenticate to other services. This may either be the
     *           Service Account's email
     *           (`{ACCOUNT_ID}&#64;{PROJECT}.iam.gserviceaccount.com`) or its full resource
     *           name (`projects/{PROJECT}/accounts/{UNIQUE_ID}`). This is most often used
     *           when the service is a GCP resource such as a Cloud Run Service or an
     *           IAP-secured service.
     *     @type string $service_config_id
     *           Output only. The ID of the associated Service Config (
     *           https://cloud.google.com/service-infrastructure/docs/glossary#config).
     *     @type int $state
     *           Output only. State of the API Config.
     *     @type array<\Google\Cloud\ApiGateway\V1\ApiConfig\OpenApiDocument>|\Google\Protobuf\Internal\RepeatedField $openapi_documents
     *           Optional. OpenAPI specification documents. If specified, grpc_services and
     *           managed_service_configs must not be included.
     *     @type array<\Google\Cloud\ApiGateway\V1\ApiConfig\GrpcServiceDefinition>|\Google\Protobuf\Internal\RepeatedField $grpc_services
     *           Optional. gRPC service definition files. If specified, openapi_documents must
     *           not be included.
     *     @type array<\Google\Cloud\ApiGateway\V1\ApiConfig\File>|\Google\Protobuf\Internal\RepeatedField $managed_service_configs
     *           Optional. Service Configuration files. At least one must be included when using gRPC
     *           service definitions. See
     *           https://cloud.google.com/endpoints/docs/grpc/grpc-service-config#service_configuration_overview
     *           for the expected file contents.
     *           If multiple files are specified, the files are merged with the following
     *           rules:
     *           * All singular scalar fields are merged using "last one wins" semantics in
     *           the order of the files uploaded.
     *           * Repeated fields are concatenated.
     *           * Singular embedded messages are merged using these rules for nested
     *           fields.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Apigateway\V1\Apigateway::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. Resource name of the API Config.
     * Format: projects/{project}/locations/global/apis/{api}/configs/{api_config}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Output only. Resource name of the API Config.
     * Format: projects/{project}/locations/global/apis/{api}/configs/{api_config}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
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
     * Output only. Created time.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function hasCreateTime()
    {
        return isset($this->create_time);
    }

    public function clearCreateTime()
    {
        unset($this->create_time);
    }

    /**
     * Output only. Created time.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCreateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->create_time = $var;

        return $this;
    }

    /**
     * Output only. Updated time.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    public function hasUpdateTime()
    {
        return isset($this->update_time);
    }

    public function clearUpdateTime()
    {
        unset($this->update_time);
    }

    /**
     * Output only. Updated time.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setUpdateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->update_time = $var;

        return $this;
    }

    /**
     * Optional. Resource labels to represent user-provided metadata.
     * Refer to cloud documentation on labels for more details.
     * https://cloud.google.com/compute/docs/labeling-resources
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Optional. Resource labels to represent user-provided metadata.
     * Refer to cloud documentation on labels for more details.
     * https://cloud.google.com/compute/docs/labeling-resources
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;

        return $this;
    }

    /**
     * Optional. Display name.
     *
     * Generated from protobuf field <code>string display_name = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Optional. Display name.
     *
     * Generated from protobuf field <code>string display_name = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
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
     * Immutable. The Google Cloud IAM Service Account that Gateways serving this config
     * should use to authenticate to other services. This may either be the
     * Service Account's email
     * (`{ACCOUNT_ID}&#64;{PROJECT}.iam.gserviceaccount.com`) or its full resource
     * name (`projects/{PROJECT}/accounts/{UNIQUE_ID}`). This is most often used
     * when the service is a GCP resource such as a Cloud Run Service or an
     * IAP-secured service.
     *
     * Generated from protobuf field <code>string gateway_service_account = 14 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getGatewayServiceAccount()
    {
        return $this->gateway_service_account;
    }

    /**
     * Immutable. The Google Cloud IAM Service Account that Gateways serving this config
     * should use to authenticate to other services. This may either be the
     * Service Account's email
     * (`{ACCOUNT_ID}&#64;{PROJECT}.iam.gserviceaccount.com`) or its full resource
     * name (`projects/{PROJECT}/accounts/{UNIQUE_ID}`). This is most often used
     * when the service is a GCP resource such as a Cloud Run Service or an
     * IAP-secured service.
     *
     * Generated from protobuf field <code>string gateway_service_account = 14 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setGatewayServiceAccount($var)
    {
        GPBUtil::checkString($var, True);
        $this->gateway_service_account = $var;

        return $this;
    }

    /**
     * Output only. The ID of the associated Service Config (
     * https://cloud.google.com/service-infrastructure/docs/glossary#config).
     *
     * Generated from protobuf field <code>string service_config_id = 12 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getServiceConfigId()
    {
        return $this->service_config_id;
    }

    /**
     * Output only. The ID of the associated Service Config (
     * https://cloud.google.com/service-infrastructure/docs/glossary#config).
     *
     * Generated from protobuf field <code>string service_config_id = 12 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setServiceConfigId($var)
    {
        GPBUtil::checkString($var, True);
        $this->service_config_id = $var;

        return $this;
    }

    /**
     * Output only. State of the API Config.
     *
     * Generated from protobuf field <code>.google.cloud.apigateway.v1.ApiConfig.State state = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Output only. State of the API Config.
     *
     * Generated from protobuf field <code>.google.cloud.apigateway.v1.ApiConfig.State state = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\ApiGateway\V1\ApiConfig\State::class);
        $this->state = $var;

        return $this;
    }

    /**
     * Optional. OpenAPI specification documents. If specified, grpc_services and
     * managed_service_configs must not be included.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.OpenApiDocument openapi_documents = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getOpenapiDocuments()
    {
        return $this->openapi_documents;
    }

    /**
     * Optional. OpenAPI specification documents. If specified, grpc_services and
     * managed_service_configs must not be included.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.OpenApiDocument openapi_documents = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Cloud\ApiGateway\V1\ApiConfig\OpenApiDocument>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setOpenapiDocuments($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\ApiGateway\V1\ApiConfig\OpenApiDocument::class);
        $this->openapi_documents = $arr;

        return $this;
    }

    /**
     * Optional. gRPC service definition files. If specified, openapi_documents must
     * not be included.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.GrpcServiceDefinition grpc_services = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getGrpcServices()
    {
        return $this->grpc_services;
    }

    /**
     * Optional. gRPC service definition files. If specified, openapi_documents must
     * not be included.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.GrpcServiceDefinition grpc_services = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Cloud\ApiGateway\V1\ApiConfig\GrpcServiceDefinition>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setGrpcServices($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\ApiGateway\V1\ApiConfig\GrpcServiceDefinition::class);
        $this->grpc_services = $arr;

        return $this;
    }

    /**
     * Optional. Service Configuration files. At least one must be included when using gRPC
     * service definitions. See
     * https://cloud.google.com/endpoints/docs/grpc/grpc-service-config#service_configuration_overview
     * for the expected file contents.
     * If multiple files are specified, the files are merged with the following
     * rules:
     * * All singular scalar fields are merged using "last one wins" semantics in
     * the order of the files uploaded.
     * * Repeated fields are concatenated.
     * * Singular embedded messages are merged using these rules for nested
     * fields.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.File managed_service_configs = 11 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getManagedServiceConfigs()
    {
        return $this->managed_service_configs;
    }

    /**
     * Optional. Service Configuration files. At least one must be included when using gRPC
     * service definitions. See
     * https://cloud.google.com/endpoints/docs/grpc/grpc-service-config#service_configuration_overview
     * for the expected file contents.
     * If multiple files are specified, the files are merged with the following
     * rules:
     * * All singular scalar fields are merged using "last one wins" semantics in
     * the order of the files uploaded.
     * * Repeated fields are concatenated.
     * * Singular embedded messages are merged using these rules for nested
     * fields.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apigateway.v1.ApiConfig.File managed_service_configs = 11 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Cloud\ApiGateway\V1\ApiConfig\File>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setManagedServiceConfigs($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\ApiGateway\V1\ApiConfig\File::class);
        $this->managed_service_configs = $arr;

        return $this;
    }

}

