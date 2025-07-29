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

use Google\Cloud\Spanner\V1\Session as SessionProto;


/**
 * Represents and manages a Cloud Spanner Multiplexed Session.
 *
 * @internal
 */
class Session
{
    /**
     */
    public function __construct(
        private SessionPoolInterface $sessionPool,
        private SessionProto|null $session = null,
    ) {
    }

    /**
     * Format the constituent parts of a session name into a fully qualified session name.
     *
     * @return string
     */
    public function name(): string
    {
        $this->ensureValidSession();

        return $this->session->getName();
    }

    private function ensureValidSession(): void
    {
        if (!$this->session || $this->isExpired($this->session)) {
            // Acquire a new multiplex session from the pool
            $this->session = $this->sessionPool->acquire();
        }
    }

    private function isExpired(SessionProto $session): bool
    {
        $createdTimeSeconds = $this->session->getCreateTime()->getSeconds();
        return time() >=  ($createdTimeSeconds + SessionPoolInterface::SESSION_EXPIRATION_SECONDS);
    }

    /**
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'session' => $this->session,
            'sessionPool' => $this->sessionPool,
        ];
    }
}
