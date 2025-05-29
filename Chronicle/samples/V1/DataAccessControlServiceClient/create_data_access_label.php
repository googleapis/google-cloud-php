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

// [START chronicle_v1_generated_DataAccessControlService_CreateDataAccessLabel_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\DataAccessControlServiceClient;
use Google\Cloud\Chronicle\V1\CreateDataAccessLabelRequest;
use Google\Cloud\Chronicle\V1\DataAccessLabel;

/**
 * Creates a data access label.
 * Data access labels are applied to incoming event data and selected in data
 * access scopes (another resource), and only users with scopes containing the
 * label can see data with that label. Currently, the data access label
 * resource only includes custom labels, which are labels that correspond
 * to UDM queries over event data.
 *
 * @param string $formattedParent   The parent resource where this Data Access Label will be created.
 *                                  Format: `projects/{project}/locations/{location}/instances/{instance}`
 *                                  Please see {@see DataAccessControlServiceClient::instanceName()} for help formatting this field.
 * @param string $dataAccessLabelId The ID to use for the data access label, which will become the
 *                                  label's display name and the final component of the label's resource name.
 *                                  The maximum number of characters should be 63. Regex pattern is as per AIP:
 *                                  https://google.aip.dev/122#resource-id-segments
 */
function create_data_access_label_sample(string $formattedParent, string $dataAccessLabelId): void
{
    // Create a client.
    $dataAccessControlServiceClient = new DataAccessControlServiceClient();

    // Prepare the request message.
    $dataAccessLabel = new DataAccessLabel();
    $request = (new CreateDataAccessLabelRequest())
        ->setParent($formattedParent)
        ->setDataAccessLabel($dataAccessLabel)
        ->setDataAccessLabelId($dataAccessLabelId);

    // Call the API and handle any network failures.
    try {
        /** @var DataAccessLabel $response */
        $response = $dataAccessControlServiceClient->createDataAccessLabel($request);
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
    $formattedParent = DataAccessControlServiceClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]'
    );
    $dataAccessLabelId = '[DATA_ACCESS_LABEL_ID]';

    create_data_access_label_sample($formattedParent, $dataAccessLabelId);
}
// [END chronicle_v1_generated_DataAccessControlService_CreateDataAccessLabel_sync]
