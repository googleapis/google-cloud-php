<?php
/*
 * Copyright 2023 Google LLC
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

// [START gkemulticloud_v1_generated_AwsClusters_GenerateAwsClusterAgentToken_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeMultiCloud\V1\Client\AwsClustersClient;
use Google\Cloud\GkeMultiCloud\V1\GenerateAwsClusterAgentTokenRequest;
use Google\Cloud\GkeMultiCloud\V1\GenerateAwsClusterAgentTokenResponse;

/**
 * Generates an access token for a cluster agent.
 *
 * @param string $formattedAwsCluster Please see
 *                                    {@see AwsClustersClient::awsClusterName()} for help formatting this field.
 * @param string $subjectToken        Required.
 * @param string $subjectTokenType    Required.
 * @param string $version             Required.
 */
function generate_aws_cluster_agent_token_sample(
    string $formattedAwsCluster,
    string $subjectToken,
    string $subjectTokenType,
    string $version
): void {
    // Create a client.
    $awsClustersClient = new AwsClustersClient();

    // Prepare the request message.
    $request = (new GenerateAwsClusterAgentTokenRequest())
        ->setAwsCluster($formattedAwsCluster)
        ->setSubjectToken($subjectToken)
        ->setSubjectTokenType($subjectTokenType)
        ->setVersion($version);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateAwsClusterAgentTokenResponse $response */
        $response = $awsClustersClient->generateAwsClusterAgentToken($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedAwsCluster = AwsClustersClient::awsClusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[AWS_CLUSTER]'
    );
    $subjectToken = '[SUBJECT_TOKEN]';
    $subjectTokenType = '[SUBJECT_TOKEN_TYPE]';
    $version = '[VERSION]';

    generate_aws_cluster_agent_token_sample(
        $formattedAwsCluster,
        $subjectToken,
        $subjectTokenType,
        $version
    );
}
// [END gkemulticloud_v1_generated_AwsClusters_GenerateAwsClusterAgentToken_sync]
