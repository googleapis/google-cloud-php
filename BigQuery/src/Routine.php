<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\BigQuery;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ConcurrencyControlTrait;
use Google\Cloud\Core\Exception\NotFoundException;

/**
 * [Routines](https://cloud.google.com/bigquery/docs/reference/rest/v2/routines)
 * are used-defined functions or stored procedures.
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigquery = new BigQueryClient();
 * $dataset = $bigquery->dataset('my_dataset');
 * $routine = $dataset->routine('my_routine');
 * ```
 */
class Routine
{
    use ArrayTrait;
    use ConcurrencyControlTrait;

    /**
     * @var ConnectionInterface
     * @internal
     */
    private $connection;

    /**
     * @var array
     */
    private $identity;

    /**
     * @var array
     */
    private $info;

    /**
     * @param ConnectionInterface $connection A connection to the BigQuery API.
     *        This object is created by BigQueryClient,
     *        and should not be instantiated outside of this client.
     * @param string $id The routine ID.
     * @param string $datasetId The dataset ID.
     * @param string $projectId The project ID.
     * @param array $info [optional] An optional representation of the routine
     *        resource.
     */
    public function __construct(ConnectionInterface $connection, $id, $datasetId, $projectId, array $info = [])
    {
        $this->connection = $connection;
        $this->identity = [
            'routineId' => $id,
            'datasetId' => $datasetId,
            'projectId' => $projectId
        ];
        $this->info = $info;
    }

    /**
     * Get the routine identity.
     *
     * An identity provides a description of a nested resource.
     *
     * Example:
     * ```
     * $identity = $routine->identity();
     * echo $identity['routineId'];
     * ```
     *
     * @return array
     */
    public function identity()
    {
        return $this->identity;
    }

    /**
     * Return the routine resource.
     *
     * If the value is not already cached, a service call will be made. To force
     * a refresh of the cached value, use
     * {@see Routine::reload()}.
     *
     * Example:
     * ```
     * $res = $routine->info();
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/routines/get Get Routines API documentation.
     * @param array $options [optional] Configuration options
     * @return array
     */
    public function info(array $options = [])
    {
        return $this->info ?: $this->reload($options);
    }

    /**
     * Fetch the routine resource from the API.
     *
     * This method will always trigger a service request. To make use of a
     * cached representation of the resource, see
     * {@see Routine::info()}.
     *
     * Example:
     * ```
     * $res = $routine->reload();
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/routines/get Get Routines API documentation.
     * @param array $options [optional] Configuration options
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getRoutine($this->identity + $options);
    }

    /**
     * Check whether or not the routine exists.
     *
     * Example:
     * ```
     * if ($routine->exists()) {
     *     echo 'Routine exists!';
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/routines/get Get Routines API documentation.
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->reload($options);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Update information in an existing routine.
     *
     * Providing an `etag` key as part of `$metadata` will enable simultaneous
     * update protection. This is useful in preventing override of modifications
     * made by another user. The resource's current etag can be obtained via a
     * GET request on the resource.
     *
     * Please note that by default the library will not automatically retry this
     * call on your behalf unless an `etag` is set.
     *
     * Please note that in order to implement partial updates, this method will
     * trigger two service calls: the first to fetch the most up-to-date version
     * of the resource and the second to apply the update.
     *
     * Example:
     * ```
     * $routine->update([
     *     'definitionBody' => 'CONCAT(x, "\n", y)'
     * ]);
     * ```
     *
     * ```
     * // Using update masks to limit modified fields
     * $newData = [
     *     'displayName' => 'My Function',
     *     'definitionBody' => 'return x + y;',
     *     'language' => 'JAVASCRIPT'
     * ];
     *
     * // Update the routine, excluding 'displayName' from updating.
     * $routine->update($newData, [
     *     'updateMask' => [
     *         'definitionBody',
     *         'language'
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/routines/update Update Routines API documentation.
     * @param array $metadata The full routine resource with desired
     *        modifications.
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type array $updateMask A list of field paths to be modified. Nested
     *           key names should be dot-separated, e.g. `returnType.typeKind`.
     *           Google Cloud PHP will attempt to infer this value on your
     *           behalf. You may use this field to limit which parts of the
     *           resource are updated, should you choose to provide the full
     *           resource as the `$metadata` argument.
     * }
     * @return array
     */
    public function update(array $metadata, array $options = [])
    {
        $current = $this->reload($options);

        $updateMaskPaths = $this->pluck('updateMask', $options, false) ?: [];
        if (!$updateMaskPaths) {
            $excludes = ['creationTime', 'lastModifiedTime'];
            $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($metadata));
            foreach ($iterator as $leafValue) {
                $keys = [];
                foreach (range(0, $iterator->getDepth()) as $depth) {
                    $keys[] = $iterator->getSubIterator($depth)->key();
                }

                $path = implode('.', $keys);
                if (!in_array($path, $excludes)) {
                    $updateMaskPaths[] = $path;
                }
            }
        }

        // apply new fields to full resource.
        $merged = $this->mergeUpdateResource($current, $metadata, $updateMaskPaths);

        $options = $this->applyEtagHeader(
            $this->identity
            + $options
            + $merged
        );

        if (!isset($options['etag']) && !isset($options['retries'])) {
            $options['retries'] = 0;
        }

        return $this->info = $this->connection->updateRoutine($options);
    }

    /**
     * Delete a routine.
     *
     * Please note that by default the library will not attempt to retry this
     * call on your behalf.
     *
     * Example:
     * ```
     * $routine->delete();
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/routines/delete Delete Routines API documentation.
     * @param array $options [optional] Configuration options.
     */
    public function delete(array $options = [])
    {
        return $this->connection->deleteRoutine(
            $this->identity
            + $options
            + ['retries' => 0]
        );
    }

    /**
     * Apply partial updates to routine resources.
     *
     * @param array $current The current API resource
     * @param array $new The new metadata
     * @param array $updateMaskPaths A list of paths for fields to be updated
     * @return array
     */
    private function mergeUpdateResource(array $current, array $new, array $updateMaskPaths)
    {
        $walk = function (array $tail, array &$current, array $new) use (&$walk) {
            if (count($tail) === 1 && isset($new[$tail[0]])) {
                $current[$tail[0]] = $new[$tail[0]];
                return;
            }

            $key = array_shift($tail);
            if (isset($new[$key])) {
                if (!isset($current[$key])) {
                    $current[$key] = [];
                }

                $walk($tail, $current[$key], $new[$key]);
            }

            return;
        };

        foreach ($updateMaskPaths as $path) {
            $parts = explode('.', $path);

            $walk($parts, $current, $new);
        }

        return $current;
    }
}
