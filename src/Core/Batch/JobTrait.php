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

trait JobTrait
{
    /**
     * @var string The job identifier
     */
    private $identifier;

    /**
     * @var int The job id
     */
    private $id;

    /**
     * @var int the worker number
     */
    private $worker;

    /**
     * Return the job identifier
     *
     * @return string
     */
    public function identifier()
    {
        return $this->identifier;
    }

    /**
     * Returns the id number of this job
     *
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Returns the worker number of this job
     *
     * @return int
     */
    public function worker()
    {
        return $this->worker;
    }
}
