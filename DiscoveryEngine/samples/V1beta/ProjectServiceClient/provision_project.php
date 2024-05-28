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

// [START discoveryengine_v1beta_generated_ProjectService_ProvisionProject_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1beta\Client\ProjectServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\Project;
use Google\Cloud\DiscoveryEngine\V1beta\ProvisionProjectRequest;
use Google\Rpc\Status;

/**
 * Provisions the project resource. During the
 * process, related systems will get prepared and initialized.
 *
 * Caller must read the [Terms for data
 * use](https://cloud.google.com/retail/data-use-terms), and optionally
 * specify in request to provide consent to that service terms.
 *
 * @param string $formattedName       Full resource name of a
 *                                    [Project][google.cloud.discoveryengine.v1beta.Project], such as
 *                                    `projects/{project_id_or_number}`. Please see
 *                                    {@see ProjectServiceClient::projectName()} for help formatting this field.
 * @param bool   $acceptDataUseTerms  Set to `true` to specify that caller has read and would like to
 *                                    give consent to the [Terms for data
 *                                    use](https://cloud.google.com/retail/data-use-terms).
 * @param string $dataUseTermsVersion The version of the [Terms for data
 *                                    use](https://cloud.google.com/retail/data-use-terms) that caller has read
 *                                    and would like to give consent to.
 *
 *                                    Acceptable version is `2022-11-23`, and this may change over time.
 */
function provision_project_sample(
    string $formattedName,
    bool $acceptDataUseTerms,
    string $dataUseTermsVersion
): void {
    // Create a client.
    $projectServiceClient = new ProjectServiceClient();

    // Prepare the request message.
    $request = (new ProvisionProjectRequest())
        ->setName($formattedName)
        ->setAcceptDataUseTerms($acceptDataUseTerms)
        ->setDataUseTermsVersion($dataUseTermsVersion);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $projectServiceClient->provisionProject($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Project $result */
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
    $formattedName = ProjectServiceClient::projectName('[PROJECT]');
    $acceptDataUseTerms = false;
    $dataUseTermsVersion = '[DATA_USE_TERMS_VERSION]';

    provision_project_sample($formattedName, $acceptDataUseTerms, $dataUseTermsVersion);
}
// [END discoveryengine_v1beta_generated_ProjectService_ProvisionProject_sync]
