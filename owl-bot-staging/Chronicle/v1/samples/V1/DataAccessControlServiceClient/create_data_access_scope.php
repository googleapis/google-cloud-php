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

// [START chronicle_v1_generated_DataAccessControlService_CreateDataAccessScope_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\DataAccessControlServiceClient;
use Google\Cloud\Chronicle\V1\CreateDataAccessScopeRequest;
use Google\Cloud\Chronicle\V1\DataAccessScope;

/**
 * Creates a data access scope.
 * Data access scope is a combination of allowed and denied labels attached
 * to a permission group. If a scope has allowed labels A and B and denied
 * labels C and D, then the group of people attached to the scope
 * will have permissions to see all events labeled with A or B (or both) and
 * not labeled with either C or D.
 *
 * @param string $formattedParent              The parent resource where this Data Access Scope will be created.
 *                                             Format: `projects/{project}/locations/{location}/instances/{instance}`
 *                                             Please see {@see DataAccessControlServiceClient::instanceName()} for help formatting this field.
 * @param string $formattedDataAccessScopeName The unique full name of the data access scope.
 *                                             The name should comply with https://google.aip.dev/122 standards. Please see
 *                                             {@see DataAccessControlServiceClient::dataAccessScopeName()} for help formatting this field.
 * @param string $dataAccessScopeId            The user provided scope id which will become the last part of the
 *                                             name of the scope resource. Needs to be compliant with
 *                                             https://google.aip.dev/122
 */
function create_data_access_scope_sample(
    string $formattedParent,
    string $formattedDataAccessScopeName,
    string $dataAccessScopeId
): void {
    // Create a client.
    $dataAccessControlServiceClient = new DataAccessControlServiceClient();

    // Prepare the request message.
    $dataAccessScope = (new DataAccessScope())
        ->setName($formattedDataAccessScopeName);
    $request = (new CreateDataAccessScopeRequest())
        ->setParent($formattedParent)
        ->setDataAccessScope($dataAccessScope)
        ->setDataAccessScopeId($dataAccessScopeId);

    // Call the API and handle any network failures.
    try {
        /** @var DataAccessScope $response */
        $response = $dataAccessControlServiceClient->createDataAccessScope($request);
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
    $formattedDataAccessScopeName = DataAccessControlServiceClient::dataAccessScopeName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[DATA_ACCESS_SCOPE]'
    );
    $dataAccessScopeId = '[DATA_ACCESS_SCOPE_ID]';

    create_data_access_scope_sample(
        $formattedParent,
        $formattedDataAccessScopeName,
        $dataAccessScopeId
    );
}
// [END chronicle_v1_generated_DataAccessControlService_CreateDataAccessScope_sync]
