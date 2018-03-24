<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner\Session;

use Google\Cloud\Spanner\Database;

/**
 * Describes a session pool.
 */
interface SessionPoolInterface
{
    const CONTEXT_READ = 'r';
    const CONTEXT_READWRITE = 'rw';
    const SESSION_EXPIRATION_SECONDS = 3600;

    /**
     * Acquire a session from the pool.
     *
     * @param string $context The type of session to fetch. May be either `r`
     *        (READ) or `rw` (READ/WRITE). **Defaults to** `r`.
     * @return Session
     * @throws \RunTimeException
     */
    public function acquire($context);

    /**
     * Release a session back to the pool.
     *
     * @param Session $session
     */
    public function release(Session $session);

    /**
     * Clear the session pool.
     */
    public function clear();

    /**
     * Set the database used to make calls to manage sessions.
     *
     * @param Database $database
     */
    public function setDatabase(Database $database);
}
