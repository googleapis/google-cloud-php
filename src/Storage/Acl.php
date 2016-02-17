<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage;

use Google\Cloud\Storage\Connection\ConnectionInterface;

// @todo finish docs
class Acl
{
    const ROLE_READER = 'READER';
    const ROLE_WRITER = 'WRITER';
    const ROLE_OWNER = 'OWNER';

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var array
     */
    private $aclOptions;

    /**
     * @param ConnectionInterface $connection
     * @param string $type
     * @param array $identity
     */
    public function __construct(ConnectionInterface $connection, $type, array $identity)
    {
        $validTypes = [
            'bucketAccessControls',
            'defaultObjectAccessControls',
            'objectAccessControls'
        ];

        if (!in_array($type, $validTypes)) {
            throw new \InvalidArgumentException('type must be one of the following: ' . implode(', ', $validTypes));
        }

        $this->connection = $connection;
        $this->aclOptions = $identity + ['type' => $type];
    }

    /**
     * Delete access controls on a Bucket or Object for a specified entity.
     *
     * Example:
     * ```
     * $acl->delete('allAuthenticatedUsers');
     * ```
     *
     * @param string $entity The entity to delete.
     * @param array $options Configuration options.
     * @return void
     */
    public function delete($entity, array $options = [])
    {
        $aclOptions = $this->aclOptions + ['entity' => $entity];
        $this->connection->deleteAcl($options + $aclOptions);
    }

    /**
     * Get access controls on a Bucket or Object. By default this will return
     * all available access controls. You may optionally specify a single entity
     * to return details for as well.
     *
     * Example:
     * ```
     * $acl->get(['entity' => 'allAuthenticatedUsers']);
     * ```
     *
     * @param array $options Configuration options. {
     *     @type string $entity The entity to fetch.
     * }
     * @return array
     */
    public function get(array $options = [])
    {
        if (isset($options['entity'])) {
            return $this->connection->getAcl($options + $this->aclOptions);
        }

        $response = $this->connection->listAcl($options + $this->aclOptions);
        return $response['items'];
    }

    /**
     * Add access controls on a Bucket or Object.
     *
     * Example:
     * ```
     * $acl->add('allAuthenticatedUsers', 'WRITER');
     * ```
     *
     * @param string $entity The entity to add access controls to.
     * @param string $role The permissions to add for the specified entity. May
     *        be one of 'OWNER', 'READER', or 'WRITER'.
     * @param array $options Configuration options.
     * @return array
     */
    public function add($entity, $role, array $options = [])
    {
        $aclOptions = $this->aclOptions + [
            'entity' => $entity,
            'role' => $role
        ];

        return $this->connection->insertAcl($options + $aclOptions);
    }

    /**
     * Update access controls on a Bucket or Object.
     *
     * Example:
     * ```
     * $acl->update('allAuthenticatedUsers', 'READER');
     * ```
     *
     * @param string $entity The entity to update access controls for.
     * @param string $role The permissions to update for the specified entity.
     *        May be one of 'OWNER', 'READER', or 'WRITER'.
     * @param array $options Configuration options.
     * @return array
     */
    public function update($entity, $role, array $options = [])
    {
        $aclOptions = $this->aclOptions + [
            'entity' => $entity,
            'role' => $role
        ];

        return $this->connection->patchAcl($options + $aclOptions);
    }
}
