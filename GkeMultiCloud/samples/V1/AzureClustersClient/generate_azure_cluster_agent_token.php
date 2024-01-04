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

// [START gkemulticloud_v1_generated_AzureClusters_GenerateAzureClusterAgentToken_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeMultiCloud\V1\Client\AzureClustersClient;
use Google\Cloud\GkeMultiCloud\V1\GenerateAzureClusterAgentTokenRequest;
use Google\Cloud\GkeMultiCloud\V1\GenerateAzureClusterAgentTokenResponse;

/**
 * Generates an access token for a cluster agent.
 *
 * @param string $formattedAzureCluster Please see
 *                                      {@see AzureClustersClient::azureClusterName()} for help formatting this field.
 * @param string $subjectToken          Required.
 * @param string $subjectTokenType      Required.
 * @param string $version               Required.
 */
function generate_azure_cluster_agent_token_sample(
    string $formattedAzureCluster,
    string $subjectToken,
    string $subjectTokenType,
    string $version
): void {
    // Create a client.
    $azureClustersClient = new AzureClustersClient();

    // Prepare the request message.
    $request = (new GenerateAzureClusterAgentTokenRequest())
        ->setAzureCluster($formattedAzureCluster)
        ->setSubjectToken($subjectToken)
        ->setSubjectTokenType($subjectTokenType)
        ->setVersion($version);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateAzureClusterAgentTokenResponse $response */
        $response = $azureClustersClient->generateAzureClusterAgentToken($request);
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
    $formattedAzureCluster = AzureClustersClient::azureClusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[AZURE_CLUSTER]'
    );
    $subjectToken = '[SUBJECT_TOKEN]';
    $subjectTokenType = '[SUBJECT_TOKEN_TYPE]';
    $version = '[VERSION]';

    generate_azure_cluster_agent_token_sample(
        $formattedAzureCluster,
        $subjectToken,
        $subjectTokenType,
        $version
    );
}
// [END gkemulticloud_v1_generated_AzureClusters_GenerateAzureClusterAgentToken_sync]
