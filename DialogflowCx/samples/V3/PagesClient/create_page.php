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

// [START dialogflow_v3_generated_Pages_CreatePage_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\PagesClient;
use Google\Cloud\Dialogflow\Cx\V3\CreatePageRequest;
use Google\Cloud\Dialogflow\Cx\V3\Page;

/**
 * Creates a page in the specified flow.
 *
 * Note: You should always train a flow prior to sending it queries. See the
 * [training
 * documentation](https://cloud.google.com/dialogflow/cx/docs/concept/training).
 *
 * @param string $formattedParent The flow to create a page for.
 *                                Format:
 *                                `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/flows/<FlowID>`. Please see
 *                                {@see PagesClient::flowName()} for help formatting this field.
 * @param string $pageDisplayName The human-readable name of the page, unique within the flow.
 */
function create_page_sample(string $formattedParent, string $pageDisplayName): void
{
    // Create a client.
    $pagesClient = new PagesClient();

    // Prepare the request message.
    $page = (new Page())
        ->setDisplayName($pageDisplayName);
    $request = (new CreatePageRequest())
        ->setParent($formattedParent)
        ->setPage($page);

    // Call the API and handle any network failures.
    try {
        /** @var Page $response */
        $response = $pagesClient->createPage($request);
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
    $formattedParent = PagesClient::flowName('[PROJECT]', '[LOCATION]', '[AGENT]', '[FLOW]');
    $pageDisplayName = '[DISPLAY_NAME]';

    create_page_sample($formattedParent, $pageDisplayName);
}
// [END dialogflow_v3_generated_Pages_CreatePage_sync]
