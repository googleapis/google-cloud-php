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

// [START netapp_v1_generated_NetApp_UpdateQuotaRule_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\QuotaRule;
use Google\Cloud\NetApp\V1\QuotaRule\Type;
use Google\Cloud\NetApp\V1\UpdateQuotaRuleRequest;
use Google\Rpc\Status;

/**
 * Updates a quota rule.
 *
 * @param int $quotaRuleType         The type of quota rule.
 * @param int $quotaRuleDiskLimitMib The maximum allowed disk space in MiB.
 */
function update_quota_rule_sample(int $quotaRuleType, int $quotaRuleDiskLimitMib): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $quotaRule = (new QuotaRule())
        ->setType($quotaRuleType)
        ->setDiskLimitMib($quotaRuleDiskLimitMib);
    $request = (new UpdateQuotaRuleRequest())
        ->setQuotaRule($quotaRule);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->updateQuotaRule($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var QuotaRule $result */
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
    $quotaRuleType = Type::TYPE_UNSPECIFIED;
    $quotaRuleDiskLimitMib = 0;

    update_quota_rule_sample($quotaRuleType, $quotaRuleDiskLimitMib);
}
// [END netapp_v1_generated_NetApp_UpdateQuotaRule_sync]
