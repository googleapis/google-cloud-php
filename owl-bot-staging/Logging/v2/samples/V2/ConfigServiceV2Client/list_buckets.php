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

// [START logging_v2_generated_ConfigServiceV2_ListBuckets_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\LogBucket;

/**
 * Lists log buckets.
 *
 * @param string $formattedParent The parent resource whose buckets are to be listed:
 *
 *                                "projects/[PROJECT_ID]/locations/[LOCATION_ID]"
 *                                "organizations/[ORGANIZATION_ID]/locations/[LOCATION_ID]"
 *                                "billingAccounts/[BILLING_ACCOUNT_ID]/locations/[LOCATION_ID]"
 *                                "folders/[FOLDER_ID]/locations/[LOCATION_ID]"
 *
 *                                Note: The locations portion of the resource must be specified, but
 *                                supplying the character `-` in place of [LOCATION_ID] will return all
 *                                buckets. Please see
 *                                {@see ConfigServiceV2Client::organizationLocationName()} for help formatting this field.
 */
function list_buckets_sample(string $formattedParent): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $configServiceV2Client->listBuckets($formattedParent);

        /** @var LogBucket $element */
        foreach ($response as $element) {
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
    $formattedParent = ConfigServiceV2Client::organizationLocationName('[ORGANIZATION]', '[LOCATION]');

    list_buckets_sample($formattedParent);
}
// [END logging_v2_generated_ConfigServiceV2_ListBuckets_sync]
