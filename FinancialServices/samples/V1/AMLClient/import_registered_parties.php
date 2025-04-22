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

// [START financialservices_v1_generated_AML_ImportRegisteredParties_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\FinancialServices\V1\Client\AMLClient;
use Google\Cloud\FinancialServices\V1\ImportRegisteredPartiesRequest;
use Google\Cloud\FinancialServices\V1\ImportRegisteredPartiesRequest\UpdateMode;
use Google\Cloud\FinancialServices\V1\ImportRegisteredPartiesResponse;
use Google\Cloud\FinancialServices\V1\LineOfBusiness;
use Google\Rpc\Status;

/**
 * Imports the list of registered parties. See
 * [Create and manage
 * instances](https://cloud.google.com/financial-services/anti-money-laundering/docs/create-and-manage-instances#import-registered-parties)
 * for information on the input schema and response for this method.
 *
 * @param string $formattedName  The full path to the Instance resource in this API.
 *                               format: `projects/{project}/locations/{location}/instances/{instance}`
 *                               Please see {@see AMLClient::instanceName()} for help formatting this field.
 * @param int    $mode           Mode of the request.
 * @param int    $lineOfBusiness LineOfBusiness for the specified registered parties.
 */
function import_registered_parties_sample(
    string $formattedName,
    int $mode,
    int $lineOfBusiness
): void {
    // Create a client.
    $aMLClient = new AMLClient();

    // Prepare the request message.
    $request = (new ImportRegisteredPartiesRequest())
        ->setName($formattedName)
        ->setMode($mode)
        ->setLineOfBusiness($lineOfBusiness);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $aMLClient->importRegisteredParties($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportRegisteredPartiesResponse $result */
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
    $formattedName = AMLClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $mode = UpdateMode::UPDATE_MODE_UNSPECIFIED;
    $lineOfBusiness = LineOfBusiness::LINE_OF_BUSINESS_UNSPECIFIED;

    import_registered_parties_sample($formattedName, $mode, $lineOfBusiness);
}
// [END financialservices_v1_generated_AML_ImportRegisteredParties_sync]
