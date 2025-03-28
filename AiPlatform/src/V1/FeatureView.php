<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/feature_view.proto

namespace Google\Cloud\AIPlatform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * FeatureView is representation of values that the FeatureOnlineStore will
 * serve based on its syncConfig.
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.FeatureView</code>
 */
class FeatureView extends \Google\Protobuf\Internal\Message
{
    /**
     * Identifier. Name of the FeatureView. Format:
     * `projects/{project}/locations/{location}/featureOnlineStores/{feature_online_store}/featureViews/{feature_view}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    /**
     * Output only. Timestamp when this FeatureView was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. Timestamp when this FeatureView was last updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $update_time = null;
    /**
     * Optional. Used to perform consistent read-modify-write updates. If not set,
     * a blind "overwrite" update happens.
     *
     * Generated from protobuf field <code>string etag = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $etag = '';
    /**
     * Optional. The labels with user-defined metadata to organize your
     * FeatureViews.
     * Label keys and values can be no longer than 64 characters
     * (Unicode codepoints), can only contain lowercase letters, numeric
     * characters, underscores and dashes. International characters are allowed.
     * See https://goo.gl/xmQnxf for more information on and examples of labels.
     * No more than 64 user labels can be associated with one
     * FeatureOnlineStore(System labels are excluded)." System reserved label keys
     * are prefixed with "aiplatform.googleapis.com/" and are immutable.
     *
     * Generated from protobuf field <code>map<string, string> labels = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $labels;
    /**
     * Configures when data is to be synced/updated for this FeatureView. At the
     * end of the sync the latest featureValues for each entityId of this
     * FeatureView are made ready for online serving.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.SyncConfig sync_config = 7;</code>
     */
    protected $sync_config = null;
    /**
     * Optional. Configuration for index preparation for vector search. It
     * contains the required configurations to create an index from source data,
     * so that approximate nearest neighbor (a.k.a ANN) algorithms search can be
     * performed during online serving.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.IndexConfig index_config = 15 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $index_config = null;
    /**
     * Optional. Configuration for FeatureView created under Optimized
     * FeatureOnlineStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.OptimizedConfig optimized_config = 16 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $optimized_config = null;
    /**
     * Optional. Service agent type used during data sync. By default, the Vertex
     * AI Service Agent is used. When using an IAM Policy to isolate this
     * FeatureView within a project, a separate service account should be
     * provisioned by setting this field to `SERVICE_AGENT_TYPE_FEATURE_VIEW`.
     * This will generate a separate service account to access the BigQuery source
     * table.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.ServiceAgentType service_agent_type = 14 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $service_agent_type = 0;
    /**
     * Output only. A Service Account unique to this FeatureView. The role
     * bigquery.dataViewer should be granted to this service account to allow
     * Vertex AI Feature Store to sync data to the online store.
     *
     * Generated from protobuf field <code>string service_account_email = 13 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $service_account_email = '';
    /**
     * Output only. Reserved for future use.
     *
     * Generated from protobuf field <code>bool satisfies_pzs = 19 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $satisfies_pzs = false;
    /**
     * Output only. Reserved for future use.
     *
     * Generated from protobuf field <code>bool satisfies_pzi = 20 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $satisfies_pzi = false;
    protected $source;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\AIPlatform\V1\FeatureView\BigQuerySource $big_query_source
     *           Optional. Configures how data is supposed to be extracted from a BigQuery
     *           source to be loaded onto the FeatureOnlineStore.
     *     @type \Google\Cloud\AIPlatform\V1\FeatureView\FeatureRegistrySource $feature_registry_source
     *           Optional. Configures the features from a Feature Registry source that
     *           need to be loaded onto the FeatureOnlineStore.
     *     @type \Google\Cloud\AIPlatform\V1\FeatureView\VertexRagSource $vertex_rag_source
     *           Optional. The Vertex RAG Source that the FeatureView is linked to.
     *     @type string $name
     *           Identifier. Name of the FeatureView. Format:
     *           `projects/{project}/locations/{location}/featureOnlineStores/{feature_online_store}/featureViews/{feature_view}`
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. Timestamp when this FeatureView was created.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. Timestamp when this FeatureView was last updated.
     *     @type string $etag
     *           Optional. Used to perform consistent read-modify-write updates. If not set,
     *           a blind "overwrite" update happens.
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           Optional. The labels with user-defined metadata to organize your
     *           FeatureViews.
     *           Label keys and values can be no longer than 64 characters
     *           (Unicode codepoints), can only contain lowercase letters, numeric
     *           characters, underscores and dashes. International characters are allowed.
     *           See https://goo.gl/xmQnxf for more information on and examples of labels.
     *           No more than 64 user labels can be associated with one
     *           FeatureOnlineStore(System labels are excluded)." System reserved label keys
     *           are prefixed with "aiplatform.googleapis.com/" and are immutable.
     *     @type \Google\Cloud\AIPlatform\V1\FeatureView\SyncConfig $sync_config
     *           Configures when data is to be synced/updated for this FeatureView. At the
     *           end of the sync the latest featureValues for each entityId of this
     *           FeatureView are made ready for online serving.
     *     @type \Google\Cloud\AIPlatform\V1\FeatureView\IndexConfig $index_config
     *           Optional. Configuration for index preparation for vector search. It
     *           contains the required configurations to create an index from source data,
     *           so that approximate nearest neighbor (a.k.a ANN) algorithms search can be
     *           performed during online serving.
     *     @type \Google\Cloud\AIPlatform\V1\FeatureView\OptimizedConfig $optimized_config
     *           Optional. Configuration for FeatureView created under Optimized
     *           FeatureOnlineStore.
     *     @type int $service_agent_type
     *           Optional. Service agent type used during data sync. By default, the Vertex
     *           AI Service Agent is used. When using an IAM Policy to isolate this
     *           FeatureView within a project, a separate service account should be
     *           provisioned by setting this field to `SERVICE_AGENT_TYPE_FEATURE_VIEW`.
     *           This will generate a separate service account to access the BigQuery source
     *           table.
     *     @type string $service_account_email
     *           Output only. A Service Account unique to this FeatureView. The role
     *           bigquery.dataViewer should be granted to this service account to allow
     *           Vertex AI Feature Store to sync data to the online store.
     *     @type bool $satisfies_pzs
     *           Output only. Reserved for future use.
     *     @type bool $satisfies_pzi
     *           Output only. Reserved for future use.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\FeatureView::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Configures how data is supposed to be extracted from a BigQuery
     * source to be loaded onto the FeatureOnlineStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.BigQuerySource big_query_source = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\AIPlatform\V1\FeatureView\BigQuerySource|null
     */
    public function getBigQuerySource()
    {
        return $this->readOneof(6);
    }

