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

// [START dataplex_v1_generated_DataProductService_RequestDataProductAccess_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\ChangeRequest;
use Google\Cloud\Dataplex\V1\Client\DataProductServiceClient;
use Google\Cloud\Dataplex\V1\RequestDataProductAccessRequest;
use Google\Cloud\Dataplex\V1\RequestDataProductAccessResponse;

/**
 * Requests access to a data product. This will trigger an access approval
 * workflow, and the requester will need to wait for the approval to be
 * granted before they will be able to access the data product assets.
 *
 * @param string $formattedParent The resource name of the data product.
 *                                Format:
 *                                projects/{project_number}/locations/{location_id}/dataProducts/{data_product_id}
 *                                Please see {@see DataProductServiceClient::dataProductName()} for help formatting this field.
 */
function request_data_product_access_sample(string $formattedParent): void
{
    // Create a client.
    $dataProductServiceClient = new DataProductServiceClient();

    // Prepare the request message.
    $changeRequest = new ChangeRequest();
    $request = (new RequestDataProductAccessRequest())
        ->setParent($formattedParent)
        ->setChangeRequest($changeRequest);

    // Call the API and handle any network failures.
    try {
        /** @var RequestDataProductAccessResponse $response */
        $response = $dataProductServiceClient->requestDataProductAccess($request);
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
    $formattedParent = DataProductServiceClient::dataProductName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_PRODUCT]'
    );

    request_data_product_access_sample($formattedParent);
}
// [END dataplex_v1_generated_DataProductService_RequestDataProductAccess_sync]
