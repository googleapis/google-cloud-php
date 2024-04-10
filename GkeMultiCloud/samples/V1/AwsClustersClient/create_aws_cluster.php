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

// [START gkemulticloud_v1_generated_AwsClusters_CreateAwsCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AwsAuthorization;
use Google\Cloud\GkeMultiCloud\V1\AwsCluster;
use Google\Cloud\GkeMultiCloud\V1\AwsClusterNetworking;
use Google\Cloud\GkeMultiCloud\V1\AwsConfigEncryption;
use Google\Cloud\GkeMultiCloud\V1\AwsControlPlane;
use Google\Cloud\GkeMultiCloud\V1\AwsDatabaseEncryption;
use Google\Cloud\GkeMultiCloud\V1\AwsServicesAuthentication;
use Google\Cloud\GkeMultiCloud\V1\Client\AwsClustersClient;
use Google\Cloud\GkeMultiCloud\V1\CreateAwsClusterRequest;
use Google\Cloud\GkeMultiCloud\V1\Fleet;
use Google\Rpc\Status;

/**
 * Creates a new [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster]
 * resource on a given Google Cloud Platform project and region.
 *
 * If successful, the response contains a newly created
 * [Operation][google.longrunning.Operation] resource that can be
 * described to track the status of the operation.
 *
 * @param string $formattedParent                                        The parent location where this
 *                                                                       [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster] resource will be
 *                                                                       created.
 *
 *                                                                       Location names are formatted as `projects/<project-id>/locations/<region>`.
 *
 *                                                                       See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                                                                       for more details on Google Cloud resource names. Please see
 *                                                                       {@see AwsClustersClient::locationName()} for help formatting this field.
 * @param string $awsClusterNetworkingVpcId                              The VPC associated with the cluster. All component clusters
 *                                                                       (i.e. control plane and node pools) run on a single VPC.
 *
 *                                                                       This field cannot be changed after creation.
 * @param string $awsClusterNetworkingPodAddressCidrBlocksElement        All pods in the cluster are assigned an IPv4 address from these
 *                                                                       ranges. Only a single range is supported. This field cannot be changed
 *                                                                       after creation.
 * @param string $awsClusterNetworkingServiceAddressCidrBlocksElement    All services in the cluster are assigned an IPv4 address from
 *                                                                       these ranges. Only a single range is supported. This field cannot be
 *                                                                       changed after creation.
 * @param string $awsClusterAwsRegion                                    The AWS region where the cluster runs.
 *
 *                                                                       Each Google Cloud region supports a subset of nearby AWS regions.
 *                                                                       You can call
 *                                                                       [GetAwsServerConfig][google.cloud.gkemulticloud.v1.AwsClusters.GetAwsServerConfig]
 *                                                                       to list all supported AWS regions within a given Google Cloud region.
 * @param string $awsClusterControlPlaneVersion                          The Kubernetes version to run on control plane replicas
 *                                                                       (e.g. `1.19.10-gke.1000`).
 *
 *                                                                       You can list all supported versions on a given Google Cloud region by
 *                                                                       calling
 *                                                                       [GetAwsServerConfig][google.cloud.gkemulticloud.v1.AwsClusters.GetAwsServerConfig].
 * @param string $awsClusterControlPlaneSubnetIdsElement                 The list of subnets where control plane replicas will run.
 *                                                                       A replica will be provisioned on each subnet and up to three values
 *                                                                       can be provided.
 *                                                                       Each subnet must be in a different AWS Availability Zone (AZ).
 * @param string $awsClusterControlPlaneIamInstanceProfile               The name or ARN of the AWS IAM instance profile to assign to each
 *                                                                       control plane replica.
 * @param string $awsClusterControlPlaneDatabaseEncryptionKmsKeyArn      The ARN of the AWS KMS key used to encrypt cluster secrets.
 * @param string $awsClusterControlPlaneAwsServicesAuthenticationRoleArn The Amazon Resource Name (ARN) of the role that the Anthos
 *                                                                       Multi-Cloud API will assume when managing AWS resources on your account.
 * @param string $awsClusterControlPlaneConfigEncryptionKmsKeyArn        The ARN of the AWS KMS key used to encrypt user data.
 * @param string $awsClusterFleetProject                                 The name of the Fleet host project where this cluster will be
 *                                                                       registered.
 *
 *                                                                       Project names are formatted as
 *                                                                       `projects/<project-number>`.
 * @param string $awsClusterId                                           A client provided ID the resource. Must be unique within the
 *                                                                       parent resource.
 *
 *                                                                       The provided ID will be part of the
 *                                                                       [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster] resource name
 *                                                                       formatted as
 *                                                                       `projects/<project-id>/locations/<region>/awsClusters/<cluster-id>`.
 *
 *                                                                       Valid characters are `/[a-z][0-9]-/`. Cannot be longer than 63 characters.
 */
