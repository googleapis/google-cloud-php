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

// [START cloudresourcemanager_v3_generated_Projects_SetIamPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\ResourceManager\V3\ProjectsClient;

/**
 * Sets the IAM access control policy for the specified project, in the
 * format `projects/{ProjectIdOrNumber}` e.g. projects/123.
 *
 * CAUTION: This method will replace the existing policy, and cannot be used
 * to append additional IAM settings.
 *
 * Note: Removing service accounts from policies or changing their roles can
 * render services completely inoperable. It is important to understand how
 * the service account is being used before removing or updating its roles.
 *
 * The following constraints apply when using `setIamPolicy()`:
 *
 * + Project does not support `allUsers` and `allAuthenticatedUsers` as
 * `members` in a `Binding` of a `Policy`.
 *
 * + The owner role can be granted to a `user`, `serviceAccount`, or a group
 * that is part of an organization. For example,
 * group&#64;myownpersonaldomain.com could be added as an owner to a project in
 * the myownpersonaldomain.com organization, but not the examplepetstore.com
 * organization.
 *
 * + Service accounts can be made owners of a project directly
 * without any restrictions. However, to be added as an owner, a user must be
 * invited using the Cloud Platform console and must accept the invitation.
 *
 * + A user cannot be granted the owner role using `setIamPolicy()`. The user
 * must be granted the owner role using the Cloud Platform Console and must
 * explicitly accept the invitation.
 *
 * + Invitations to grant the owner role cannot be sent using
 * `setIamPolicy()`;
 * they must be sent only using the Cloud Platform Console.
 *
 * + If the project is not part of an organization, there must be at least
 * one owner who has accepted the Terms of Service (ToS) agreement in the
 * policy. Calling `setIamPolicy()` to remove the last ToS-accepted owner
 * from the policy will fail. This restriction also applies to legacy
 * projects that no longer have owners who have accepted the ToS. Edits to
 * IAM policies will be rejected until the lack of a ToS-accepting owner is
 * rectified. If the project is part of an organization, you can remove all
 * owners, potentially making the organization inaccessible.
 *
 * @param string $resource REQUIRED: The resource for which the policy is being specified.
 *                         See the operation documentation for the appropriate value for this field.
 */
function set_iam_policy_sample(string $resource): void
{
    // Create a client.
    $projectsClient = new ProjectsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $policy = new Policy();

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $projectsClient->setIamPolicy($resource, $policy);
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
    $resource = '[RESOURCE]';

    set_iam_policy_sample($resource);
}
// [END cloudresourcemanager_v3_generated_Projects_SetIamPolicy_sync]
