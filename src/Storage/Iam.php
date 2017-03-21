<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage;

use Google\Cloud\Core\Iam\Iam as IamBase;
use Google\Cloud\Core\Iam\IamConnectionInterface;

/**
 * IAM implementation for Google Cloud Storage
 *
 * @see https://cloud.google.com/storage/docs/access-control/iam-with-json-and-xml IAM with JSON and XML
 */
class Iam extends IamBase
{
    const KIND = 'storage#policy';

    const BUCKET_IAM_RESOURCE = 'buckets/%s';
    const OBJECT_IAM_RESOURCE = 'buckets/%s/objects/%s';

    private $resourceArgs;

    /**
     * @param IamConnectionInterface $connection
     * @param string $resource
     * @param string $resourceArgumentName
     * @access private
     */
    public function __construct(
        IamConnectionInterface $connection,
        $resource,
        array $resourceArgs
    ) {
        $this->resourceArgs = $resourceArgs;

        parent::__construct($connection, $resource);
    }

    /**
     * Google Cloud Storage uses a different IAM implementation than other APIs
     * such as Pub/Sub and Spanner. This method overrides the default setPolicy
     * API call to provide a storage-compatible request.
     *
     * For the benefit of users with experience using Google Cloud PHP, Storage
     * IAM in GCP is formatted to match the resources used by other IAM
     * implementors.
     *
     * @param array $policy The IAM Policy as an array. Must have a `bindings`
     *        key which is of the correct format.
     * @param array $options Configuration Options
     * @return array
     */
    protected function sendSetPolicyRequest(array $policy, array $options)
    {
        $args = [
            'kind' => self::KIND,
            'bindings' => $policy['bindings'],
            'resourceId' => $this->resourceId()
        ] + $this->resourceArgs + $options;

        return $this->connection->setPolicy($args);
    }

    /**
     * Google Cloud Storage uses a different IAM implementation than other APIs
     * such as Pub/Sub and Spanner. This method overrides the default getPolicy
     * API call to provide a storage-compatible request.
     *
     * @param array $options Configuration Options
     * @return array
     */
    protected function sendGetPolicyRequest(array $options)
    {
        return $this->connection->getPolicy($this->resourceArgs + $options);
    }

    /**
     * Google Cloud Storage uses a different IAM implementation than other APIs
     * such as Pub/Sub and Spanner. This method overrides the default
     * testPermissions API call to provide a storage-compatible request.
     *
     * @param array $permissions The permissions to test.
     * @param array $options Configuration Options
     * @return array
     */
    protected function sendTestPermissionsRequest(array $permissions, array $options)
    {
        return $this->connection->testPermissions([
            'permissions' => $permissions
        ] + $this->resourceArgs + $options);
    }

    /**
     * Creates a resource ID to identify the resource which is being targeted.
     * For Buckets, the return will be of format `buckets/<bucketName>`. For
     * objects, the return will be of format `buckets/<bucketName>/objects/<objectName>`.
     *
     * The template is filled based on the value of `$resourceArgs` provided in
     * the class constructor.
     *
     * @return string
     */
    private function resourceId()
    {
        $args = $this->resourceArgs;
        if (isset($args['object'])) {
            return sprintf(self::OBJECT_IAM_RESOURCE, $args['bucket'], $args['object']);
        }

        return sprintf(self::BUCKET_IAM_RESOURCE, $args['bucket']);
    }
}
