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

// [START gkemulticloud_v1_generated_AttachedClusters_GenerateAttachedClusterAgentToken_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeMultiCloud\V1\Client\AttachedClustersClient;
use Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterAgentTokenRequest;
use Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterAgentTokenResponse;

/**
 * Generates an access token for a cluster agent.
 *
 * @param string $formattedAttachedCluster Please see
 *                                         {@see AttachedClustersClient::attachedClusterName()} for help formatting this field.
 * @param string $subjectToken             Required.
 * @param string $subjectTokenType         Required.
 * @param string $version                  Required.
 */
function generate_attached_cluster_agent_token_sample(
    string $formattedAttachedCluster,
    string $subjectToken,
    string $subjectTokenType,
    string $version
): void {
    // Create a client.
    $attachedClustersClient = new AttachedClustersClient();

    // Prepare the request message.
    $request = (new GenerateAttachedClusterAgentTokenRequest())
        ->setAttachedCluster($formattedAttachedCluster)
        ->setSubjectToken($subjectToken)
        ->setSubjectTokenType($subjectTokenType)
        ->setVersion($version);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateAttachedClusterAgentTokenResponse $response */
        $response = $attachedClustersClient->generateAttachedClusterAgentToken($request);
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
    $formattedAttachedCluster = AttachedClustersClient::attachedClusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[ATTACHED_CLUSTER]'
    );
    $subjectToken = '[SUBJECT_TOKEN]';
    $subjectTokenType = '[SUBJECT_TOKEN_TYPE]';
    $version = '[VERSION]';

    generate_attached_cluster_agent_token_sample(
        $formattedAttachedCluster,
        $subjectToken,
        $subjectTokenType,
        $version
    );
}
// [END gkemulticloud_v1_generated_AttachedClusters_GenerateAttachedClusterAgentToken_sync]
