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

// [START analyticshub_v1_generated_AnalyticsHubService_CreateQueryTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\AnalyticsHub\V1\Client\AnalyticsHubServiceClient;
use Google\Cloud\BigQuery\AnalyticsHub\V1\CreateQueryTemplateRequest;
use Google\Cloud\BigQuery\AnalyticsHub\V1\QueryTemplate;

/**
 * Creates a new QueryTemplate
 *
 * @param string $formattedParent          The parent resource path of the QueryTemplate.
 *                                         e.g.
 *                                         `projects/myproject/locations/us/dataExchanges/123/queryTemplates/myQueryTemplate`. Please see
 *                                         {@see AnalyticsHubServiceClient::dataExchangeName()} for help formatting this field.
 * @param string $queryTemplateId          The ID of the QueryTemplate to create.
 *                                         Must contain only Unicode letters, numbers (0-9), underscores (_).
 *                                         Max length: 100 bytes.
 * @param string $queryTemplateDisplayName Human-readable display name of the QueryTemplate. The display
 *                                         name must contain only Unicode letters, numbers (0-9), underscores (_),
 *                                         dashes (-), spaces ( ), ampersands (&) and can't start or end with spaces.
 *                                         Default value is an empty string. Max length: 63 bytes.
 */
function create_query_template_sample(
    string $formattedParent,
    string $queryTemplateId,
    string $queryTemplateDisplayName
): void {
    // Create a client.
    $analyticsHubServiceClient = new AnalyticsHubServiceClient();

    // Prepare the request message.
    $queryTemplate = (new QueryTemplate())
        ->setDisplayName($queryTemplateDisplayName);
    $request = (new CreateQueryTemplateRequest())
        ->setParent($formattedParent)
        ->setQueryTemplateId($queryTemplateId)
        ->setQueryTemplate($queryTemplate);

    // Call the API and handle any network failures.
    try {
        /** @var QueryTemplate $response */
        $response = $analyticsHubServiceClient->createQueryTemplate($request);
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
    $formattedParent = AnalyticsHubServiceClient::dataExchangeName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_EXCHANGE]'
    );
    $queryTemplateId = '[QUERY_TEMPLATE_ID]';
    $queryTemplateDisplayName = '[DISPLAY_NAME]';

    create_query_template_sample($formattedParent, $queryTemplateId, $queryTemplateDisplayName);
}
// [END analyticshub_v1_generated_AnalyticsHubService_CreateQueryTemplate_sync]
