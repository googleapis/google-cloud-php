<?php
/*
 * Copyright 2024 Google LLC
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

// [START securitycenter_v2_generated_SecurityCenter_BulkMuteFindings_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\SecurityCenter\V2\BulkMuteFindingsRequest;
use Google\Cloud\SecurityCenter\V2\BulkMuteFindingsResponse;
use Google\Cloud\SecurityCenter\V2\Client\SecurityCenterClient;
use Google\Rpc\Status;

/**
 * Kicks off an LRO to bulk mute findings for a parent based on a filter. If
 * no location is specified, findings are muted in global. The parent
 * can be either an organization, folder, or project. The findings matched by
 * the filter will be muted after the LRO is done.
 *
 * @param string $parent The parent, at which bulk action needs to be applied. If no
 *                       location is specified, findings are updated in global. The following list
 *                       shows some examples:
 *
 *                       + `organizations/[organization_id]`
 *                       + `organizations/[organization_id]/locations/[location_id]`
 *                       + `folders/[folder_id]`
 *                       + `folders/[folder_id]/locations/[location_id]`
 *                       + `projects/[project_id]`
 *                       + `projects/[project_id]/locations/[location_id]`
 */
function bulk_mute_findings_sample(string $parent): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $request = (new BulkMuteFindingsRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $securityCenterClient->bulkMuteFindings($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BulkMuteFindingsResponse $result */
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
    $parent = '[PARENT]';

    bulk_mute_findings_sample($parent);
}
// [END securitycenter_v2_generated_SecurityCenter_BulkMuteFindings_sync]
