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

// [START saasservicemgmt_v1_generated_SaasRollouts_DeleteRolloutKind_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Client\SaasRolloutsClient;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteRolloutKindRequest;

/**
 * Delete a single rollout kind.
 *
 * @param string $formattedName The resource name of the resource within a service. Please see
 *                              {@see SaasRolloutsClient::rolloutKindName()} for help formatting this field.
 */
function delete_rollout_kind_sample(string $formattedName): void
{
    // Create a client.
    $saasRolloutsClient = new SaasRolloutsClient();

    // Prepare the request message.
    $request = (new DeleteRolloutKindRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $saasRolloutsClient->deleteRolloutKind($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = SaasRolloutsClient::rolloutKindName(
        '[PROJECT]',
        '[LOCATION]',
        '[ROLLOUT_KIND_ID]'
    );

    delete_rollout_kind_sample($formattedName);
}
// [END saasservicemgmt_v1_generated_SaasRollouts_DeleteRolloutKind_sync]
