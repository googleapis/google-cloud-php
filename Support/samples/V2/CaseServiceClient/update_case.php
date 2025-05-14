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

// [START cloudsupport_v2_generated_CaseService_UpdateCase_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Support\V2\Client\CaseServiceClient;
use Google\Cloud\Support\V2\PBCase;
use Google\Cloud\Support\V2\UpdateCaseRequest;

/**
 * Update a case. Only some fields can be updated.
 *
 * EXAMPLES:
 *
 * cURL:
 *
 * ```shell
 * case="projects/some-project/cases/43595344"
 * curl \
 * --request PATCH \
 * --header "Authorization: Bearer $(gcloud auth print-access-token)" \
 * --header "Content-Type: application/json" \
 * --data '{
 * "priority": "P1"
 * }' \
 * "https://cloudsupport.googleapis.com/v2/$case?updateMask=priority"
 * ```
 *
 * Python:
 *
 * ```python
 * import googleapiclient.discovery
 *
 * api_version = "v2"
 * supportApiService = googleapiclient.discovery.build(
 * serviceName="cloudsupport",
 * version=api_version,
 * discoveryServiceUrl=f"https://cloudsupport.googleapis.com/$discovery/rest?version={api_version}",
 * )
 * request = supportApiService.cases().patch(
 * name="projects/some-project/cases/43112854",
 * body={
 * "displayName": "This is Now a New Title",
 * "priority": "P2",
 * },
 * )
 * print(request.execute())
 * ```
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_case_sample(): void
{
    // Create a client.
    $caseServiceClient = new CaseServiceClient();

    // Prepare the request message.
    $case = new PBCase();
    $request = (new UpdateCaseRequest())
        ->setCase($case);

    // Call the API and handle any network failures.
    try {
        /** @var PBCase $response */
        $response = $caseServiceClient->updateCase($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudsupport_v2_generated_CaseService_UpdateCase_sync]
