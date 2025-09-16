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

// [START bigtableadmin_v2_generated_BigtableInstanceAdmin_UpdateMaterializedView_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\MaterializedView;
use Google\Cloud\Bigtable\Admin\V2\UpdateMaterializedViewRequest;
use Google\Rpc\Status;

/**
 * Updates a materialized view within an instance.
 *
 * @param string $materializedViewQuery Immutable. The materialized view's select query.
 */
function update_materialized_view_sample(string $materializedViewQuery): void
{
    // Create a client.
    $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();

    // Prepare the request message.
    $materializedView = (new MaterializedView())
        ->setQuery($materializedViewQuery);
    $request = (new UpdateMaterializedViewRequest())
        ->setMaterializedView($materializedView);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableInstanceAdminClient->updateMaterializedView($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MaterializedView $result */
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
    $materializedViewQuery = '[QUERY]';

    update_materialized_view_sample($materializedViewQuery);
}
// [END bigtableadmin_v2_generated_BigtableInstanceAdmin_UpdateMaterializedView_sync]
