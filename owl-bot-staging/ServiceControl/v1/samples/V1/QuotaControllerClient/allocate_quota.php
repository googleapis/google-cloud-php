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

// [START servicecontrol_v1_generated_QuotaController_AllocateQuota_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ServiceControl\V1\AllocateQuotaResponse;
use Google\Cloud\ServiceControl\V1\QuotaControllerClient;

/**
 * Attempts to allocate quota for the specified consumer. It should be called
 * before the operation is executed.
 *
 * This method requires the `servicemanagement.services.quota`
 * permission on the specified service. For more information, see
 * [Cloud IAM](https://cloud.google.com/iam).
 *
 * **NOTE:** The client **must** fail-open on server errors `INTERNAL`,
 * `UNKNOWN`, `DEADLINE_EXCEEDED`, and `UNAVAILABLE`. To ensure system
 * reliability, the server may inject these errors to prohibit any hard
 * dependency on the quota functionality.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function allocate_quota_sample(): void
{
    // Create a client.
    $quotaControllerClient = new QuotaControllerClient();

    // Call the API and handle any network failures.
    try {
        /** @var AllocateQuotaResponse $response */
        $response = $quotaControllerClient->allocateQuota();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END servicecontrol_v1_generated_QuotaController_AllocateQuota_sync]
