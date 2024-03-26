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

// [START securitycenter_v2_generated_SecurityCenter_GroupFindings_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\SecurityCenter\V2\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V2\GroupFindingsRequest;
use Google\Cloud\SecurityCenter\V2\GroupResult;

/**
 * Filters an organization or source's findings and groups them by their
 * specified properties in a location. If no location is specified, findings
 * are assumed to be in global
 *
 * To group across all sources provide a `-` as the source id.
 * The following list shows some examples:
 *
 * + `/v2/organizations/{organization_id}/sources/-/findings`
 * +
 * `/v2/organizations/{organization_id}/sources/-/locations/{location_id}/findings`
 * + `/v2/folders/{folder_id}/sources/-/findings`
 * + `/v2/folders/{folder_id}/sources/-/locations/{location_id}/findings`
 * + `/v2/projects/{project_id}/sources/-/findings`
 * + `/v2/projects/{project_id}/sources/-/locations/{location_id}/findings`
 *
 * @param string $formattedParent Name of the source to groupBy. If no location is specified,
 *                                finding is assumed to be in global.
 *                                The following list shows some examples:
 *
 *                                + `organizations/[organization_id]/sources/[source_id]`
 *                                +
 *                                `organizations/[organization_id]/sources/[source_id]/locations/[location_id]`
 *                                + `folders/[folder_id]/sources/[source_id]`
 *                                + `folders/[folder_id]/sources/[source_id]/locations/[location_id]`
 *                                + `projects/[project_id]/sources/[source_id]`
 *                                + `projects/[project_id]/sources/[source_id]/locations/[location_id]`
 *
 *                                To groupBy across all sources provide a source_id of `-`. The following
 *                                list shows some examples:
 *
 *                                + `organizations/{organization_id}/sources/-`
 *                                + `organizations/{organization_id}/sources/-/locations/[location_id]`
 *                                + `folders/{folder_id}/sources/-`
 *                                + `folders/{folder_id}/sources/-/locations/[location_id]`
 *                                + `projects/{project_id}/sources/-`
 *                                + `projects/{project_id}/sources/-/locations/[location_id]`
 *                                Please see {@see SecurityCenterClient::sourceName()} for help formatting this field.
 * @param string $groupBy         Expression that defines what assets fields to use for grouping.
 *                                The string value should follow SQL syntax: comma separated list of fields.
 *                                For example: "parent,resource_name".
 *
 *                                The following fields are supported:
 *
 *                                * resource_name
 *                                * category
 *                                * state
 *                                * parent
 *                                * severity
 */
function group_findings_sample(string $formattedParent, string $groupBy): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $request = (new GroupFindingsRequest())
        ->setParent($formattedParent)
        ->setGroupBy($groupBy);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $securityCenterClient->groupFindings($request);

        /** @var GroupResult $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = SecurityCenterClient::sourceName('[ORGANIZATION]', '[SOURCE]');
    $groupBy = '[GROUP_BY]';

    group_findings_sample($formattedParent, $groupBy);
}
// [END securitycenter_v2_generated_SecurityCenter_GroupFindings_sync]
