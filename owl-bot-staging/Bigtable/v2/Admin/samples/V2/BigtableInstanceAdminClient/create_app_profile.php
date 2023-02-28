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

// [START bigtableadmin_v2_generated_BigtableInstanceAdmin_CreateAppProfile_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\AppProfile;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;

/**
 * Creates an app profile within an instance.
 *
 * @param string $formattedParent The unique name of the instance in which to create the new app profile.
 *                                Values are of the form
 *                                `projects/{project}/instances/{instance}`. Please see
 *                                {@see BigtableInstanceAdminClient::instanceName()} for help formatting this field.
 * @param string $appProfileId    The ID to be used when referring to the new app profile within its
 *                                instance, e.g., just `myprofile` rather than
 *                                `projects/myproject/instances/myinstance/appProfiles/myprofile`.
 */
function create_app_profile_sample(string $formattedParent, string $appProfileId): void
{
    // Create a client.
    $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $appProfile = new AppProfile();

    // Call the API and handle any network failures.
    try {
        /** @var AppProfile $response */
        $response = $bigtableInstanceAdminClient->createAppProfile(
            $formattedParent,
            $appProfileId,
            $appProfile
        );
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
    $formattedParent = BigtableInstanceAdminClient::instanceName('[PROJECT]', '[INSTANCE]');
    $appProfileId = '[APP_PROFILE_ID]';

    create_app_profile_sample($formattedParent, $appProfileId);
}
// [END bigtableadmin_v2_generated_BigtableInstanceAdmin_CreateAppProfile_sync]
