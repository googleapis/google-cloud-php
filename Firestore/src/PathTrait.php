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

use Ramsey\Uuid\Uuid;

/**
 * Provides methods for managing resource paths.
 */
trait PathTrait
{
    /**
     * Create a full name from a project, database and relative path.
     *
     * @param string $projectId
     * @param string $database
     * @param string $relativeName
     * @return string
     */
    private function fullName($projectId, $database, $relativeName)
    {
        $template = 'projects/%s/databases/%s/documents/%s';
        return sprintf($template, $projectId, $database, $relativeName);
    }

    /**
     * Create a full name from a database name and relative path.
     *
     * @param string $databaseName
     * @param string $relativeName
     * @return string
     */
    private function fullNameFromDatabase($databaseName, $relativeName)
    {
        $template = '%s/documents/%s';
        return sprintf($template, $databaseName, $relativeName);
    }

    /**
     * @param string $projectId The project ID.
     * @param string $database The database name.
     */
    private function databaseName($projectId, $database)
    {
        return sprintf('projects/%s/databases/%s', $projectId, $database);
    }

    /**
     * Get the database name from a path.
     *
     * @param string $name
     * @return string
     */
    private function databaseFromName($name)
    {
        $parts = explode('/databases/', $name);
        return $parts[0] . '/databases/' . explode('/', $parts[1])[0];
    }

    /**
     * Determine whether the given path is a document.
     *
     * @param string $name
     * @return bool
     */
    private function isDocument($name)
    {
        if (!$this->isRelative($name)) {
            $name = $this->relativeName($name);
        }

        $parts = $this->splitName($name);
        return count($parts) > 0 && count($parts) % 2 === 0;
    }

    /**
     * Determine whether the given path is a collection.
     *
     * @param string $name
     * @return bool
     */
    private function isCollection($name)
    {
        if (!$this->isRelative($name)) {
            $name = $this->relativeName($name);
        }

        $parts = $this->splitName($name);
        return count($parts) % 2 === 1;
    }

    /**
     * Determine whether the given path is relative or absolute.
     *
     * @param string $name
     * @return bool
     */
    private function isRelative($name)
    {
        $parts = $this->splitName($name);
        return count($parts) > 0 && $parts[0] !== 'projects';
    }

    /**
     * Split a path into pieces at the separator (`/`).
     *
     * @param string $name
     * @return array
     */
    private function splitName($name)
    {
        return explode('/', trim($name, '/'));
    }

    /**
     * Return the identifier from a path.
     *
     * @param string $name
     * @return string|null
     */
    private function pathId($name)
    {
        $parts = $this->splitName($name);
        if ($parts[0] === '') {
            return null;
        }

        return end($parts);
    }

    /**
     * Append a new element to a given path.
     *
     * @param string $name
     * @param string $child
     * @return string
     */
    private function childPath($name, $child)
    {
        return $name . '/' . $child;
    }

    /**
     * Get the current path's parent.
     * @param string $name
     * @return string
     */
    private function parentPath($name)
    {
        $parts = $this->splitName($name);
        array_pop($parts);

        return implode('/', $parts);
    }

    /**
     * Create a random name.
     *
     * @param string $parent
     * @return string
     */
    private function randomName($parent)
    {
        // UUIDs are a pre-existing library dependency, so we'll use that instead
        // of adding random_compat or something similar.
        // Generate a UUID, then strip `-` and trim to expected length.
        // @todo revisit once library requires php >= 7.0 and random_int() can be used without dependency.
        $rand = substr(str_replace('-', '', Uuid::uuid4()), 0, 20);

        return $this->childPath($parent, $rand);
    }

    /**
     * Get a relative name from an absolute name.
     *
     * @param string $name
     * @return string
     */
    private function relativeName($name)
    {
        $parts = $this->splitName($name);
        if ($parts[0] === 'projects' && $parts[2] === 'databases') {
            $parts = array_slice($parts, 5);

            $name = implode('/', $parts);
        }

        return $name;
    }

    /**
     * Check if the given `$original` path is a prefix of the `$other` path.
     *
     * @param string $original
     * @param string $other
     * @return bool
     */
    private function isPrefixOf($original, $other)
    {
        $original = $this->splitName($original);
        $other = $this->splitName($other);

        if (count($other) < count($original)) {
            return false;
        }

        foreach ($original as $i => $segment) {
            if ($segment !== $other[$i]) {
                return false;
            }
        }

        return true;
    }
}
