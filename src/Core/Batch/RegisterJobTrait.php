<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Batch;

/**
 * A trait to assist with the registering of jobs.
 */
trait RegisterJobTrait
{
    /**
     * @var array
     */
    private $batchOptions;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * @var BatchRunner
     */
    private $batchRunner;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var bool
     */
    private $debugOutput;

    /**
     * @param array $options [optional] {
     *     Configuration options.
     *     @type bool $debugOutput Whether or not to output debug information.
     *           **Defaults to** false.
     *     @type array $batchOptions An option to BatchJob.
     *           {@see \Google\Cloud\Core\Batch\BatchJob::__construct()}
     *           **Defaults to** ['batchSize' => 1000,
     *                            'callPeriod' => 2.0,
     *                            'workerNum' => 10].
     *     @type array $clientConfig A config used to construct the client upon
     *           which requests will be made.
     *     @type BatchRunner $batchRunner A BatchRunner object. Mainly used for
     *           the tests to inject a mock. **Defaults to** a newly created
     *           BatchRunner.
     * }
     */
    private function setJobProperties(array $options)
    {
        if (!isset($options['identifier'])) {
            throw new \InvalidArgumentException(
                'A valid identifier is required in order to register a job.'
            );
        }

        $this->identifier = $options['identifier'];
        $this->debugOutput = isset($options['debugOutput'])
            ? $options['debugOutput']
            : false;
        $this->clientConfig = isset($options['clientConfig'])
            ? $options['clientConfig']
            : [];
        $batchOptions = isset($options['batchOptions'])
            ? $options['batchOptions']
            : [];
        $this->batchOptions = array_merge([
            'batchSize' => 1000,
            'callPeriod' => 2.0,
            'workerNum' => 10
        ], $batchOptions);
        $this->batchRunner = isset($options['batchRunner'])
            ? $options['batchRunner']
            : new BatchRunner();
    }
}
