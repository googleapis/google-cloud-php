<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\BigQuery;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\Core\ConcurrencyControlTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Storage\StorageObject;

/**
 * A [BigQuery ML](https://cloud.google.com/bigquery-ml/docs/) Model represents what an ML system has learned from
 * the training data.
 */
class Model
{
    use ConcurrencyControlTrait;

    /**
     * @var ConnectionInterface Represents a connection to BigQuery.
     * @internal
     */
    private $connection;

    /**
     * @var array The model's identity
     */
    private $identity = [];

    /**
     * @var array The model's metadata.
     */
    private $info = [];

    /**
     * @var string The model location
     */
    private $location;

    /**
     * @param ConnectionInterface $connection Represents a connection to BigQuery.
     *        This object is created by BigQueryClient,
     *        and should not be instantiated outside of this client.
     * @param string $id The model's ID.
     * @param string $datasetId The dataset's ID.
     * @param string $projectId The project's ID.
     * @param array $info [optional] The model data.
     * @param array $location [optional] The location of the model.
     */
    public function __construct(
        ConnectionInterface $connection,
        $id,
        $datasetId,
        $projectId,
        array $info = [],
        $location = null
    ) {
        $this->connection = $connection;
        $this->identity = [
            'modelId' => $id,
            'datasetId' => $datasetId,
            'projectId' => $projectId
        ];
        $this->info = $info;
        $this->location = $location;
    }

    /**
     * Retrieves the model's details. If no model data is cached, a network request
     * will be made to retrieve it.
     *
     * Please note that Model instances created by list calls may not contain a
     * full representation of the model resource. To obtain a full resource on a
     * Model instance, call {@see Model::reload()}.
     *
     * Example:
     * ```
     * $info = $model->info();
     * echo $info['modelType'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/models Model resource documentation.
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function info(array $options = [])
    {
        return $this->info ?: $this->reload($options);
    }

    /**
     * Triggers a network request to reload the model's details.
     *
     * Example:
     * ```
     * $model->reload();
     * $info = $model->info();
     * echo $info['modelType'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/models/get Models get API documentation.
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getModel($this->identity + $options);
    }

    /**
     * Retrieves the model's ID.
     *
     * Example:
     * ```
     *  echo $model->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->identity['modelId'];
    }

    /**
     * Retrieves the model's identity.
     *
     * An identity provides a description of a resource that is nested in nature.
     *
     * Example:
     * ```
     * echo $model->identity()['modelId'];
     * ```
     *
     * @return array
     */
    public function identity()
    {
        return $this->identity;
    }

    /**
     * Delete the model.
     *
     * Please note that by default the library will not attempt to retry this
     * call on your behalf.
     *
     * Example:
     * ```
     * $model->delete();
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/models/delete Models delete API documentation.
     *
     * @param array $options [optional] Configuration options.
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteModel(
            $this->identity
            + ['retries' => 0]
            + $options
        );
    }

    /**
     * Check whether or not the model exists.
     *
     * Example:
     * ```
     * echo $model->exists();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->reload($options);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    /**
     * Update the model.
     *
     * Providing an `etag` key as part of `$metadata` will enable simultaneous
     * update protection. This is useful in preventing override of modifications
     * made by another user. The resource's current etag can be obtained via a
     * GET request on the resource.
     *
     * Please note that by default this call will not automatically retry on
     * your behalf unless an `etag` is set.
     *
     * Example:
     * ```
     * $model->update([
     *     'friendlyName' => 'My ML model'
     * ]);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/models/patch Model's patch API documentation.
     * @see https://cloud.google.com/bigquery/docs/api-performance#patch Patch (Partial Update)
     *
     * @param array $metadata The available options for metadata are outlined
     *        at the [Model Resource API docs](https://cloud.google.com/bigquery/docs/reference/rest/v2/models)
     * @param array $options [optional] Configuration options.
     *
     * @return array
     */
    public function update(array $metadata, array $options = [])
    {
        $options = $this->applyEtagHeader(
            $this->identity
            + $metadata
            + $options
        );

        if (!isset($options['etag']) && !isset($options['retries'])) {
            $options['retries'] = 0;
        }

        return $this->info = $this->connection->patchModel($options);
    }

    /**
     * Returns a BigQuery extract job configuration.
     *
     * The job configuration is passed to either
     * {@see BigQueryClient::runJob()} or
     * {@see BigQueryClient::startJob()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Example:
     * ```
     * $destinationObject = $storage->bucket('myBucket')->object('modelOutput');
     * $extractJobConfig = $model->extract($destinationObject);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param string|StorageObject $destination The destination object. May be
     *        a {@see StorageObject} or a URI pointing to
     *        a Google Cloud Storage object in the format of
     *        `gs://{bucket-name}/{object-name}`.
     * @param array $options [optional] Please see the
     *        [upstream API documentation for Job configuration]
     *        (https://cloud.google.com/bigquery/docs/reference/rest/v2/Job)
     *        for the available options.
     * @return ExtractJobConfiguration
     */
    public function extract($destination, array $options = [])
    {
        if ($destination instanceof StorageObject) {
            $destination = $destination->gcsUri();
        }

        return (new ExtractJobConfiguration(
            $this->identity['projectId'],
            $options,
            isset($this->info['location'])
                ? $this->info['location']
                : $this->location
        ))
            ->destinationUris([$destination])
            ->sourceModel($this);
    }
}
