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

use Google\Cloud\Core\SysvTrait;

class SimpleJob implements JobInterface
{
    use JobTrait;

    /**
     * @var callable
     */
    private $func;

    /**
     * @var string
     */
    private $bootstrapFile;

    public function __construct($identifier, $func, array $options = [])
    {
        $this->identifier = $identifier;
        $this->func = $func;
        $this->id = 1;

        $options += [
            'bootstrapFile' => null
        ];
        $this->bootstrapFile = $options['bootstrapFile'];
    }

    public function run()
    {
        if ($this->bootstrapFile) {
            require_once $this->bootstrapFile;
        }
        call_user_func($this->func);
    }

    public function numWorkers()
    {
        return 1;
    }

    /**
     * Returns the id number of this job
     *
     * @return int
     */
    public function id()
    {
        return 1;
    }

    public function __wakeup()
    {
        if ($this->bootstrapFile && !in_array($this->bootstrapFile, get_included_files())) {
            require_once $this->bootstrapFile;
            throw new ReloadJobConfigException();
        }
    }

}