function create_aws_cluster_sample(
    string $formattedParent,
    string $awsClusterNetworkingVpcId,
    string $awsClusterNetworkingPodAddressCidrBlocksElement,
    string $awsClusterNetworkingServiceAddressCidrBlocksElement,
    string $awsClusterAwsRegion,
    string $awsClusterControlPlaneVersion,
    string $awsClusterControlPlaneSubnetIdsElement,
    string $awsClusterControlPlaneIamInstanceProfile,
    string $awsClusterControlPlaneDatabaseEncryptionKmsKeyArn,
    string $awsClusterControlPlaneAwsServicesAuthenticationRoleArn,
    string $awsClusterControlPlaneConfigEncryptionKmsKeyArn,
    string $awsClusterFleetProject,
    string $awsClusterId
): void {
    // Create a client.
    $awsClustersClient = new AwsClustersClient();

    // Prepare the request message.
    $awsClusterNetworkingPodAddressCidrBlocks = [$awsClusterNetworkingPodAddressCidrBlocksElement,];
    $awsClusterNetworkingServiceAddressCidrBlocks = [
        $awsClusterNetworkingServiceAddressCidrBlocksElement,
    ];
    $awsClusterNetworking = (new AwsClusterNetworking())
        ->setVpcId($awsClusterNetworkingVpcId)
        ->setPodAddressCidrBlocks($awsClusterNetworkingPodAddressCidrBlocks)
        ->setServiceAddressCidrBlocks($awsClusterNetworkingServiceAddressCidrBlocks);
    $awsClusterControlPlaneSubnetIds = [$awsClusterControlPlaneSubnetIdsElement,];
    $awsClusterControlPlaneDatabaseEncryption = (new AwsDatabaseEncryption())
        ->setKmsKeyArn($awsClusterControlPlaneDatabaseEncryptionKmsKeyArn);
    $awsClusterControlPlaneAwsServicesAuthentication = (new AwsServicesAuthentication())
        ->setRoleArn($awsClusterControlPlaneAwsServicesAuthenticationRoleArn);
    $awsClusterControlPlaneConfigEncryption = (new AwsConfigEncryption())
        ->setKmsKeyArn($awsClusterControlPlaneConfigEncryptionKmsKeyArn);
    $awsClusterControlPlane = (new AwsControlPlane())
        ->setVersion($awsClusterControlPlaneVersion)
        ->setSubnetIds($awsClusterControlPlaneSubnetIds)
        ->setIamInstanceProfile($awsClusterControlPlaneIamInstanceProfile)
        ->setDatabaseEncryption($awsClusterControlPlaneDatabaseEncryption)
        ->setAwsServicesAuthentication($awsClusterControlPlaneAwsServicesAuthentication)
        ->setConfigEncryption($awsClusterControlPlaneConfigEncryption);
    $awsClusterAuthorization = new AwsAuthorization();
    $awsClusterFleet = (new Fleet())
        ->setProject($awsClusterFleetProject);
    $awsCluster = (new AwsCluster())
        ->setNetworking($awsClusterNetworking)
        ->setAwsRegion($awsClusterAwsRegion)
        ->setControlPlane($awsClusterControlPlane)
        ->setAuthorization($awsClusterAuthorization)
        ->setFleet($awsClusterFleet);
    $request = (new CreateAwsClusterRequest())
        ->setParent($formattedParent)
        ->setAwsCluster($awsCluster)
        ->setAwsClusterId($awsClusterId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $awsClustersClient->createAwsCluster($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AwsCluster $result */
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
    $formattedParent = AwsClustersClient::locationName('[PROJECT]', '[LOCATION]');
    $awsClusterNetworkingVpcId = '[VPC_ID]';
    $awsClusterNetworkingPodAddressCidrBlocksElement = '[POD_ADDRESS_CIDR_BLOCKS]';
    $awsClusterNetworkingServiceAddressCidrBlocksElement = '[SERVICE_ADDRESS_CIDR_BLOCKS]';
    $awsClusterAwsRegion = '[AWS_REGION]';
    $awsClusterControlPlaneVersion = '[VERSION]';
    $awsClusterControlPlaneSubnetIdsElement = '[SUBNET_IDS]';
    $awsClusterControlPlaneIamInstanceProfile = '[IAM_INSTANCE_PROFILE]';
    $awsClusterControlPlaneDatabaseEncryptionKmsKeyArn = '[KMS_KEY_ARN]';
    $awsClusterControlPlaneAwsServicesAuthenticationRoleArn = '[ROLE_ARN]';
    $awsClusterControlPlaneConfigEncryptionKmsKeyArn = '[KMS_KEY_ARN]';
    $awsClusterFleetProject = '[PROJECT]';
    $awsClusterId = '[AWS_CLUSTER_ID]';

    create_aws_cluster_sample(
        $formattedParent,
        $awsClusterNetworkingVpcId,
        $awsClusterNetworkingPodAddressCidrBlocksElement,
        $awsClusterNetworkingServiceAddressCidrBlocksElement,
        $awsClusterAwsRegion,
        $awsClusterControlPlaneVersion,
        $awsClusterControlPlaneSubnetIdsElement,
        $awsClusterControlPlaneIamInstanceProfile,
        $awsClusterControlPlaneDatabaseEncryptionKmsKeyArn,
        $awsClusterControlPlaneAwsServicesAuthenticationRoleArn,
        $awsClusterControlPlaneConfigEncryptionKmsKeyArn,
        $awsClusterFleetProject,
        $awsClusterId
    );
}
// [END gkemulticloud_v1_generated_AwsClusters_CreateAwsCluster_sync]
