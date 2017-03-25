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
 * An interface for storing the configuration.
 */
interface ConfigStorageInterface
{
    /**
     * locks the storage
     */
    public function lock();

    /**
     * unlocks the lock
     */
    public function unlock();

    /**
     * saves the BatchConfig to the storage
     */
    public function save(BatchConfig $config);

    /**
     * loads the AsyncBatchConfig from the storage
     *
     * @return BatchConfig
     */
    public function load();
}