    public function hasBigQuerySource()
    {
        return $this->hasOneof(6);
    }

    /**
     * Optional. Configures how data is supposed to be extracted from a BigQuery
     * source to be loaded onto the FeatureOnlineStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.BigQuerySource big_query_source = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\AIPlatform\V1\FeatureView\BigQuerySource $var
     * @return $this
     */
    public function setBigQuerySource($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\FeatureView\BigQuerySource::class);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * Optional. Configures the features from a Feature Registry source that
     * need to be loaded onto the FeatureOnlineStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.FeatureRegistrySource feature_registry_source = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\AIPlatform\V1\FeatureView\FeatureRegistrySource|null
     */
    public function getFeatureRegistrySource()
    {
        return $this->readOneof(9);
    }

    public function hasFeatureRegistrySource()
    {
        return $this->hasOneof(9);
    }

    /**
     * Optional. Configures the features from a Feature Registry source that
     * need to be loaded onto the FeatureOnlineStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.FeatureRegistrySource feature_registry_source = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\AIPlatform\V1\FeatureView\FeatureRegistrySource $var
     * @return $this
     */
    public function setFeatureRegistrySource($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\FeatureView\FeatureRegistrySource::class);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * Optional. The Vertex RAG Source that the FeatureView is linked to.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.VertexRagSource vertex_rag_source = 18 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\AIPlatform\V1\FeatureView\VertexRagSource|null
     */
    public function getVertexRagSource()
    {
        return $this->readOneof(18);
    }

    public function hasVertexRagSource()
    {
        return $this->hasOneof(18);
    }

