<?php
/*
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START gkemulticloud_v1_generated_AwsClusters_CreateAwsNodePool_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AwsClustersClient;
use Google\Cloud\GkeMultiCloud\V1\AwsConfigEncryption;
use Google\Cloud\GkeMultiCloud\V1\AwsNodeConfig;
use Google\Cloud\GkeMultiCloud\V1\AwsNodePool;
use Google\Cloud\GkeMultiCloud\V1\AwsNodePoolAutoscaling;
use Google\Cloud\GkeMultiCloud\V1\MaxPodsConstraint;
use Google\Rpc\Status;

/**
 * Creates a new [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool], attached to a given [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster].
 *
 * If successful, the response contains a newly created
 * [Operation][google.longrunning.Operation] resource that can be
 * described to track the status of the operation.
 *
 * @param string $formattedParent                            The [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster] resource where this node pool will be created.
 *
 *                                                           `AwsCluster` names are formatted as
 *                                                           `projects/<project-id>/locations/<region>/awsClusters/<cluster-id>`.
 *
 *                                                           See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                                                           for more details on Google Cloud resource names. Please see
 *                                                           {@see AwsClustersClient::awsClusterName()} for help formatting this field.
 * @param string $awsNodePoolVersion                         The Kubernetes version to run on this node pool (e.g. `1.19.10-gke.1000`).
 *
 *                                                           You can list all supported versions on a given Google Cloud region by
 *                                                           calling
 *                                                           [GetAwsServerConfig][google.cloud.gkemulticloud.v1.AwsClusters.GetAwsServerConfig].
 * @param string $awsNodePoolConfigIamInstanceProfile        The name or ARN of the AWS IAM role assigned to nodes in the pool.
 * @param string $awsNodePoolConfigConfigEncryptionKmsKeyArn The ARN of the AWS KMS key used to encrypt user data.
 * @param int    $awsNodePoolAutoscalingMinNodeCount         Minimum number of nodes in the node pool. Must be greater than or equal to
 *                                                           1 and less than or equal to max_node_count.
 * @param int    $awsNodePoolAutoscalingMaxNodeCount         Maximum number of nodes in the node pool. Must be greater than or equal to
 *                                                           min_node_count and less than or equal to 50.
 * @param string $awsNodePoolSubnetId                        The subnet where the node pool node run.
 * @param int    $awsNodePoolMaxPodsConstraintMaxPodsPerNode The maximum number of pods to schedule on a single node.
 * @param string $awsNodePoolId                              A client provided ID the resource. Must be unique within the parent
 *                                                           resource.
 *
 *                                                           The provided ID will be part of the [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool]
 *                                                           resource name formatted as
 *                                                           `projects/<project-id>/locations/<region>/awsClusters/<cluster-id>/awsNodePools/<node-pool-id>`.
 *
 *                                                           Valid characters are `/[a-z][0-9]-/`. Cannot be longer than 40 characters.
 */
function create_aws_node_pool_sample(
    string $formattedParent,
    string $awsNodePoolVersion,
    string $awsNodePoolConfigIamInstanceProfile,
    string $awsNodePoolConfigConfigEncryptionKmsKeyArn,
    int $awsNodePoolAutoscalingMinNodeCount,
    int $awsNodePoolAutoscalingMaxNodeCount,
    string $awsNodePoolSubnetId,
    int $awsNodePoolMaxPodsConstraintMaxPodsPerNode,
    string $awsNodePoolId
): void {
    // Create a client.
    $awsClustersClient = new AwsClustersClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $awsNodePoolConfigConfigEncryption = (new AwsConfigEncryption())
        ->setKmsKeyArn($awsNodePoolConfigConfigEncryptionKmsKeyArn);
    $awsNodePoolConfig = (new AwsNodeConfig())
        ->setIamInstanceProfile($awsNodePoolConfigIamInstanceProfile)
        ->setConfigEncryption($awsNodePoolConfigConfigEncryption);
    $awsNodePoolAutoscaling = (new AwsNodePoolAutoscaling())
        ->setMinNodeCount($awsNodePoolAutoscalingMinNodeCount)
        ->setMaxNodeCount($awsNodePoolAutoscalingMaxNodeCount);
    $awsNodePoolMaxPodsConstraint = (new MaxPodsConstraint())
        ->setMaxPodsPerNode($awsNodePoolMaxPodsConstraintMaxPodsPerNode);
    $awsNodePool = (new AwsNodePool())
        ->setVersion($awsNodePoolVersion)
        ->setConfig($awsNodePoolConfig)
        ->setAutoscaling($awsNodePoolAutoscaling)
        ->setSubnetId($awsNodePoolSubnetId)
        ->setMaxPodsConstraint($awsNodePoolMaxPodsConstraint);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $awsClustersClient->createAwsNodePool($formattedParent, $awsNodePool, $awsNodePoolId);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AwsNodePool $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedParent = AwsClustersClient::awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
    $awsNodePoolVersion = '[VERSION]';
    $awsNodePoolConfigIamInstanceProfile = '[IAM_INSTANCE_PROFILE]';
    $awsNodePoolConfigConfigEncryptionKmsKeyArn = '[KMS_KEY_ARN]';
    $awsNodePoolAutoscalingMinNodeCount = 0;
    $awsNodePoolAutoscalingMaxNodeCount = 0;
    $awsNodePoolSubnetId = '[SUBNET_ID]';
    $awsNodePoolMaxPodsConstraintMaxPodsPerNode = 0;
    $awsNodePoolId = '[AWS_NODE_POOL_ID]';

    create_aws_node_pool_sample(
        $formattedParent,
        $awsNodePoolVersion,
        $awsNodePoolConfigIamInstanceProfile,
        $awsNodePoolConfigConfigEncryptionKmsKeyArn,
        $awsNodePoolAutoscalingMinNodeCount,
        $awsNodePoolAutoscalingMaxNodeCount,
        $awsNodePoolSubnetId,
        $awsNodePoolMaxPodsConstraintMaxPodsPerNode,
        $awsNodePoolId
    );
}
// [END gkemulticloud_v1_generated_AwsClusters_CreateAwsNodePool_sync]
