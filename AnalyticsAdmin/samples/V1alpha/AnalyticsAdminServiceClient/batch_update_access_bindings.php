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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_BatchUpdateAccessBindings_sync]
use Google\Analytics\Admin\V1alpha\AccessBinding;
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\BatchUpdateAccessBindingsResponse;
use Google\Analytics\Admin\V1alpha\UpdateAccessBindingRequest;
use Google\ApiCore\ApiException;

/**
 * Updates information about multiple access bindings to an account or
 * property.
 *
 * @param string $formattedParent The account or property that owns the access bindings. The parent
 *                                of all provided AccessBinding in UpdateAccessBindingRequest messages must
 *                                match this field.
 *                                Formats:
 *                                - accounts/{account}
 *                                - properties/{property}
 *                                Please see {@see AnalyticsAdminServiceClient::accountName()} for help formatting this field.
 */
function batch_update_access_bindings_sample(string $formattedParent): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $requestsAccessBinding = new AccessBinding();
    $updateAccessBindingRequest = (new UpdateAccessBindingRequest())
        ->setAccessBinding($requestsAccessBinding);
    $requests = [$updateAccessBindingRequest,];

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateAccessBindingsResponse $response */
        $response = $analyticsAdminServiceClient->batchUpdateAccessBindings($formattedParent, $requests);
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
    $formattedParent = AnalyticsAdminServiceClient::accountName('[ACCOUNT]');

    batch_update_access_bindings_sample($formattedParent);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_BatchUpdateAccessBindings_sync]
