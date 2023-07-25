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

// [START dataplex_v1_generated_DataTaxonomyService_CreateDataAttributeBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\DataTaxonomyServiceClient;
use Google\Cloud\Dataplex\V1\CreateDataAttributeBindingRequest;
use Google\Cloud\Dataplex\V1\DataAttributeBinding;
use Google\Rpc\Status;

/**
 * Create a DataAttributeBinding resource.
 *
 * @param string $formattedParent        The resource name of the parent data taxonomy
 *                                       projects/{project_number}/locations/{location_id}
 *                                       Please see {@see DataTaxonomyServiceClient::locationName()} for help formatting this field.
 * @param string $dataAttributeBindingId DataAttributeBinding identifier.
 *                                       * Must contain only lowercase letters, numbers and hyphens.
 *                                       * Must start with a letter.
 *                                       * Must be between 1-63 characters.
 *                                       * Must end with a number or a letter.
 *                                       * Must be unique within the Location.
 */
function create_data_attribute_binding_sample(
    string $formattedParent,
    string $dataAttributeBindingId
): void {
    // Create a client.
    $dataTaxonomyServiceClient = new DataTaxonomyServiceClient();

    // Prepare the request message.
    $dataAttributeBinding = new DataAttributeBinding();
    $request = (new CreateDataAttributeBindingRequest())
        ->setParent($formattedParent)
        ->setDataAttributeBindingId($dataAttributeBindingId)
        ->setDataAttributeBinding($dataAttributeBinding);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataTaxonomyServiceClient->createDataAttributeBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DataAttributeBinding $result */
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
    $formattedParent = DataTaxonomyServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $dataAttributeBindingId = '[DATA_ATTRIBUTE_BINDING_ID]';

    create_data_attribute_binding_sample($formattedParent, $dataAttributeBindingId);
}
// [END dataplex_v1_generated_DataTaxonomyService_CreateDataAttributeBinding_sync]
