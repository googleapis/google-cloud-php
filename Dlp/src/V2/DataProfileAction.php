<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/privacy/dlp/v2/dlp.proto

namespace Google\Cloud\Dlp\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A task to execute when a data profile has been generated.
 *
 * Generated from protobuf message <code>google.privacy.dlp.v2.DataProfileAction</code>
 */
class DataProfileAction extends \Google\Protobuf\Internal\Message
{
    protected $action;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Dlp\V2\DataProfileAction\Export $export_data
     *           Export data profiles into a provided location.
     *     @type \Google\Cloud\Dlp\V2\DataProfileAction\PubSubNotification $pub_sub_notification
     *           Publish a message into the Pub/Sub topic.
     *     @type \Google\Cloud\Dlp\V2\DataProfileAction\PublishToChronicle $publish_to_chronicle
     *           Publishes generated data profiles to Google Security Operations.
     *           For more information, see [Use Sensitive Data Protection data in
     *           context-aware
     *           analytics](https://cloud.google.com/chronicle/docs/detection/usecase-dlp-high-risk-user-download).
     *     @type \Google\Cloud\Dlp\V2\DataProfileAction\PublishToSecurityCommandCenter $publish_to_scc
     *           Publishes findings to Security Command Center for each data profile.
     *     @type \Google\Cloud\Dlp\V2\DataProfileAction\TagResources $tag_resources
     *           Tags the profiled resources with the specified tag values.
     *     @type \Google\Cloud\Dlp\V2\DataProfileAction\PublishToDataplexCatalog $publish_to_dataplex_catalog
     *           Publishes a portion of each profile to Dataplex Catalog with the aspect
     *           type Sensitive Data Protection Profile.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Privacy\Dlp\V2\Dlp::initOnce();
        parent::__construct($data);
    }

    /**
     * Export data profiles into a provided location.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.Export export_data = 1;</code>
     * @return \Google\Cloud\Dlp\V2\DataProfileAction\Export|null
     */
    public function getExportData()
    {
        return $this->readOneof(1);
    }

    public function hasExportData()
    {
        return $this->hasOneof(1);
    }

    /**
     * Export data profiles into a provided location.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.Export export_data = 1;</code>
     * @param \Google\Cloud\Dlp\V2\DataProfileAction\Export $var
     * @return $this
     */
    public function setExportData($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dlp\V2\DataProfileAction\Export::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Publish a message into the Pub/Sub topic.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.PubSubNotification pub_sub_notification = 2;</code>
     * @return \Google\Cloud\Dlp\V2\DataProfileAction\PubSubNotification|null
     */
    public function getPubSubNotification()
    {
        return $this->readOneof(2);
    }

    public function hasPubSubNotification()
    {
        return $this->hasOneof(2);
    }

    /**
     * Publish a message into the Pub/Sub topic.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.PubSubNotification pub_sub_notification = 2;</code>
     * @param \Google\Cloud\Dlp\V2\DataProfileAction\PubSubNotification $var
     * @return $this
     */
    public function setPubSubNotification($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dlp\V2\DataProfileAction\PubSubNotification::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Publishes generated data profiles to Google Security Operations.
     * For more information, see [Use Sensitive Data Protection data in
     * context-aware
     * analytics](https://cloud.google.com/chronicle/docs/detection/usecase-dlp-high-risk-user-download).
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.PublishToChronicle publish_to_chronicle = 3;</code>
     * @return \Google\Cloud\Dlp\V2\DataProfileAction\PublishToChronicle|null
     */
    public function getPublishToChronicle()
    {
        return $this->readOneof(3);
    }

    public function hasPublishToChronicle()
    {
        return $this->hasOneof(3);
    }

    /**
     * Publishes generated data profiles to Google Security Operations.
     * For more information, see [Use Sensitive Data Protection data in
     * context-aware
     * analytics](https://cloud.google.com/chronicle/docs/detection/usecase-dlp-high-risk-user-download).
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.PublishToChronicle publish_to_chronicle = 3;</code>
     * @param \Google\Cloud\Dlp\V2\DataProfileAction\PublishToChronicle $var
     * @return $this
     */
    public function setPublishToChronicle($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dlp\V2\DataProfileAction\PublishToChronicle::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Publishes findings to Security Command Center for each data profile.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.PublishToSecurityCommandCenter publish_to_scc = 4;</code>
     * @return \Google\Cloud\Dlp\V2\DataProfileAction\PublishToSecurityCommandCenter|null
     */
    public function getPublishToScc()
    {
        return $this->readOneof(4);
    }

    public function hasPublishToScc()
    {
        return $this->hasOneof(4);
    }

    /**
     * Publishes findings to Security Command Center for each data profile.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.PublishToSecurityCommandCenter publish_to_scc = 4;</code>
     * @param \Google\Cloud\Dlp\V2\DataProfileAction\PublishToSecurityCommandCenter $var
     * @return $this
     */
    public function setPublishToScc($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dlp\V2\DataProfileAction\PublishToSecurityCommandCenter::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * Tags the profiled resources with the specified tag values.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.TagResources tag_resources = 8;</code>
     * @return \Google\Cloud\Dlp\V2\DataProfileAction\TagResources|null
     */
    public function getTagResources()
    {
        return $this->readOneof(8);
    }

    public function hasTagResources()
    {
        return $this->hasOneof(8);
    }

    /**
     * Tags the profiled resources with the specified tag values.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.TagResources tag_resources = 8;</code>
     * @param \Google\Cloud\Dlp\V2\DataProfileAction\TagResources $var
     * @return $this
     */
    public function setTagResources($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dlp\V2\DataProfileAction\TagResources::class);
        $this->writeOneof(8, $var);

        return $this;
    }

    /**
     * Publishes a portion of each profile to Dataplex Catalog with the aspect
     * type Sensitive Data Protection Profile.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.PublishToDataplexCatalog publish_to_dataplex_catalog = 9;</code>
     * @return \Google\Cloud\Dlp\V2\DataProfileAction\PublishToDataplexCatalog|null
     */
    public function getPublishToDataplexCatalog()
    {
        return $this->readOneof(9);
    }

    public function hasPublishToDataplexCatalog()
    {
        return $this->hasOneof(9);
    }

    /**
     * Publishes a portion of each profile to Dataplex Catalog with the aspect
     * type Sensitive Data Protection Profile.
     *
     * Generated from protobuf field <code>.google.privacy.dlp.v2.DataProfileAction.PublishToDataplexCatalog publish_to_dataplex_catalog = 9;</code>
     * @param \Google\Cloud\Dlp\V2\DataProfileAction\PublishToDataplexCatalog $var
     * @return $this
     */
    public function setPublishToDataplexCatalog($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dlp\V2\DataProfileAction\PublishToDataplexCatalog::class);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->whichOneof("action");
    }

}

