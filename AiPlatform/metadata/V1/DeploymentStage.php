<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/deployment_stage.proto

namespace GPBMetadata\Google\Cloud\Aiplatform\V1;

class DeploymentStage
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
1google/cloud/aiplatform/v1/deployment_stage.protogoogle.cloud.aiplatform.v1*�
DeploymentStage 
DEPLOYMENT_STAGE_UNSPECIFIED 
STARTING_DEPLOYMENT
PREPARING_MODEL
CREATING_SERVING_CLUSTER
ADDING_NODES_TO_CLUSTER
GETTING_CONTAINER_IMAGE	
STARTING_MODEL_SERVER
FINISHING_UP
DEPLOYMENT_TERMINATED
B�
com.google.cloud.aiplatform.v1BDeploymentStageProtoPZ>cloud.google.com/go/aiplatform/apiv1/aiplatformpb;aiplatformpb�Google.Cloud.AIPlatform.V1�Google\\Cloud\\AIPlatform\\V1�Google::Cloud::AIPlatform::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

