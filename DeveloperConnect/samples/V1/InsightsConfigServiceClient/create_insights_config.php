<?php
/*
 * Copyright 2025 Google LLC
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

// [START developerconnect_v1_generated_InsightsConfigService_CreateInsightsConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DeveloperConnect\V1\Client\InsightsConfigServiceClient;
use Google\Cloud\DeveloperConnect\V1\CreateInsightsConfigRequest;
use Google\Cloud\DeveloperConnect\V1\InsightsConfig;
use Google\Rpc\Status;

/**
 * Creates a new InsightsConfig in a given project and location.
 *
 * @param string $formattedParent  Value for parent. Please see
 *                                 {@see InsightsConfigServiceClient::locationName()} for help formatting this field.
 * @param string $insightsConfigId ID of the requesting InsightsConfig.
 */
function create_insights_config_sample(string $formattedParent, string $insightsConfigId): void
{
    // Create a client.
    $insightsConfigServiceClient = new InsightsConfigServiceClient();

    // Prepare the request message.
    $insightsConfig = new InsightsConfig();
    $request = (new CreateInsightsConfigRequest())
        ->setParent($formattedParent)
        ->setInsightsConfigId($insightsConfigId)
        ->setInsightsConfig($insightsConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $insightsConfigServiceClient->createInsightsConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var InsightsConfig $result */
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
    $formattedParent = InsightsConfigServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $insightsConfigId = '[INSIGHTS_CONFIG_ID]';

    create_insights_config_sample($formattedParent, $insightsConfigId);
}
// [END developerconnect_v1_generated_InsightsConfigService_CreateInsightsConfig_sync]
