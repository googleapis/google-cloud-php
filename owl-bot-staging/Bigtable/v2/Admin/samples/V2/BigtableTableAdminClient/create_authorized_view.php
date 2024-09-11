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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_CreateAuthorizedView_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\AuthorizedView;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\CreateAuthorizedViewRequest;
use Google\Rpc\Status;

/**
 * Creates a new AuthorizedView in a table.
 *
 * @param string $formattedParent  This is the name of the table the AuthorizedView belongs to.
 *                                 Values are of the form
 *                                 `projects/{project}/instances/{instance}/tables/{table}`. Please see
 *                                 {@see BigtableTableAdminClient::tableName()} for help formatting this field.
 * @param string $authorizedViewId The id of the AuthorizedView to create. This AuthorizedView must
 *                                 not already exist. The `authorized_view_id` appended to `parent` forms the
 *                                 full AuthorizedView name of the form
 *                                 `projects/{project}/instances/{instance}/tables/{table}/authorizedView/{authorized_view}`.
 */
function create_authorized_view_sample(string $formattedParent, string $authorizedViewId): void
{
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare the request message.
    $authorizedView = new AuthorizedView();
    $request = (new CreateAuthorizedViewRequest())
        ->setParent($formattedParent)
        ->setAuthorizedViewId($authorizedViewId)
        ->setAuthorizedView($authorizedView);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableTableAdminClient->createAuthorizedView($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AuthorizedView $result */
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
    $formattedParent = BigtableTableAdminClient::tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
    $authorizedViewId = '[AUTHORIZED_VIEW_ID]';

    create_authorized_view_sample($formattedParent, $authorizedViewId);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_CreateAuthorizedView_sync]
