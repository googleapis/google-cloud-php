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

// [START recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_GetMetrics_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\GetMetricsRequest;
use Google\Cloud\RecaptchaEnterprise\V1\Metrics;

/**
 * Get some aggregated metrics for a Key. This data can be used to build
 * dashboards.
 *
 * @param string $formattedName The name of the requested metrics, in the format
 *                              `projects/{project}/keys/{key}/metrics`. Please see
 *                              {@see RecaptchaEnterpriseServiceClient::metricsName()} for help formatting this field.
 */
function get_metrics_sample(string $formattedName): void
{
    // Create a client.
    $recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

    // Prepare the request message.
    $request = (new GetMetricsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Metrics $response */
        $response = $recaptchaEnterpriseServiceClient->getMetrics($request);
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
    $formattedName = RecaptchaEnterpriseServiceClient::metricsName('[PROJECT]', '[KEY]');

    get_metrics_sample($formattedName);
}
// [END recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_GetMetrics_sync]