    /**
     * Optional. The Vertex RAG Source that the FeatureView is linked to.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.VertexRagSource vertex_rag_source = 18 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\AIPlatform\V1\FeatureView\VertexRagSource $var
     * @return $this
     */
    public function setVertexRagSource($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\FeatureView\VertexRagSource::class);
        $this->writeOneof(18, $var);

        return $this;
    }

    /**
     * Identifier. Name of the FeatureView. Format:
     * `projects/{project}/locations/{location}/featureOnlineStores/{feature_online_store}/featureViews/{feature_view}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. Name of the FeatureView. Format:
     * `projects/{project}/locations/{location}/featureOnlineStores/{feature_online_store}/featureViews/{feature_view}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
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
     * Output only. Timestamp when this FeatureView was created.
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
     * Output only. Timestamp when this FeatureView was created.
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
     * Output only. Timestamp when this FeatureView was last updated.
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
     * Output only. Timestamp when this FeatureView was last updated.
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
     * Optional. Used to perform consistent read-modify-write updates. If not set,
     * a blind "overwrite" update happens.
     *
     * Generated from protobuf field <code>string etag = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * Optional. Used to perform consistent read-modify-write updates. If not set,
     * a blind "overwrite" update happens.
     *
     * Generated from protobuf field <code>string etag = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setEtag($var)
    {
        GPBUtil::checkString($var, True);
        $this->etag = $var;

        return $this;
    }

    /**
     * Optional. The labels with user-defined metadata to organize your
     * FeatureViews.
     * Label keys and values can be no longer than 64 characters
     * (Unicode codepoints), can only contain lowercase letters, numeric
     * characters, underscores and dashes. International characters are allowed.
     * See https://goo.gl/xmQnxf for more information on and examples of labels.
     * No more than 64 user labels can be associated with one
     * FeatureOnlineStore(System labels are excluded)." System reserved label keys
     * are prefixed with "aiplatform.googleapis.com/" and are immutable.
     *
     * Generated from protobuf field <code>map<string, string> labels = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Optional. The labels with user-defined metadata to organize your
     * FeatureViews.
     * Label keys and values can be no longer than 64 characters
     * (Unicode codepoints), can only contain lowercase letters, numeric
     * characters, underscores and dashes. International characters are allowed.
     * See https://goo.gl/xmQnxf for more information on and examples of labels.
     * No more than 64 user labels can be associated with one
     * FeatureOnlineStore(System labels are excluded)." System reserved label keys
     * are prefixed with "aiplatform.googleapis.com/" and are immutable.
     *
     * Generated from protobuf field <code>map<string, string> labels = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
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
     * Configures when data is to be synced/updated for this FeatureView. At the
     * end of the sync the latest featureValues for each entityId of this
     * FeatureView are made ready for online serving.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.SyncConfig sync_config = 7;</code>
     * @return \Google\Cloud\AIPlatform\V1\FeatureView\SyncConfig|null
     */
    public function getSyncConfig()
    {
        return $this->sync_config;
    }

    public function hasSyncConfig()
    {
        return isset($this->sync_config);
    }

    public function clearSyncConfig()
    {
        unset($this->sync_config);
    }

    /**
     * Configures when data is to be synced/updated for this FeatureView. At the
     * end of the sync the latest featureValues for each entityId of this
     * FeatureView are made ready for online serving.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.SyncConfig sync_config = 7;</code>
     * @param \Google\Cloud\AIPlatform\V1\FeatureView\SyncConfig $var
     * @return $this
     */
    public function setSyncConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\FeatureView\SyncConfig::class);
        $this->sync_config = $var;

        return $this;
    }

    /**
     * Optional. Configuration for index preparation for vector search. It
     * contains the required configurations to create an index from source data,
     * so that approximate nearest neighbor (a.k.a ANN) algorithms search can be
     * performed during online serving.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.IndexConfig index_config = 15 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\AIPlatform\V1\FeatureView\IndexConfig|null
     */
    public function getIndexConfig()
    {
        return $this->index_config;
    }

    public function hasIndexConfig()
    {
        return isset($this->index_config);
    }

    public function clearIndexConfig()
    {
        unset($this->index_config);
    }

    /**
     * Optional. Configuration for index preparation for vector search. It
     * contains the required configurations to create an index from source data,
     * so that approximate nearest neighbor (a.k.a ANN) algorithms search can be
     * performed during online serving.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.IndexConfig index_config = 15 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\AIPlatform\V1\FeatureView\IndexConfig $var
     * @return $this
     */
    public function setIndexConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\FeatureView\IndexConfig::class);
        $this->index_config = $var;

        return $this;
    }

    /**
     * Optional. Configuration for FeatureView created under Optimized
     * FeatureOnlineStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.OptimizedConfig optimized_config = 16 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\AIPlatform\V1\FeatureView\OptimizedConfig|null
     */
    public function getOptimizedConfig()
    {
        return $this->optimized_config;
    }

    public function hasOptimizedConfig()
    {
        return isset($this->optimized_config);
    }

    public function clearOptimizedConfig()
    {
        unset($this->optimized_config);
    }

    /**
     * Optional. Configuration for FeatureView created under Optimized
     * FeatureOnlineStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.OptimizedConfig optimized_config = 16 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\AIPlatform\V1\FeatureView\OptimizedConfig $var
     * @return $this
     */
    public function setOptimizedConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\FeatureView\OptimizedConfig::class);
        $this->optimized_config = $var;

        return $this;
    }

    /**
     * Optional. Service agent type used during data sync. By default, the Vertex
     * AI Service Agent is used. When using an IAM Policy to isolate this
     * FeatureView within a project, a separate service account should be
     * provisioned by setting this field to `SERVICE_AGENT_TYPE_FEATURE_VIEW`.
     * This will generate a separate service account to access the BigQuery source
     * table.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.ServiceAgentType service_agent_type = 14 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getServiceAgentType()
    {
        return $this->service_agent_type;
    }

    /**
     * Optional. Service agent type used during data sync. By default, the Vertex
     * AI Service Agent is used. When using an IAM Policy to isolate this
     * FeatureView within a project, a separate service account should be
     * provisioned by setting this field to `SERVICE_AGENT_TYPE_FEATURE_VIEW`.
     * This will generate a separate service account to access the BigQuery source
     * table.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.FeatureView.ServiceAgentType service_agent_type = 14 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setServiceAgentType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\AIPlatform\V1\FeatureView\ServiceAgentType::class);
        $this->service_agent_type = $var;

        return $this;
    }

    /**
     * Output only. A Service Account unique to this FeatureView. The role
     * bigquery.dataViewer should be granted to this service account to allow
     * Vertex AI Feature Store to sync data to the online store.
     *
     * Generated from protobuf field <code>string service_account_email = 13 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getServiceAccountEmail()
    {
        return $this->service_account_email;
    }

    /**
     * Output only. A Service Account unique to this FeatureView. The role
     * bigquery.dataViewer should be granted to this service account to allow
     * Vertex AI Feature Store to sync data to the online store.
     *
     * Generated from protobuf field <code>string service_account_email = 13 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setServiceAccountEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->service_account_email = $var;

        return $this;
    }

    /**
     * Output only. Reserved for future use.
     *
     * Generated from protobuf field <code>bool satisfies_pzs = 19 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return bool
     */
    public function getSatisfiesPzs()
    {
        return $this->satisfies_pzs;
    }

    /**
     * Output only. Reserved for future use.
     *
     * Generated from protobuf field <code>bool satisfies_pzs = 19 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param bool $var
     * @return $this
     */
    public function setSatisfiesPzs($var)
    {
        GPBUtil::checkBool($var);
        $this->satisfies_pzs = $var;

        return $this;
    }

    /**
     * Output only. Reserved for future use.
     *
     * Generated from protobuf field <code>bool satisfies_pzi = 20 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return bool
     */
    public function getSatisfiesPzi()
    {
        return $this->satisfies_pzi;
    }

    /**
     * Output only. Reserved for future use.
     *
     * Generated from protobuf field <code>bool satisfies_pzi = 20 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param bool $var
     * @return $this
     */
    public function setSatisfiesPzi($var)
    {
        GPBUtil::checkBool($var);
        $this->satisfies_pzi = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->whichOneof("source");
    }

}

