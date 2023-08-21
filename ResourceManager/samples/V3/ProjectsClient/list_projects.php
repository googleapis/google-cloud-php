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

// [START cloudresourcemanager_v3_generated_Projects_ListProjects_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\ResourceManager\V3\Client\ProjectsClient;
use Google\Cloud\ResourceManager\V3\ListProjectsRequest;
use Google\Cloud\ResourceManager\V3\Project;

/**
 * Lists projects that are direct children of the specified folder or
 * organization resource. `list()` provides a strongly consistent view of the
 * projects underneath the specified parent resource. `list()` returns
 * projects sorted based upon the (ascending) lexical ordering of their
 * `display_name`. The caller must have `resourcemanager.projects.list`
 * permission on the identified parent.
 *
 * @param string $parent The name of the parent resource whose projects are being listed.
 *                       Only children of this parent resource are listed; descendants are not
 *                       listed.
 *
 *                       If the parent is a folder, use the value `folders/{folder_id}`. If the
 *                       parent is an organization, use the value `organizations/{org_id}`.
 */
function list_projects_sample(string $parent): void
{
    // Create a client.
    $projectsClient = new ProjectsClient();

    // Prepare the request message.
    $request = (new ListProjectsRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $projectsClient->listProjects($request);

        /** @var Project $element */
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
    $parent = '[PARENT]';

    list_projects_sample($parent);
}
// [END cloudresourcemanager_v3_generated_Projects_ListProjects_sync]
