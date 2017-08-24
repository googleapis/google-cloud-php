<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore;

trait PathTrait
{
    private function fullName($projectId, $database, $relativeName)
    {
        $template = 'projects/%s/databases/%s/documents/%s';
        return sprintf($template, $projectId, $database, $relativeName);
    }

    private function isDocument($relativeName)
    {
        $parts = $this->splitName($relativeName);
        return count($parts) > 0 && count($parts) % 2 === 0;
    }

    private function isCollection($relativeName)
    {
        $parts = $this->splitName($relativeName);
        return count($parts) % 2 === 1;
    }

    private function splitName($relativeName)
    {
        return explode('/', trim($relativeName, '/'));
    }

    private function id($relativeName)
    {
        $parts = $this->splitName($relativeName);
        if (count($parts) === 0) {
            return null;
        }

        return end($this->parts);
    }
}
