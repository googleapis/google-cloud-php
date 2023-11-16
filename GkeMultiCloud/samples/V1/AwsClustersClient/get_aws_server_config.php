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

// [START gkemulticloud_v1_generated_AwsClusters_GetAwsServerConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeMultiCloud\V1\AwsServerConfig;
use Google\Cloud\GkeMultiCloud\V1\Client\AwsClustersClient;
use Google\Cloud\GkeMultiCloud\V1\GetAwsServerConfigRequest;

/**
 * Returns information, such as supported AWS regions and Kubernetes
 * versions, on a given Google Cloud location.
 *
 * @param string $formattedName The name of the
 *                              [AwsServerConfig][google.cloud.gkemulticloud.v1.AwsServerConfig] resource
 *                              to describe.
 *
 *                              `AwsServerConfig` names are formatted as
 *                              `projects/<project-id>/locations/<region>/awsServerConfig`.
 *
 *                              See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                              for more details on Google Cloud resource names. Please see
 *                              {@see AwsClustersClient::awsServerConfigName()} for help formatting this field.
 */
function get_aws_server_config_sample(string $formattedName): void
{
    // Create a client.
    $awsClustersClient = new AwsClustersClient();

    // Prepare the request message.
    $request = (new GetAwsServerConfigRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AwsServerConfig $response */
        $response = $awsClustersClient->getAwsServerConfig($request);
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
    $formattedName = AwsClustersClient::awsServerConfigName('[PROJECT]', '[LOCATION]');

    get_aws_server_config_sample($formattedName);
}
// [END gkemulticloud_v1_generated_AwsClusters_GetAwsServerConfig_sync]
