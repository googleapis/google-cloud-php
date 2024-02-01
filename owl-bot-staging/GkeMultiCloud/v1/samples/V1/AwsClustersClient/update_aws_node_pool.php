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

// [START gkemulticloud_v1_generated_AwsClusters_UpdateAwsNodePool_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AwsNodePool;
use Google\Cloud\GkeMultiCloud\V1\Client\AwsClustersClient;
use Google\Cloud\GkeMultiCloud\V1\UpdateAwsNodePoolRequest;
use Google\Rpc\Status;

/**
 * Updates an [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool].
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_aws_node_pool_sample(): void
{
    // Create a client.
    $awsClustersClient = new AwsClustersClient();

    // Prepare the request message.
    $request = new UpdateAwsNodePoolRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $awsClustersClient->updateAwsNodePool($request);
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
// [END gkemulticloud_v1_generated_AwsClusters_UpdateAwsNodePool_sync]
