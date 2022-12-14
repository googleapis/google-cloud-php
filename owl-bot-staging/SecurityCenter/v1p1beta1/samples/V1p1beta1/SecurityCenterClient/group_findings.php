<?php
/*
 * Copyright 2022 Google LLC
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

// [START securitycenter_v1p1beta1_generated_SecurityCenter_GroupFindings_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\SecurityCenter\V1p1beta1\GroupResult;
use Google\Cloud\SecurityCenter\V1p1beta1\SecurityCenterClient;

/**
 * Filters an organization or source's findings and  groups them by their
 * specified properties.
 *
 * To group across all sources provide a `-` as the source id.
 * Example: /v1/organizations/{organization_id}/sources/-/findings,
 * /v1/folders/{folder_id}/sources/-/findings,
 * /v1/projects/{project_id}/sources/-/findings
 *
 * @param string $formattedParent Name of the source to groupBy. Its format is
 *                                "organizations/[organization_id]/sources/[source_id]",
 *                                folders/[folder_id]/sources/[source_id], or
 *                                projects/[project_id]/sources/[source_id]. To groupBy across all sources
 *                                provide a source_id of `-`. For example:
 *                                organizations/{organization_id}/sources/-, folders/{folder_id}/sources/-,
 *                                or projects/{project_id}/sources/-
 *                                Please see {@see SecurityCenterClient::sourceName()} for help formatting this field.
 * @param string $groupBy         Expression that defines what assets fields to use for grouping (including
 *                                `state_change`). The string value should follow SQL syntax: comma separated
 *                                list of fields. For example: "parent,resource_name".
 *
 *                                The following fields are supported:
 *
 *                                * resource_name
 *                                * category
 *                                * state
 *                                * parent
 *                                * severity
 *
 *                                The following fields are supported when compare_duration is set:
 *
 *                                * state_change
 */
function group_findings_sample(string $formattedParent, string $groupBy): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $securityCenterClient->groupFindings($formattedParent, $groupBy);

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
// [END securitycenter_v1p1beta1_generated_SecurityCenter_GroupFindings_sync]
