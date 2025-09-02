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

// [START analyticshub_v1_generated_AnalyticsHubService_DeleteQueryTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\AnalyticsHub\V1\Client\AnalyticsHubServiceClient;
use Google\Cloud\BigQuery\AnalyticsHub\V1\DeleteQueryTemplateRequest;

/**
 * Deletes a query template.
 *
 * @param string $formattedName The resource path of the QueryTemplate.
 *                              e.g.
 *                              `projects/myproject/locations/us/dataExchanges/123/queryTemplates/myqueryTemplate`. Please see
 *                              {@see AnalyticsHubServiceClient::queryTemplateName()} for help formatting this field.
 */
function delete_query_template_sample(string $formattedName): void
{
    // Create a client.
    $analyticsHubServiceClient = new AnalyticsHubServiceClient();

    // Prepare the request message.
    $request = (new DeleteQueryTemplateRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $analyticsHubServiceClient->deleteQueryTemplate($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = AnalyticsHubServiceClient::queryTemplateName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_EXCHANGE]',
        '[QUERY_TEMPLATE]'
    );

    delete_query_template_sample($formattedName);
}
// [END analyticshub_v1_generated_AnalyticsHubService_DeleteQueryTemplate_sync]
