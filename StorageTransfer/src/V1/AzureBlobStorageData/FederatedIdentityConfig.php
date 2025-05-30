<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/storagetransfer/v1/transfer_types.proto

namespace Google\Cloud\StorageTransfer\V1\AzureBlobStorageData;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The identity of an Azure application through which Storage Transfer Service
 * can authenticate requests using Azure workload identity federation.
 * Storage Transfer Service can issue requests to Azure Storage through
 * registered Azure applications, eliminating the need to pass credentials to
 * Storage Transfer Service directly.
 * To configure federated identity, see
 * [Configure access to Microsoft Azure
 * Storage](https://cloud.google.com/storage-transfer/docs/source-microsoft-azure#option_3_authenticate_using_federated_identity).
 *
 * Generated from protobuf message <code>google.storagetransfer.v1.AzureBlobStorageData.FederatedIdentityConfig</code>
 */
class FederatedIdentityConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The client (application) ID of the application with federated
     * credentials.
     *
     * Generated from protobuf field <code>string client_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $client_id = '';
    /**
     * Required. The tenant (directory) ID of the application with federated
     * credentials.
     *
     * Generated from protobuf field <code>string tenant_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $tenant_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $client_id
     *           Required. The client (application) ID of the application with federated
     *           credentials.
     *     @type string $tenant_id
     *           Required. The tenant (directory) ID of the application with federated
     *           credentials.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Storagetransfer\V1\TransferTypes::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The client (application) ID of the application with federated
     * credentials.
     *
     * Generated from protobuf field <code>string client_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Required. The client (application) ID of the application with federated
     * credentials.
     *
     * Generated from protobuf field <code>string client_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setClientId($var)
    {
        GPBUtil::checkString($var, True);
        $this->client_id = $var;

        return $this;
    }

    /**
     * Required. The tenant (directory) ID of the application with federated
     * credentials.
     *
     * Generated from protobuf field <code>string tenant_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenant_id;
    }

    /**
     * Required. The tenant (directory) ID of the application with federated
     * credentials.
     *
     * Generated from protobuf field <code>string tenant_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setTenantId($var)
    {
        GPBUtil::checkString($var, True);
        $this->tenant_id = $var;

        return $this;
    }

}


