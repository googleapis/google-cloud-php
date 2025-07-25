<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/identity_mapping_store_service.proto

namespace Google\Cloud\DiscoveryEngine\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [IdentityMappingStoreService.DeleteIdentityMappingStore][google.cloud.discoveryengine.v1.IdentityMappingStoreService.DeleteIdentityMappingStore]
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.DeleteIdentityMappingStoreRequest</code>
 */
class DeleteIdentityMappingStoreRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the Identity Mapping Store to delete.
     * Format:
     * `projects/{project}/locations/{location}/identityMappingStores/{identityMappingStore}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name Required. The name of the Identity Mapping Store to delete.
     *                     Format:
     *                     `projects/{project}/locations/{location}/identityMappingStores/{identityMappingStore}`
     *                     Please see {@see IdentityMappingStoreServiceClient::identityMappingStoreName()} for help formatting this field.
     *
     * @return \Google\Cloud\DiscoveryEngine\V1\DeleteIdentityMappingStoreRequest
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
     *           Required. The name of the Identity Mapping Store to delete.
     *           Format:
     *           `projects/{project}/locations/{location}/identityMappingStores/{identityMappingStore}`
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\IdentityMappingStoreService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The name of the Identity Mapping Store to delete.
     * Format:
     * `projects/{project}/locations/{location}/identityMappingStores/{identityMappingStore}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The name of the Identity Mapping Store to delete.
     * Format:
     * `projects/{project}/locations/{location}/identityMappingStores/{identityMappingStore}`
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

}

