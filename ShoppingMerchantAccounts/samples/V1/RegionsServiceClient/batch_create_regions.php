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

// [START merchantapi_v1_generated_RegionsService_BatchCreateRegions_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Accounts\V1\BatchCreateRegionsRequest;
use Google\Shopping\Merchant\Accounts\V1\BatchCreateRegionsResponse;
use Google\Shopping\Merchant\Accounts\V1\Client\RegionsServiceClient;
use Google\Shopping\Merchant\Accounts\V1\CreateRegionRequest;
use Google\Shopping\Merchant\Accounts\V1\Region;

/**
 * Creates one or more regions in your Merchant Center account.
 * Executing this method requires admin access.
 *
 * @param string $formattedParent         The account to create one or more regions for.
 *                                        Format: `accounts/{account}`
 *                                        Please see {@see RegionsServiceClient::accountName()} for help formatting this field.
 * @param string $formattedRequestsParent The account to create a region for.
 *                                        Format: `accounts/{account}`
 *                                        Please see {@see RegionsServiceClient::accountName()} for help formatting this field.
 * @param string $requestsRegionId        The identifier for the region, unique over all regions of the
 *                                        same account.
 */
function batch_create_regions_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsRegionId
): void {
    // Create a client.
    $regionsServiceClient = new RegionsServiceClient();

    // Prepare the request message.
    $requestsRegion = new Region();
    $createRegionRequest = (new CreateRegionRequest())
        ->setParent($formattedRequestsParent)
        ->setRegionId($requestsRegionId)
        ->setRegion($requestsRegion);
    $requests = [$createRegionRequest,];
    $request = (new BatchCreateRegionsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateRegionsResponse $response */
        $response = $regionsServiceClient->batchCreateRegions($request);
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
    $formattedParent = RegionsServiceClient::accountName('[ACCOUNT]');
    $formattedRequestsParent = RegionsServiceClient::accountName('[ACCOUNT]');
    $requestsRegionId = '[REGION_ID]';

    batch_create_regions_sample($formattedParent, $formattedRequestsParent, $requestsRegionId);
}
// [END merchantapi_v1_generated_RegionsService_BatchCreateRegions_sync]
