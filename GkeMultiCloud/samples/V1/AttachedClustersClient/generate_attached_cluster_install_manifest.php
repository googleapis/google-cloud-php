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

// [START gkemulticloud_v1_generated_AttachedClusters_GenerateAttachedClusterInstallManifest_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeMultiCloud\V1\Client\AttachedClustersClient;
use Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterInstallManifestRequest;
use Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterInstallManifestResponse;

/**
 * Generates the install manifest to be installed on the target cluster.
 *
 * @param string $formattedParent   The parent location where this
 *                                  [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
 *                                  will be created.
 *
 *                                  Location names are formatted as `projects/<project-id>/locations/<region>`.
 *
 *                                  See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                                  for more details on Google Cloud resource names. Please see
 *                                  {@see AttachedClustersClient::locationName()} for help formatting this field.
 * @param string $attachedClusterId A client provided ID of the resource. Must be unique within the
 *                                  parent resource.
 *
 *                                  The provided ID will be part of the
 *                                  [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
 *                                  name formatted as
 *                                  `projects/<project-id>/locations/<region>/attachedClusters/<cluster-id>`.
 *
 *                                  Valid characters are `/[a-z][0-9]-/`. Cannot be longer than 63 characters.
 *
 *                                  When generating an install manifest for importing an existing Membership
 *                                  resource, the attached_cluster_id field must be the Membership id.
 *
 *                                  Membership names are formatted as
 *                                  `projects/<project-id>/locations/<region>/memberships/<membership-id>`.
 * @param string $platformVersion   The platform version for the cluster (e.g. `1.19.0-gke.1000`).
 *
 *                                  You can list all supported versions on a given Google Cloud region by
 *                                  calling
 *                                  [GetAttachedServerConfig][google.cloud.gkemulticloud.v1.AttachedClusters.GetAttachedServerConfig].
 */
function generate_attached_cluster_install_manifest_sample(
    string $formattedParent,
    string $attachedClusterId,
    string $platformVersion
): void {
    // Create a client.
    $attachedClustersClient = new AttachedClustersClient();

    // Prepare the request message.
    $request = (new GenerateAttachedClusterInstallManifestRequest())
        ->setParent($formattedParent)
        ->setAttachedClusterId($attachedClusterId)
        ->setPlatformVersion($platformVersion);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateAttachedClusterInstallManifestResponse $response */
        $response = $attachedClustersClient->generateAttachedClusterInstallManifest($request);
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
    $formattedParent = AttachedClustersClient::locationName('[PROJECT]', '[LOCATION]');
    $attachedClusterId = '[ATTACHED_CLUSTER_ID]';
    $platformVersion = '[PLATFORM_VERSION]';

    generate_attached_cluster_install_manifest_sample(
        $formattedParent,
        $attachedClusterId,
        $platformVersion
    );
}
// [END gkemulticloud_v1_generated_AttachedClusters_GenerateAttachedClusterInstallManifest_sync]
