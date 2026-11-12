<?php
/*
 * Copyright 2026 Google LLC
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

// [START redis_v1_generated_CloudRedisCluster_AddTokenAuthUser_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Redis\Cluster\V1\AddTokenAuthUserRequest;
use Google\Cloud\Redis\Cluster\V1\Client\CloudRedisClusterClient;
use Google\Cloud\Redis\Cluster\V1\Cluster;
use Google\Rpc\Status;

/**
 * Adds a token auth user for a token based auth enabled cluster.
 *
 * @param string $formattedCluster       The cluster resource that this token auth user will be added for.
 *                                       Format: projects/{project}/locations/{location}/clusters/{cluster}
 *                                       Please see {@see CloudRedisClusterClient::clusterName()} for help formatting this field.
 * @param string $formattedTokenAuthUser The id of the token auth user to add. Please see
 *                                       {@see CloudRedisClusterClient::tokenAuthUserName()} for help formatting this field.
 */
function add_token_auth_user_sample(
    string $formattedCluster,
    string $formattedTokenAuthUser
): void {
    // Create a client.
    $cloudRedisClusterClient = new CloudRedisClusterClient();

    // Prepare the request message.
    $request = (new AddTokenAuthUserRequest())
        ->setCluster($formattedCluster)
        ->setTokenAuthUser($formattedTokenAuthUser);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudRedisClusterClient->addTokenAuthUser($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Cluster $result */
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
    $formattedCluster = CloudRedisClusterClient::clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
    $formattedTokenAuthUser = CloudRedisClusterClient::tokenAuthUserName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]',
        '[TOKEN_AUTH_USER]'
    );

    add_token_auth_user_sample($formattedCluster, $formattedTokenAuthUser);
}
// [END redis_v1_generated_CloudRedisCluster_AddTokenAuthUser_sync]
