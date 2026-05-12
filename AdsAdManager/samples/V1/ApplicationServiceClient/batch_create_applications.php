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

// [START admanager_v1_generated_ApplicationService_BatchCreateApplications_sync]
use Google\Ads\AdManager\V1\Application;
use Google\Ads\AdManager\V1\BatchCreateApplicationsRequest;
use Google\Ads\AdManager\V1\BatchCreateApplicationsResponse;
use Google\Ads\AdManager\V1\Client\ApplicationServiceClient;
use Google\Ads\AdManager\V1\CreateApplicationRequest;
use Google\ApiCore\ApiException;

/**
 * API to batch create `Application` objects.
 *
 * @param string $formattedParent                The parent resource where `Applications` will be created.
 *                                               Format: `networks/{network_code}`
 *                                               The parent field in the CreateApplicationRequest must match this
 *                                               field. Please see
 *                                               {@see ApplicationServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent        The parent resource where this `Application` will be created.
 *                                               Format: `networks/{network_code}`
 *                                               Please see {@see ApplicationServiceClient::networkName()} for help formatting this field.
 * @param string $requestsApplicationDisplayName The display name of the application.
 */
function batch_create_applications_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsApplicationDisplayName
): void {
    // Create a client.
    $applicationServiceClient = new ApplicationServiceClient();

    // Prepare the request message.
    $requestsApplication = (new Application())
        ->setDisplayName($requestsApplicationDisplayName);
    $createApplicationRequest = (new CreateApplicationRequest())
        ->setParent($formattedRequestsParent)
        ->setApplication($requestsApplication);
    $requests = [$createApplicationRequest,];
    $request = (new BatchCreateApplicationsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateApplicationsResponse $response */
        $response = $applicationServiceClient->batchCreateApplications($request);
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
    $formattedParent = ApplicationServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = ApplicationServiceClient::networkName('[NETWORK_CODE]');
    $requestsApplicationDisplayName = '[DISPLAY_NAME]';

    batch_create_applications_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsApplicationDisplayName
    );
}
// [END admanager_v1_generated_ApplicationService_BatchCreateApplications_sync]
