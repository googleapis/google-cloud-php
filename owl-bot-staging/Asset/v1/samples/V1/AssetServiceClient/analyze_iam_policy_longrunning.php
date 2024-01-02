<?php
/*
 * Copyright 2024 Google LLC
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

// [START cloudasset_v1_generated_AssetService_AnalyzeIamPolicyLongrunning_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Asset\V1\AnalyzeIamPolicyLongrunningResponse;
use Google\Cloud\Asset\V1\AssetServiceClient;
use Google\Cloud\Asset\V1\IamPolicyAnalysisOutputConfig;
use Google\Cloud\Asset\V1\IamPolicyAnalysisQuery;
use Google\Rpc\Status;

/**
 * Analyzes IAM policies asynchronously to answer which identities have what
 * accesses on which resources, and writes the analysis results to a Google
 * Cloud Storage or a BigQuery destination. For Cloud Storage destination, the
 * output format is the JSON format that represents a
 * [AnalyzeIamPolicyResponse][google.cloud.asset.v1.AnalyzeIamPolicyResponse].
 * This method implements the
 * [google.longrunning.Operation][google.longrunning.Operation], which allows
 * you to track the operation status. We recommend intervals of at least 2
 * seconds with exponential backoff retry to poll the operation result. The
 * metadata contains the metadata for the long-running operation.
 *
 * @param string $analysisQueryScope The relative name of the root asset. Only resources and IAM
 *                                   policies within the scope will be analyzed.
 *
 *                                   This can only be an organization number (such as "organizations/123"), a
 *                                   folder number (such as "folders/123"), a project ID (such as
 *                                   "projects/my-project-id"), or a project number (such as "projects/12345").
 *
 *                                   To know how to get organization id, visit [here
 *                                   ](https://cloud.google.com/resource-manager/docs/creating-managing-organization#retrieving_your_organization_id).
 *
 *                                   To know how to get folder or project id, visit [here
 *                                   ](https://cloud.google.com/resource-manager/docs/creating-managing-folders#viewing_or_listing_folders_and_projects).
 */
function analyze_iam_policy_longrunning_sample(string $analysisQueryScope): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $analysisQuery = (new IamPolicyAnalysisQuery())
        ->setScope($analysisQueryScope);
    $outputConfig = new IamPolicyAnalysisOutputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $assetServiceClient->analyzeIamPolicyLongrunning($analysisQuery, $outputConfig);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AnalyzeIamPolicyLongrunningResponse $result */
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
    $analysisQueryScope = '[SCOPE]';

    analyze_iam_policy_longrunning_sample($analysisQueryScope);
}
// [END cloudasset_v1_generated_AssetService_AnalyzeIamPolicyLongrunning_sync]
