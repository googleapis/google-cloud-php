<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\BigQuery\Connection;

use Google\Auth\GetUniverseDomainInterface;
use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\Upload\AbstractUploader;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Core\UriTrait;
use GuzzleHttp\Psr7\Utils;

/**
 * Implementation of the
 * [Google BigQuery JSON API](https://cloud.google.com/bigquery/docs/reference/v2/).
 *
 * @internal
 */
class Rest implements ConnectionInterface
{
    use RestTrait;
    use UriTrait;

    /**
     * @deprecated
     */
    const BASE_URI = 'https://www.googleapis.com/bigquery/v2/';

    /**
     * @deprecated
     */
    const DEFAULT_API_ENDPOINT = 'https://bigquery.googleapis.com';

    private const DEFAULT_API_ENDPOINT_TEMPLATE = 'https://bigquery.UNIVERSE_DOMAIN';

    /**
     * @deprecated
     */
    const UPLOAD_URI = 'https://www.googleapis.com/upload/bigquery/v2/projects/{projectId}/jobs';

    const UPLOAD_PATH = 'upload/bigquery/v2/projects/{projectId}/jobs';

    /**
     * @var string
     */
    private $apiEndpoint;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/bigquery-v2.json',
            'componentVersion' => BigQueryClient::VERSION,
            'apiEndpoint' => null,
            // If the user has not supplied a universe domain, use the environment variable if set.
            // Otherwise, use the default ("googleapis.com").
            'universeDomain' => getenv('GOOGLE_CLOUD_UNIVERSE_DOMAIN')
                ?: GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN,
        ];

        $apiEndpoint = $this->getApiEndpoint(null, $config, self::DEFAULT_API_ENDPOINT_TEMPLATE);

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $apiEndpoint
        ));

        $this->apiEndpoint = $apiEndpoint;
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteDataset(array $args = [])
    {
        return $this->send('datasets', 'delete', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function patchDataset(array $args = [])
    {
        return $this->send('datasets', 'patch', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getDataset(array $args = [])
    {
        return $this->send('datasets', 'get', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listDatasets(array $args = [])
    {
        return $this->send('datasets', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function insertDataset(array $args = [])
    {
        return $this->send('datasets', 'insert', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteTable(array $args = [])
    {
        return $this->send('tables', 'delete', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function patchTable(array $args = [])
    {
        return $this->send('tables', 'patch', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getTable(array $args = [])
    {
        return $this->send('tables', 'get', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function insertTable(array $args = [])
    {
        return $this->send('tables', 'insert', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listTables(array $args = [])
    {
        return $this->send('tables', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listTableData(array $args = [])
    {
        return $this->send('tabledata', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function insertAllTableData(array $args = [])
    {
        return $this->send('tabledata', 'insertAll', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function query(array $args = [])
    {
        return $this->send('jobs', 'query', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getQueryResults(array $args = [])
    {
        return $this->send('jobs', 'getQueryResults', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getJob(array $args = [])
    {
        return $this->send('jobs', 'get', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listJobs(array $args = [])
    {
        return $this->send('jobs', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function cancelJob(array $args = [])
    {
        return $this->send('jobs', 'cancel', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function insertJob(array $args = [])
    {
        return $this->send('jobs', 'insert', $args);
    }

    /**
     * @todo look into abstracting the upload logic here and in the storage REST implementation
     * @param array $args
     * @return AbstractUploader
     */
    public function insertJobUpload(array $args = [])
    {
        $args = $this->resolveUploadOptions($args);

        return new MultipartUploader(
            $this->requestWrapper,
            $args['data'],
            $this->expandUri($this->apiEndpoint . self::UPLOAD_PATH, ['projectId' => $args['projectId']]),
            $args['uploaderOptions']
        );
    }

    /**
     * @param array $args
     * @return array
     */
    public function getServiceAccount(array $args = [])
    {
        return $this->send('projects', 'getServiceAccount', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    private function resolveUploadOptions(array $args)
    {
        $args += [
            'projectId' => null,
            'data' => null,
            'configuration' => [],
            'labels' => [],
            'dryRun' => false,
            'jobReference' => []
        ];

        $args['data'] = Utils::streamFor($args['data']);
        $args['metadata'] = $this->pluckArray([
            'labels',
            'dryRun',
            'jobReference',
            'configuration'
        ], $args);

        $uploaderOptionKeys = [
            'restOptions',
            'retries',
            'requestTimeout',
            'metadata'
        ];

        $args['uploaderOptions'] = array_intersect_key($args, array_flip($uploaderOptionKeys));
        $args = array_diff_key($args, array_flip($uploaderOptionKeys));

        return $args;
    }

    /**
     * @param array $args
     * @return array
     */
    public function getModel(array $args = [])
    {
        return $this->send('models', 'get', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteModel(array $args = [])
    {
        return $this->send('models', 'delete', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function patchModel(array $args = [])
    {
        return $this->send('models', 'patch', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listModels(array $args = [])
    {
        return $this->send('models', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function insertRoutine(array $args = [])
    {
        return $this->send('routines', 'insert', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function updateRoutine(array $args = [])
    {
        return $this->send('routines', 'update', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getRoutine(array $args = [])
    {
        return $this->send('routines', 'get', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteRoutine(array $args = [])
    {
        return $this->send('routines', 'delete', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listRoutines(array $args = [])
    {
        return $this->send('routines', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getTableIamPolicy(array $args = [])
    {
        return $this->send('tables', 'getIamPolicy', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function setTableIamPolicy(array $args = [])
    {
        return $this->send('tables', 'setIamPolicy', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function testTableIamPermissions(array $args = [])
    {
        return $this->send('tables', 'testIamPermissions', $args);
    }
}
