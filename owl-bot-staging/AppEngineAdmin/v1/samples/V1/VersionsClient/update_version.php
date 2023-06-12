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

// [START appengine_v1_generated_Versions_UpdateVersion_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AppEngine\V1\Version;
use Google\Cloud\AppEngine\V1\VersionsClient;
use Google\Rpc\Status;

/**
 * Updates the specified Version resource.
 * You can specify the following fields depending on the App Engine
 * environment and type of scaling that the version resource uses:
 *
 * **Standard environment**
 *
 * * [`instance_class`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.instance_class)
 *
 * *automatic scaling* in the standard environment:
 *
 * * [`automatic_scaling.min_idle_instances`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.automatic_scaling)
 * * [`automatic_scaling.max_idle_instances`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.automatic_scaling)
 * * [`automaticScaling.standard_scheduler_settings.max_instances`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#StandardSchedulerSettings)
 * * [`automaticScaling.standard_scheduler_settings.min_instances`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#StandardSchedulerSettings)
 * * [`automaticScaling.standard_scheduler_settings.target_cpu_utilization`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#StandardSchedulerSettings)
 * * [`automaticScaling.standard_scheduler_settings.target_throughput_utilization`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#StandardSchedulerSettings)
 *
 * *basic scaling* or *manual scaling* in the standard environment:
 *
 * * [`serving_status`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.serving_status)
 * * [`manual_scaling.instances`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#manualscaling)
 *
 * **Flexible environment**
 *
 * * [`serving_status`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.serving_status)
 *
 * *automatic scaling* in the flexible environment:
 *
 * * [`automatic_scaling.min_total_instances`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.automatic_scaling)
 * * [`automatic_scaling.max_total_instances`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.automatic_scaling)
 * * [`automatic_scaling.cool_down_period_sec`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.automatic_scaling)
 * * [`automatic_scaling.cpu_utilization.target_utilization`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#Version.FIELDS.automatic_scaling)
 *
 * *manual scaling* in the flexible environment:
 *
 * * [`manual_scaling.instances`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions#manualscaling)
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_version_sample(): void
{
    // Create a client.
    $versionsClient = new VersionsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $versionsClient->updateVersion();
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Version $result */
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
// [END appengine_v1_generated_Versions_UpdateVersion_sync]
