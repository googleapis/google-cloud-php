<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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
 * A trait to assist in the registering and processing of batch jobs.
 *
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
trait SimpleJobTrait
{
    abstract public function run();

    private function setSimpleJobProperties(array $options)
    {
        if (!isset($options['identifier'])) {
            throw new \InvalidArgumentException(
                'A valid identifier is required in order to register a job.'
            );
        }

        $options += [
            'configStorage' => null
        ];

        $identifier = $options['identifier'];
        $configStorage = $options['configStorage'] ?: $this->defaultConfigStorage();

        $result = $configStorage->lock();
        if ($result === false) {
            return false;
        }
        $config = $configStorage->load();
        echo "registering job!\n";
        $config->registerJob(
            $identifier,
            function ($idNum, $identifier) use ($options) {
                return new SimpleJob($identifier, [$this, 'run'], $options);
            }
        );
        try {
            $result = $configStorage->save($config);
        } finally {
            $configStorage->unlock();
        }
        return $result;
    }

    private function defaultConfigStorage()
    {
        if ($this->isSysvIPCLoaded() && $this->isDaemonRunning()) {
            return new SysvConfigStorage();
        } else {
            return InMemoryConfigStorage::getInstance();
        }
    }
}
