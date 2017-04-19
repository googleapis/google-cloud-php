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

namespace Google\Cloud\Tests\Unit\Core\Report;

/**
 * @group core
 */
trait EnvTestTrait
{
    private $originals = [];
    
    public function preserveEnvs(array $envs)
    {
        foreach ($envs as $env) {
            $this->originals[$env] = getenv($env);
        }
    }

    public function restoreEnvs(array $envs)
    {
        foreach ($envs as $env) {
            if (isset($this->originals[$env])
                && $this->originals[$env] !== false) {
                putenv("$env=" . $this->originals[$env]);
            } else {
                putenv($env);
            }
        }
    }

    public function setEnv($key, $value)
    {
        if (! isset($this->originals[$key])) {
            throw new \InvalidArgumentException("$key is not preserved.");
        }
        if ($value === false) {
            putenv("$key");
        } else {
            putenv("$key=$value");
        }
    }
}
