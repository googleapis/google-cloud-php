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

// [START cloudresourcemanager_v3_generated_Projects_SearchProjects_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\ResourceManager\V3\Project;
use Google\Cloud\ResourceManager\V3\ProjectsClient;

/**
 * Search for projects that the caller has both `resourcemanager.projects.get`
 * permission on, and also satisfy the specified query.
 *
 * This method returns projects in an unspecified order.
 *
 * This method is eventually consistent with project mutations; this means
 * that a newly created project may not appear in the results or recent
 * updates to an existing project may not be reflected in the results. To
 * retrieve the latest state of a project, use the
 * [GetProject][google.cloud.resourcemanager.v3.Projects.GetProject] method.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function search_projects_sample(): void
{
    // Create a client.
    $projectsClient = new ProjectsClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $projectsClient->searchProjects();

        /** @var Project $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudresourcemanager_v3_generated_Projects_SearchProjects_sync]
