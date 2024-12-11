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

// [START config_v1_generated_Config_CreatePreview_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Config\V1\Client\ConfigClient;
use Google\Cloud\Config\V1\CreatePreviewRequest;
use Google\Cloud\Config\V1\Preview;
use Google\Rpc\Status;

/**
 * Creates a [Preview][google.cloud.config.v1.Preview].
 *
 * @param string $formattedParent                The parent in whose context the Preview is created. The parent
 *                                               value is in the format: 'projects/{project_id}/locations/{location}'. Please see
 *                                               {@see ConfigClient::locationName()} for help formatting this field.
 * @param string $formattedPreviewServiceAccount User-specified Service Account (SA) credentials to be used when
 *                                               previewing resources.
 *                                               Format: `projects/{projectID}/serviceAccounts/{serviceAccount}`
 *                                               Please see {@see ConfigClient::serviceAccountName()} for help formatting this field.
 */
function create_preview_sample(
    string $formattedParent,
    string $formattedPreviewServiceAccount
): void {
    // Create a client.
    $configClient = new ConfigClient();

    // Prepare the request message.
    $preview = (new Preview())
        ->setServiceAccount($formattedPreviewServiceAccount);
    $request = (new CreatePreviewRequest())
        ->setParent($formattedParent)
        ->setPreview($preview);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $configClient->createPreview($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Preview $result */
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
    $formattedParent = ConfigClient::locationName('[PROJECT]', '[LOCATION]');
    $formattedPreviewServiceAccount = ConfigClient::serviceAccountName(
        '[PROJECT]',
        '[SERVICE_ACCOUNT]'
    );

    create_preview_sample($formattedParent, $formattedPreviewServiceAccount);
}
// [END config_v1_generated_Config_CreatePreview_sync]
