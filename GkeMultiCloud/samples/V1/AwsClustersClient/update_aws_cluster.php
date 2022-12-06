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

// [START gkemulticloud_v1_generated_AwsClusters_UpdateAwsCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AwsAuthorization;
use Google\Cloud\GkeMultiCloud\V1\AwsCluster;
use Google\Cloud\GkeMultiCloud\V1\AwsClusterNetworking;
use Google\Cloud\GkeMultiCloud\V1\AwsClusterUser;
use Google\Cloud\GkeMultiCloud\V1\AwsClustersClient;
use Google\Cloud\GkeMultiCloud\V1\AwsConfigEncryption;
use Google\Cloud\GkeMultiCloud\V1\AwsControlPlane;
use Google\Cloud\GkeMultiCloud\V1\AwsDatabaseEncryption;
use Google\Cloud\GkeMultiCloud\V1\AwsServicesAuthentication;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster].
 *
 * @param string $awsClusterNetworkingVpcId                              The VPC associated with the cluster. All component clusters
 *                                                                       (i.e. control plane and node pools) run on a single VPC.
 *
 *                                                                       This field cannot be changed after creation.
 * @param string $awsClusterNetworkingPodAddressCidrBlocksElement        All pods in the cluster are assigned an IPv4 address from these ranges.
 *                                                                       Only a single range is supported.
 *                                                                       This field cannot be changed after creation.
 * @param string $awsClusterNetworkingServiceAddressCidrBlocksElement    All services in the cluster are assigned an IPv4 address from these ranges.
 *                                                                       Only a single range is supported.
 *                                                                       This field cannot be changed after creation.
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
 * @param string $awsClusterControlPlaneIamInstanceProfile               The name or ARN of the AWS IAM instance profile to assign to each control
 *                                                                       plane replica.
 * @param string $awsClusterControlPlaneDatabaseEncryptionKmsKeyArn      The ARN of the AWS KMS key used to encrypt cluster secrets.
 * @param string $awsClusterControlPlaneAwsServicesAuthenticationRoleArn The Amazon Resource Name (ARN) of the role that the Anthos Multi-Cloud API
 *                                                                       will assume when managing AWS resources on your account.
 * @param string $awsClusterControlPlaneConfigEncryptionKmsKeyArn        The ARN of the AWS KMS key used to encrypt user data.
 * @param string $awsClusterAuthorizationAdminUsersUsername              The name of the user, e.g. `my-gcp-id&#64;gmail.com`.
 */
function update_aws_cluster_sample(
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
    string $awsClusterAuthorizationAdminUsersUsername
): void {
    // Create a client.
    $awsClustersClient = new AwsClustersClient();

    // Prepare any non-scalar elements to be passed along with the request.
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
    $awsClusterUser = (new AwsClusterUser())
        ->setUsername($awsClusterAuthorizationAdminUsersUsername);
    $awsClusterAuthorizationAdminUsers = [$awsClusterUser,];
    $awsClusterAuthorization = (new AwsAuthorization())
        ->setAdminUsers($awsClusterAuthorizationAdminUsers);
    $awsCluster = (new AwsCluster())
        ->setNetworking($awsClusterNetworking)
        ->setAwsRegion($awsClusterAwsRegion)
        ->setControlPlane($awsClusterControlPlane)
        ->setAuthorization($awsClusterAuthorization);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $awsClustersClient->updateAwsCluster($awsCluster, $updateMask);
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
    $awsClusterAuthorizationAdminUsersUsername = '[USERNAME]';

    update_aws_cluster_sample(
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
        $awsClusterAuthorizationAdminUsersUsername
    );
}
// [END gkemulticloud_v1_generated_AwsClusters_UpdateAwsCluster_sync]
