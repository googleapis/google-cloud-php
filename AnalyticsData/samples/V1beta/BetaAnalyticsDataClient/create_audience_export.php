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

// [START analyticsdata_v1beta_generated_BetaAnalyticsData_CreateAudienceExport_sync]
use Google\Analytics\Data\V1beta\AudienceDimension;
use Google\Analytics\Data\V1beta\AudienceExport;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\CreateAudienceExportRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Rpc\Status;

/**
 * Creates an audience export for later retrieval. This method quickly returns
 * the audience export's resource name and initiates a long running
 * asynchronous request to form an audience export. To export the users in an
 * audience export, first create the audience export through this method and
 * then send the audience resource name to the `QueryAudienceExport` method.
 *
 * See [Creating an Audience
 * Export](https://developers.google.com/analytics/devguides/reporting/data/v1/audience-list-basics)
 * for an introduction to Audience Exports with examples.
 *
 * An audience export is a snapshot of the users currently in the audience at
 * the time of audience export creation. Creating audience exports for one
 * audience on different days will return different results as users enter and
 * exit the audience.
 *
 * Audiences in Google Analytics 4 allow you to segment your users in the ways
 * that are important to your business. To learn more, see
 * https://support.google.com/analytics/answer/9267572. Audience exports
 * contain the users in each audience.
 *
 * Audience Export APIs have some methods at alpha and other methods at beta
 * stability. The intention is to advance methods to beta stability after some
 * feedback and adoption. To give your feedback on this API, complete the
 * [Google Analytics Audience Export API
 * Feedback](https://forms.gle/EeA5u5LW6PEggtCEA) form.
 *
 * @param string $formattedParent        The parent resource where this audience export will be created.
 *                                       Format: `properties/{property}`
 *                                       Please see {@see BetaAnalyticsDataClient::propertyName()} for help formatting this field.
 * @param string $audienceExportAudience The audience resource name. This resource name identifies the
 *                                       audience being listed and is shared between the Analytics Data & Admin
 *                                       APIs.
 *
 *                                       Format: `properties/{property}/audiences/{audience}`
 */
function create_audience_export_sample(
    string $formattedParent,
    string $audienceExportAudience
): void {
    // Create a client.
    $betaAnalyticsDataClient = new BetaAnalyticsDataClient();

    // Prepare the request message.
    $audienceExportDimensions = [new AudienceDimension()];
    $audienceExport = (new AudienceExport())
        ->setAudience($audienceExportAudience)
        ->setDimensions($audienceExportDimensions);
    $request = (new CreateAudienceExportRequest())
        ->setParent($formattedParent)
        ->setAudienceExport($audienceExport);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $betaAnalyticsDataClient->createAudienceExport($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AudienceExport $result */
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
    $formattedParent = BetaAnalyticsDataClient::propertyName('[PROPERTY]');
    $audienceExportAudience = '[AUDIENCE]';

    create_audience_export_sample($formattedParent, $audienceExportAudience);
}
// [END analyticsdata_v1beta_generated_BetaAnalyticsData_CreateAudienceExport_sync]
