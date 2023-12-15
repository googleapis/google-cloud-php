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

// [START gkemulticloud_v1_generated_AwsClusters_GetAwsOpenIdConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeMultiCloud\V1\AwsOpenIdConfig;
use Google\Cloud\GkeMultiCloud\V1\Client\AwsClustersClient;
use Google\Cloud\GkeMultiCloud\V1\GetAwsOpenIdConfigRequest;

/**
 * Gets the OIDC discovery document for the cluster.
 * See the
 * [OpenID Connect Discovery 1.0
 * specification](https://openid.net/specs/openid-connect-discovery-1_0.html)
 * for details.
 *
 * @param string $formattedAwsCluster The AwsCluster, which owns the OIDC discovery document.
 *                                    Format:
 *                                    projects/{project}/locations/{location}/awsClusters/{cluster}
 *                                    Please see {@see AwsClustersClient::awsClusterName()} for help formatting this field.
 */
function get_aws_open_id_config_sample(string $formattedAwsCluster): void
{
    // Create a client.
    $awsClustersClient = new AwsClustersClient();

    // Prepare the request message.
    $request = (new GetAwsOpenIdConfigRequest())
        ->setAwsCluster($formattedAwsCluster);

    // Call the API and handle any network failures.
    try {
        /** @var AwsOpenIdConfig $response */
        $response = $awsClustersClient->getAwsOpenIdConfig($request);
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

    get_aws_open_id_config_sample($formattedAwsCluster);
}
// [END gkemulticloud_v1_generated_AwsClusters_GetAwsOpenIdConfig_sync]
