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

// [START logging_v2_generated_ConfigServiceV2_UpdateExclusion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\LogExclusion;
use Google\Protobuf\FieldMask;

/**
 * Changes one or more properties of an existing exclusion in the _Default
 * sink.
 *
 * @param string $formattedName   The resource name of the exclusion to update:
 *
 *                                "projects/[PROJECT_ID]/exclusions/[EXCLUSION_ID]"
 *                                "organizations/[ORGANIZATION_ID]/exclusions/[EXCLUSION_ID]"
 *                                "billingAccounts/[BILLING_ACCOUNT_ID]/exclusions/[EXCLUSION_ID]"
 *                                "folders/[FOLDER_ID]/exclusions/[EXCLUSION_ID]"
 *
 *                                For example:
 *
 *                                `"projects/my-project/exclusions/my-exclusion"`
 *                                Please see {@see ConfigServiceV2Client::logExclusionName()} for help formatting this field.
 * @param string $exclusionName   A client-assigned identifier, such as `"load-balancer-exclusion"`.
 *                                Identifiers are limited to 100 characters and can include only letters,
 *                                digits, underscores, hyphens, and periods. First character has to be
 *                                alphanumeric.
 * @param string $exclusionFilter An [advanced logs
 *                                filter](https://cloud.google.com/logging/docs/view/advanced-queries) that
 *                                matches the log entries to be excluded. By using the [sample
 *                                function](https://cloud.google.com/logging/docs/view/advanced-queries#sample),
 *                                you can exclude less than 100% of the matching log entries.
 *
 *                                For example, the following query matches 99% of low-severity log entries
 *                                from Google Cloud Storage buckets:
 *
 *                                `resource.type=gcs_bucket severity<ERROR sample(insertId, 0.99)`
 */
function update_exclusion_sample(
    string $formattedName,
    string $exclusionName,
    string $exclusionFilter
): void {
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $exclusion = (new LogExclusion())
        ->setName($exclusionName)
        ->setFilter($exclusionFilter);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var LogExclusion $response */
        $response = $configServiceV2Client->updateExclusion($formattedName, $exclusion, $updateMask);
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
    $formattedName = ConfigServiceV2Client::logExclusionName('[PROJECT]', '[EXCLUSION]');
    $exclusionName = '[NAME]';
    $exclusionFilter = '[FILTER]';

    update_exclusion_sample($formattedName, $exclusionName, $exclusionFilter);
}
// [END logging_v2_generated_ConfigServiceV2_UpdateExclusion_sync]
