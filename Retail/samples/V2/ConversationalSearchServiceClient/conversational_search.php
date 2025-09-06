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

// [START retail_v2_generated_ConversationalSearchService_ConversationalSearch_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Retail\V2\Client\ConversationalSearchServiceClient;
use Google\Cloud\Retail\V2\ConversationalSearchRequest;
use Google\Cloud\Retail\V2\ConversationalSearchResponse;

/**
 * Performs a conversational search.
 *
 * This feature is only available for users who have Conversational Search
 * enabled.
 *
 * @param string $placement       The resource name of the search engine placement, such as
 *                                `projects/&#42;/locations/global/catalogs/default_catalog/placements/default_search`
 *                                or
 *                                `projects/&#42;/locations/global/catalogs/default_catalog/servingConfigs/default_serving_config`
 *                                This field is used to identify the serving config name and the set
 *                                of models that will be used to make the search.
 * @param string $formattedBranch The branch resource name, such as
 *                                `projects/&#42;/locations/global/catalogs/default_catalog/branches/0`.
 *
 *                                Use "default_branch" as the branch ID or leave this field empty, to search
 *                                products under the default branch. Please see
 *                                {@see ConversationalSearchServiceClient::branchName()} for help formatting this field.
 * @param string $visitorId       A unique identifier for tracking visitors. For example, this
 *                                could be implemented with an HTTP cookie, which should be able to uniquely
 *                                identify a visitor on a single device. This unique identifier should not
 *                                change if the visitor logs in or out of the website.
 *
 *                                This should be the same identifier as
 *                                [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id].
 *
 *                                The field must be a UTF-8 encoded string with a length limit of 128
 *                                characters. Otherwise, an INVALID_ARGUMENT error is returned.
 */
function conversational_search_sample(
    string $placement,
    string $formattedBranch,
    string $visitorId
): void {
    // Create a client.
    $conversationalSearchServiceClient = new ConversationalSearchServiceClient();

    // Prepare the request message.
    $request = (new ConversationalSearchRequest())
        ->setPlacement($placement)
        ->setBranch($formattedBranch)
        ->setVisitorId($visitorId);

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $conversationalSearchServiceClient->conversationalSearch($request);

        /** @var ConversationalSearchResponse $element */
        foreach ($stream->readAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $placement = '[PLACEMENT]';
    $formattedBranch = ConversationalSearchServiceClient::branchName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[BRANCH]'
    );
    $visitorId = '[VISITOR_ID]';

    conversational_search_sample($placement, $formattedBranch, $visitorId);
}
// [END retail_v2_generated_ConversationalSearchService_ConversationalSearch_sync]
